<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/Cart.php';

class ClientUserController extends BaseController
{
    protected $folder = 'pages';

    private function getDashboardData($errors = [], $old = [])
    {
        $userModel = new User();
        $orderModel = new Order();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $userId = currentUserId();

        $user = $userModel->findById($userId);

        if (!$user) {
            $user = currentUser();
        }

        $orders = $orderModel->getByUserId($userId);
        $currentOrders = $orderModel->getCurrentByUserId($userId);

        return [
            'title' => 'Tài khoản của tôi',
            'settings' => $settingModel->getSimpleSettings(),

            'user' => $user,
            'orders' => $orders,
            'currentOrders' => $currentOrders,

            'errors' => $errors,
            'old' => $old,

            'activeTab' => $_GET['tab'] ?? 'overview',

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ];
    }

    public function profile()
    {
        requireLogin();

        createLog('view_user_dashboard');

        $this->render('userDashboard', $this->getDashboardData());
    }

    public function updateProfile()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=user&action=profile&tab=profile');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        $errors = [];

        if ($name === '') {
            $errors['name'] = 'Tên không được để trống.';
        } elseif (mb_strlen($name) < 2) {
            $errors['name'] = 'Tên tối thiểu 2 ký tự.';
        }

        if ($phone !== '' && !preg_match('/^(0|\+84)[0-9]{9,10}$/', $phone)) {
            $errors['phone'] = 'Số điện thoại không hợp lệ.';
        }

        if (!empty($errors)) {
            $_GET['tab'] = 'profile';

            $this->render('userDashboard', $this->getDashboardData($errors, $_POST));
            return;
        }

        $userModel = new User();

        $userModel->updateProfile(currentUserId(), [
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
        ]);

        $_SESSION['user']['name'] = $name;

        createLog('update_user_profile');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã cập nhật thông tin tài khoản.',
        ];

        header('Location: index.php?area=client&controller=user&action=profile&tab=profile');
        exit;
    }

    public function changePassword()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=user&action=profile&tab=security');
            exit;
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        $userModel = new User();
        $user = $userModel->findById(currentUserId());

        if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
            $errors['current_password'] = 'Mật khẩu hiện tại không đúng.';
        }

        if (strlen($newPassword) < 6) {
            $errors['new_password'] = 'Mật khẩu mới tối thiểu 6 ký tự.';
        }

        if ($newPassword !== $confirmPassword) {
            $errors['confirm_password'] = 'Mật khẩu nhập lại không khớp.';
        }

        if (!empty($errors)) {
            $_GET['tab'] = 'security';

            $this->render('userDashboard', $this->getDashboardData($errors, $_POST));
            return;
        }

        $userModel->updatePassword(currentUserId(), password_hash($newPassword, PASSWORD_DEFAULT));

        createLog('change_user_password');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã đổi mật khẩu.',
        ];

        header('Location: index.php?area=client&controller=user&action=profile&tab=security');
        exit;
    }
}
