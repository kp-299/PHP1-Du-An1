<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/redirect.php';

require_once __DIR__ . '/../../models/User.php';

class ClientAuthController extends BaseController
{
    public function login()
    {
        $this->renderAuth('login', [
            'title' => 'Đăng nhập',
            'errors' => [],
            'old' => [],
        ]);
    }

    public function register()
    {
        $this->renderAuth('register', [
            'title' => 'Đăng ký',
            'errors' => [],
            'old' => [],
        ]);
    }

    public function handleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=auth&action=login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if ($email === '') {
            $errors['email'] = 'Email không được để trống';
        }

        if ($password === '') {
            $errors['password'] = 'Mật khẩu không được để trống';
        }

        if (!empty($errors)) {
            $this->renderAuth('login', [
                'title' => 'Đăng nhập',
                'errors' => $errors,
                'old' => $_POST,
            ]);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->renderAuth('login', [
                'title' => 'Đăng nhập',
                'errors' => [
                    'general' => 'Email hoặc mật khẩu không đúng',
                ],
                'old' => $_POST,
            ]);
            return;
        }

        if (($user['status'] ?? '') !== 'active') {
            $this->renderAuth('login', [
                'title' => 'Đăng nhập',
                'errors' => [
                    'general' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt',
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
            'status' => $user['status'],
        ];

        if (($user['role'] ?? '') === 'admin') {
            header('Location: index.php?area=admin&controller=dashboard&action=index');
            exit;
        }

        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }

    public function handleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=auth&action=register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Tên không được để trống';
        }

        if ($email === '') {
            $errors['email'] = 'Email không được để trống';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }

        if ($password === '') {
            $errors['password'] = 'Mật khẩu không được để trống';
        } elseif (strlen($password) < 6) {
            $errors['password'] = 'Mật khẩu tối thiểu 6 ký tự';
        }

        if ($confirmPassword === '') {
            $errors['confirm_password'] = 'Vui lòng nhập lại mật khẩu';
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Mật khẩu nhập lại không khớp';
        }

        $userModel = new User();

        if ($email !== '' && $userModel->findByEmail($email)) {
            $errors['email'] = 'Email này đã được sử dụng';
        }

        if (!empty($errors)) {
            $this->renderAuth('register', [
                'title' => 'Đăng ký',
                'errors' => $errors,
                'old' => $_POST,
            ]);
            return;
        }

        $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'phone' => '',
            'address' => '',
            'role' => 'user',
            'status' => 'active',
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đăng ký thành công, vui lòng đăng nhập',
        ];

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }

    public function logout()
    {
        unset($_SESSION['user']);

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }
}
