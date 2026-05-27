<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';

require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Order.php';

class AdminDashboardController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $userModel = new User();
        $productModel = new Product();
        $categoryModel = new Category();
        $orderModel = new Order();

        $this->renderAdmin('dashboard/index', [
            'title' => 'Tổng quan',
            'totalUsers' => $userModel->countByRole('user'),
            'totalAdmins' => $userModel->countByRole('admin'),
            'totalProducts' => $productModel->countAll(),
            'totalActiveProducts' => $productModel->countByStatus('active'),
            'totalHiddenProducts' => $productModel->countByStatus('hidden'),
            'totalOutOfStockProducts' => $productModel->countByStatus('out_of_stock'),
            'totalCategories' => $categoryModel->countAll(),
            'totalActiveCategories' => $categoryModel->countActive(),
            'totalHiddenCategories' => $categoryModel->countHidden(),
            'totalOrders' => $orderModel->countAll(),
            'pendingOrders' => $orderModel->countByStatus('pending'),
            'completedOrders' => $orderModel->countByStatus('completed'),
            'cancelledOrders' => $orderModel->countByStatus('cancelled'),
            'todayOrders' => $orderModel->getTodayOrders(),
            'countTodayOrders' => $orderModel->countTodayOrders(),
            'totalRevenue' => $orderModel->getTotalRevenue(),
        ]);
    }
}