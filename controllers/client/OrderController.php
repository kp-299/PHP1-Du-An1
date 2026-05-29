<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Cart.php';
require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/OrderItem.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/PaymentSetting.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';
require_once __DIR__ . '/../../helpers/validation.php';

class ClientOrderController extends BaseController
{
    protected $folder = 'pages';

    private function getCheckoutData($old = [], $errors = [])
    {
        $cartModel = new Cart();
        $settingModel = new WebSetting();
        $paymentSettingModel = new PaymentSetting();

        return [
            'title' => 'Thanh toán',
            'errors' => $errors,
            'old' => $old,
            'cartItems' => $cartModel->getItems(),
            'totalAmount' => $cartModel->getTotalAmount(),
            'settings' => $settingModel->getSimpleSettings(),
            'paymentSettings' => $paymentSettingModel->getSimpleSettings(),
            'currentUser' => currentUser(),
            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ];
    }

    public function checkout()
    {
        $cartModel = new Cart();

        if ($cartModel->isEmpty()) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Giỏ hàng đang trống.',
            ];

            header('Location: index.php?area=client&controller=cart&action=index');
            exit;
        }

        createLog('view_checkout_page');

        $this->render('checkout', $this->getCheckoutData());
    }

    public function handleCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=order&action=checkout');
            exit;
        }

        $cartModel = new Cart();

        if ($cartModel->isEmpty()) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Giỏ hàng đang trống.',
            ];

            header('Location: index.php?area=client&controller=cart&action=index');
            exit;
        }

        $paymentSettingModel = new PaymentSetting();
        $paymentSettings = $paymentSettingModel->getSimpleSettings();

        $paymentMethod = $_POST['payment_method'] ?? 'cod';

        $allowCod = ($paymentSettings['cod_enabled'] ?? '1') === '1';
        $allowQr = ($paymentSettings['qr_enabled'] ?? '1') === '1';

        $errors = validateCheckout($_POST);

        if ($paymentMethod === 'cod' && !$allowCod) {
            $errors['payment_method'] = 'Phương thức COD hiện đang tắt.';
        }

        if ($paymentMethod === 'bank_qr' && !$allowQr) {
            $errors['payment_method'] = 'Phương thức chuyển khoản QR hiện đang tắt.';
        }

        if (!in_array($paymentMethod, ['cod', 'bank_qr'], true)) {
            $errors['payment_method'] = 'Phương thức thanh toán không hợp lệ.';
        }

        if (!empty($errors)) {
            createLog('checkout_validate_failed');

            $this->render('checkout', $this->getCheckoutData($_POST, $errors));
            return;
        }

        $cartItems = $cartModel->getItems();
        $totalAmount = $cartModel->getTotalAmount();

        $orderModel = new Order();
        $orderItemModel = new OrderItem();
        $productModel = new Product();

        $orderId = $orderModel->create([
            'user_id' => currentUserId(),
            'customer_name' => trim($_POST['customer_name']),
            'customer_phone' => trim($_POST['customer_phone']),
            'customer_email' => trim($_POST['customer_email'] ?? ''),
            'customer_address' => trim($_POST['customer_address']),
            'total_amount' => $totalAmount,
            'note' => trim($_POST['note'] ?? ''),
            'payment_method' => $paymentMethod,
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        if (!$orderId) {
            createLog('create_order_failed');

            $this->render('checkout', $this->getCheckoutData($_POST, [
                'general' => 'Tạo đơn hàng thất bại, vui lòng thử lại.',
            ]));
            return;
        }

        $createdItems = $orderItemModel->createMany($orderId, $cartItems);

        if (!$createdItems) {
            createLog('create_order_items_failed_' . $orderId);

            $this->render('checkout', $this->getCheckoutData($_POST, [
                'general' => 'Tạo chi tiết đơn hàng thất bại, vui lòng thử lại.',
            ]));
            return;
        }

        foreach ($cartItems as $item) {
            $productModel->decreaseStock($item['id'], $item['quantity']);
        }

        $cartModel->clear();

        createLog('create_order_' . $orderId);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đặt hàng thành công.',
        ];

        if (isLoggedIn()) {
            header('Location: index.php?area=client&controller=order&action=detail&id=' . $orderId);
            exit;
        }

        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }

    public function history()
    {
        requireLogin();

        $orderModel = new Order();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $orders = $orderModel->getByUserId(currentUserId());
        $settings = $settingModel->getSimpleSettings();

        createLog('view_order_history');

        $this->render('orderHistory', [
            'title' => 'Lịch sử đơn hàng',
            'orders' => $orders,
            'settings' => $settings,
            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }

    public function detail()
    {
        requireLogin();

        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            header('Location: index.php?area=client&controller=order&action=history');
            exit;
        }

        $orderModel = new Order();
        $orderItemModel = new OrderItem();
        $settingModel = new WebSetting();
        $paymentSettingModel = new PaymentSetting();
        $cartModel = new Cart();

        $order = $orderModel->findByUser($orderId, currentUserId());

        if (!$order) {
            createLog('view_order_detail_forbidden_' . $orderId);

            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $orderItems = $orderItemModel->getByOrderId($orderId);
        $settings = $settingModel->getSimpleSettings();
        $paymentSettings = $paymentSettingModel->getSimpleSettings();

        createLog('view_order_detail_' . $orderId);

        $this->render('orderDetail', [
            'title' => 'Chi tiết đơn hàng',
            'order' => $order,
            'orderItems' => $orderItems,
            'settings' => $settings,
            'paymentSettings' => $paymentSettings,
            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }

    public function cancel()
    {
        requireLogin();

        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            header('Location: index.php?area=client&controller=order&action=history');
            exit;
        }

        $orderModel = new Order();

        $order = $orderModel->findByUser($orderId, currentUserId());

        if (!$order) {
            createLog('cancel_order_forbidden_' . $orderId);

            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        if ($order['status'] === 'pending') {
            $orderModel->cancel($orderId);
            createLog('cancel_order_' . $orderId);

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Đã hủy đơn hàng.',
            ];
        }

        header('Location: index.php?area=client&controller=order&action=history');
        exit;
    }
}
