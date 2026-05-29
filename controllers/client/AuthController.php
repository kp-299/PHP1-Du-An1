<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/redirect.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/WebSetting.php';

class ClientAuthController extends BaseController
{
    private function getSettings()
    {
        $settingModel = new WebSetting();
        return $settingModel->getSimpleSettings();
    }

    public function login()
    {
        guestOnly();

        $this->renderAuth('login', [
            'title' => 'Đăng nhập',
            'settings' => $this->getSettings(),
            'errors' => [],
            'old' => [],
        ]);
    }

    public function register()
    {
        guestOnly();

        $this->renderAuth('register', [
            'title' => 'Đăng ký',
            'settings' => $this->getSettings(),
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
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }

        if ($password === '') {
            $errors['password'] = 'Mật khẩu không được để trống';
        }

        if (!empty($errors)) {
            createLog('login_validate_failed');

            $this->renderAuth('login', [
                'title' => 'Đăng nhập',
                'settings' => $this->getSettings(),
                'errors' => $errors,
                'old' => [
                    'email' => $email,
                ],
            ]);
            return;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            createLog('login_failed');

            $this->renderAuth('login', [
                'title' => 'Đăng nhập',
                'settings' => $this->getSettings(),
                'errors' => [
                    'general' => 'Email hoặc mật khẩu không đúng',
                ],
                'old' => [
                    'email' => $email,
                ],
            ]);
            return;
        }

        if (($user['status'] ?? '') !== 'active') {
            createLog('login_blocked_inactive_user', $user['id']);

            $this->renderAuth('login', [
                'title' => 'Đăng nhập',
                'settings' => $this->getSettings(),
                'errors' => [
                    'general' => 'Tài khoản của bạn đã bị khóa hoặc chưa được kích hoạt',
                ],
                'old' => [
                    'email' => $email,
                ],
            ]);
            return;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'status' => $user['status'],
        ];

        createLog('login_success', $user['id']);

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
        } elseif (mb_strlen($name) < 2) {
            $errors['name'] = 'Tên tối thiểu 2 ký tự';
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

        if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $userModel->findByEmail($email)) {
            $errors['email'] = 'Email này đã được sử dụng';
        }

        if (!empty($errors)) {
            createLog('register_validate_failed');

            $this->renderAuth('register', [
                'title' => 'Đăng ký',
                'settings' => $this->getSettings(),
                'errors' => $errors,
                'old' => [
                    'name' => $name,
                    'email' => $email,
                ],
            ]);
            return;
        }

        $createdId = $userModel->create([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'phone' => '',
            'address' => '',
            'role' => 'user',
            'status' => 'active',
        ]);

        if (!$createdId) {
            createLog('register_failed');

            $this->renderAuth('register', [
                'title' => 'Đăng ký',
                'settings' => $this->getSettings(),
                'errors' => [
                    'general' => 'Đăng ký thất bại, vui lòng thử lại',
                ],
                'old' => [
                    'name' => $name,
                    'email' => $email,
                ],
            ]);
            return;
        }

        createLog('register_success', $createdId);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đăng ký thành công, vui lòng đăng nhập',
        ];

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }

    public function logout()
    {
        createLog('logout');

        unset($_SESSION['user']);

        session_regenerate_id(true);

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }
}
