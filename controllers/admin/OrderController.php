<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/OrderItem.php';

class AdminOrderController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $orderModel = new Order();

        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'status' => $_GET['status'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
        ];

        $orders = $orderModel->getAllOrders($filters);

        $this->renderAdmin('orders/index', [
            'title' => 'Quản lý đơn hàng',
            'orders' => $orders,
            'filters' => $filters,
        ]);
    }

    public function detail()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $orderModel = new Order();
        $orderItemModel = new OrderItem();

        $order = $orderModel->findWithUser($id);

        if (!$order) {
            header('Location: index.php?area=admin&controller=order&action=index');
            exit;
        }

        $orderItems = $orderItemModel->getByOrderId($id);

        $this->renderAdmin('orders/detail', [
            'title' => 'Chi tiết đơn hàng',
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }

    public function updateStatus()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=order&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? 'pending';

        $orderModel = new Order();
        $orderModel->updateStatus($id, $status);

        createLog('update_order_status');

        header('Location: index.php?area=admin&controller=order&action=detail&id=' . $id);
        exit;
    }

    public function updatePaymentStatus()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=order&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $paymentStatus = $_POST['payment_status'] ?? 'unpaid';

        $orderModel = new Order();
        $orderModel->updatePaymentStatus($id, $paymentStatus);

        createLog('update_payment_status');

        header('Location: index.php?area=admin&controller=order&action=detail&id=' . $id);
        exit;
    }

    public function cancel()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $orderModel = new Order();
        $orderModel->cancel($id);

        createLog('cancel_order_by_admin');

        header('Location: index.php?area=admin&controller=order&action=index');
        exit;
    }
}