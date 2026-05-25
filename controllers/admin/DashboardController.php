<?php
/**
 * FILE: controllers/admin/DashboardController.php
 * CHỨC NĂNG: Dashboard admin - hiển thị tổng quan
 * 
 * CLASS: AdminDashboardController
 * 
 * ROUTE:
 *   index.php?area=admin&controller=dashboard&action=index
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/dashboard.php
 * 
 * YÊU CẦU: requireAdmin()
 * 
 * DỮ LIỆU CẦN LẤY:
 *   - totalUsers: tổng user (User::countAll())
 *   - totalProducts: tổng sản phẩm active (Product::countByStatus('active'))
 *   - totalOrders: tổng đơn hàng (Order::countAll())
 *   - totalRevenue: tổng doanh thu (Order::getTotalRevenue())
 *   - todayOrders: đơn hôm nay (Order::countTodayOrders())
 */

require_once __DIR__ . '/../BaseController.php';

class AdminDashboardController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Trang tổng quan admin
     * 
     * Output: render views/pages/admin/dashboard.php với:
     *   - $title: string 'Dashboard'
     *   - $totalUsers: int
     *   - $totalProducts: int
     *   - $totalOrders: int
     *   - $totalRevenue: int|float
     *   - $todayOrders: int
     */
    public function index()
    {
        // TODO: code tại đây
    }
}
