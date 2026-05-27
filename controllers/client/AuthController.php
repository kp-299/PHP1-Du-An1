<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/User.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';
require_once __DIR__ . '/../../helpers/validation.php';

class ClientAuthController extends BaseController
{
    protected $folder = 'pages';

    public function login()
    {
        requireGuest();

        $this->render('login', [
            'title' => 'Đăng nhập',
        ]);
    }

    public function register()
    {
        requireGuest();

        $this->render('register', [
            'title' => 'Đăng ký',
        ]);
    }

    public function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=auth&action=register');
            exit;
        }

        $errors = validateRegister($_POST);

        if (!empty($errors)) {
            $this->render('register', [
                'title' => 'Đăng ký',
                'errors' => $errors,
                'old' => $_POST,
            ]);
            return;
        }

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $userModel = new User();

        if ($userModel->findByEmail($email)) {
            $this->render('register', [
                'title' => 'Đăng ký',
                'errors' => [
                    'email' => 'Email đã tồn tại',
                ],
                'old' => $_POST,
            ]);
            return;
        }

        $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',
        ]);

        createLog('register');

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }

    public function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=auth&action=login');
            exit;
        }

        $errors = validateLogin($_POST);

        if (!empty($errors)) {
            $this->render('login', [
                'title' => 'Đăng nhập',
                'errors' => $errors,
                'old' => $_POST,
            ]);
            return;
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $userModel = new User();

        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->render('login', [
                'title' => 'Đăng nhập',
                'errors' => [
                    'login' => 'Email hoặc mật khẩu không đúng',
                ],
                'old' => $_POST,
            ]);
            return;
        }

        if ($user['status'] === 'blocked') {
            $this->render('login', [
                'title' => 'Đăng nhập',
                'errors' => [
                    'login' => 'Tài khoản của bạn đã bị khóa',
                ],
                'old' => $_POST,
            ]);
            return;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];

        createLog('login');

        if ($user['role'] === 'admin') {
            header('Location: index.php?area=admin&controller=dashboard&action=index');
            exit;
        }

        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }

    public function logout()
    {
        createLog('logout');

        unset($_SESSION['user']);

        session_regenerate_id(true);

        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }
}