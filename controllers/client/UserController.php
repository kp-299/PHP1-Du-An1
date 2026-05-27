<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/WebSetting.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/upload.php';
require_once __DIR__ . '/../../helpers/log.php';

class ClientUserController extends BaseController
{
    protected $folder = 'pages';

    public function profile()
    {
        requireLogin();

        $userModel = new User();
        $orderModel = new Order();
        $settingModel = new WebSetting();

        $user = $userModel->find(currentUserId());
        $orders = $orderModel->getByUserId(currentUserId());
        $settings = $settingModel->getSimpleSettings();

        $this->render('profile', [
            'title' => 'Thông tin tài khoản',
            'user' => $user,
            'orders' => $orders,
            'settings' => $settings,
        ]);
    }

    public function editProfile()
    {
        requireLogin();

        $userModel = new User();
        $settingModel = new WebSetting();

        $user = $userModel->find(currentUserId());
        $settings = $settingModel->getSimpleSettings();

        $this->render('editProfile', [
            'title' => 'Cập nhật thông tin',
            'user' => $user,
            'settings' => $settings,
        ]);
    }

    public function updateProfile()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=user&action=editProfile');
            exit;
        }

        $userModel = new User();

        $oldUser = $userModel->find(currentUserId());

        if (!$oldUser) {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        if ($name === '') {
            $this->render('editProfile', [
                'title' => 'Cập nhật thông tin',
                'user' => $oldUser,
                'errors' => [
                    'name' => 'Tên không được để trống',
                ],
            ]);
            return;
        }

        $avatar = $oldUser['avatar'];

        $newAvatar = uploadImage($_FILES['avatar'] ?? null, 'users');

        if ($newAvatar) {
            $avatar = $newAvatar;
        }

        $userModel->updateProfile(currentUserId(), [
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'avatar' => $avatar,
        ]);

        $_SESSION['user']['name'] = $name;

        createLog('update_profile');

        header('Location: index.php?area=client&controller=user&action=profile');
        exit;
    }

    public function changePassword()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=user&action=profile');
            exit;
        }

        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $userModel = new User();

        $user = $userModel->find(currentUserId());

        if (!$user || !password_verify($oldPassword, $user['password_hash'])) {
            die('Mật khẩu cũ không đúng');
        }

        if (strlen($newPassword) < 6) {
            die('Mật khẩu mới phải có ít nhất 6 ký tự');
        }

        if ($newPassword !== $confirmPassword) {
            die('Mật khẩu xác nhận không khớp');
        }

        $userModel->updatePassword(
            currentUserId(),
            password_hash($newPassword, PASSWORD_DEFAULT)
        );

        createLog('change_password');

        header('Location: index.php?area=client&controller=user&action=profile');
        exit;
    }
}