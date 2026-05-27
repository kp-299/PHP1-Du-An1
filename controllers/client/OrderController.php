<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Cart.php';
require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/OrderItem.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/WebSetting.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';
require_once __DIR__ . '/../../helpers/validation.php';

class ClientOrderController extends BaseController
{
    protected $folder = 'pages';

    public function checkout()
    {
        $cartModel = new Cart();
        $settingModel = new WebSetting();

        if ($cartModel->isEmpty()) {
            header('Location: index.php?area=client&controller=cart&action=index');
            exit;
        }

        $cartItems = $cartModel->getItems();
        $totalAmount = $cartModel->getTotalAmount();
        $settings = $settingModel->getSimpleSettings();

        $this->render('checkout', [
            'title' => 'Thanh toán',
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
            'settings' => $settings,
            'currentUser' => currentUser(),
        ]);
    }

    public function handleCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=order&action=checkout');
            exit;
        }

        $cartModel = new Cart();

        if ($cartModel->isEmpty()) {
            header('Location: index.php?area=client&controller=cart&action=index');
            exit;
        }

        $errors = validateCheckout($_POST);

        if (!empty($errors)) {
            $this->render('checkout', [
                'title' => 'Thanh toán',
                'errors' => $errors,
                'old' => $_POST,
                'cartItems' => $cartModel->getItems(),
                'totalAmount' => $cartModel->getTotalAmount(),
                'currentUser' => currentUser(),
            ]);
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
            'customer_address' => trim($_POST['customer_address']),
            'total_amount' => $totalAmount,
            'note' => trim($_POST['note'] ?? ''),
            'payment_method' => $_POST['payment_method'] ?? 'cod',
            'payment_status' => 'unpaid',
            'status' => 'pending',
        ]);

        $orderItemModel->createMany($orderId, $cartItems);

        foreach ($cartItems as $item) {
            $productModel->decreaseStock($item['id'], $item['quantity']);
        }

        $cartModel->clear();

        createLog('create_order');

        if (isLoggedIn()) {
            header('Location: index.php?area=client&controller=order&action=history');
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

        $orders = $orderModel->getByUserId(currentUserId());
        $settings = $settingModel->getSimpleSettings();

        $this->render('orderHistory', [
            'title' => 'Lịch sử đơn hàng',
            'orders' => $orders,
            'settings' => $settings,
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

        $order = $orderModel->find($orderId);

        if (!$order || $order['user_id'] != currentUserId()) {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $orderItems = $orderItemModel->getByOrderId($orderId);
        $settings = $settingModel->getSimpleSettings();

        $this->render('orderDetail', [
            'title' => 'Chi tiết đơn hàng',
            'order' => $order,
            'orderItems' => $orderItems,
            'settings' => $settings,
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

        $order = $orderModel->find($orderId);

        if (!$order || $order['user_id'] != currentUserId()) {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        if ($order['status'] === 'pending') {
            $orderModel->cancel($orderId);
            createLog('cancel_order');
        }

        header('Location: index.php?area=client&controller=order&action=history');
        exit;
    }
}