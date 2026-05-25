<?php
/**
 * FILE: controllers/admin/OrderController.php
 * CHỨC NĂNG: Quản lý đơn hàng cho Admin
 * 
 * CLASS: AdminOrderController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=admin&controller=order&action=index        -> danh sách đơn
 *   GET  index.php?area=admin&controller=order&action=detail&id=1 -> chi tiết đơn
 *   POST index.php?area=admin&controller=order&action=updateStatus -> cập nhật trạng thái
 *   POST index.php?area=admin&controller=order&action=updatePayment -> cập nhật thanh toán
 *   POST index.php?area=admin&controller=order&action=cancel       -> hủy đơn
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/order_index.php
 *   views/pages/admin/order_detail.php
 * 
 * CÁC STATUS ĐƠN HÀNG:
 *   pending -> confirmed -> shipping -> completed
 *   pending -> cancelled
 * 
 * YÊU CẦU: requireAdmin()
 */

require_once __DIR__ . '/../BaseController.php';

class AdminOrderController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Danh sách đơn hàng (có lọc theo status, ngày, từ khóa)
     * 
     * Output: render view với:
     *   - $title: string
     *   - $orders: array (kèm user_name)
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Chi tiết đơn hàng
     * 
     * Input:  $_GET['id']
     * Output: render view với:
     *   - $title: string
     *   - $order: array (kèm user)
     *   - $orderItems: array
     */
    public function detail()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật trạng thái đơn hàng (POST)
     * 
     * Input:  $_POST['order_id'], $_POST['status']
     * Output: redirect về detail
     * 
     * Lưu ý: Nếu chuyển sang 'cancelled' thì cần tăng lại stock
     *        (gọi Product::increaseStock cho từng item)
     */
    public function updateStatus()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật trạng thái thanh toán (POST)
     * 
     * Input:  $_POST['order_id'], $_POST['payment_status']
     * Output: redirect về detail
     */
    public function updatePayment()
    {
        // TODO: code tại đây
    }

    /**
     * Hủy đơn hàng (POST)
     * 
     * Input:  $_POST['order_id']
     * Output: redirect về index
     * 
     * Gợi ý: Order::cancel($id)
     *         Nếu hủy đơn pending thì tăng lại stock sản phẩm
     */
    public function cancel()
    {
        // TODO: code tại đây
    }
}
