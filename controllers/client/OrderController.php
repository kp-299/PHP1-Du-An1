<?php
/**
 * FILE: controllers/client/OrderController.php
 * CHỨC NĂNG: Xử lý đặt hàng (checkout), lịch sử đơn hàng, chi tiết đơn
 * 
 * CLASS: ClientOrderController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=client&controller=order&action=checkout  -> form thanh toán
 *   POST index.php?area=client&controller=order&action=place    -> xử lý đặt hàng
 *   GET  index.php?area=client&controller=order&action=history  -> lịch sử đơn
 *   GET  index.php?area=client&controller=order&action=detail&id=1 -> chi tiết đơn
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/checkout.php
 *   views/pages/order_history.php
 *   views/pages/order_detail.php
 * 
 * LƯU ĐỒ XỬ LÝ CHECKOUT:
 *   checkout(): hiện form thanh toán
 *     - Nếu giỏ hàng rỗng -> redirect về giỏ + flash
 *     - Nếu user đã login -> tự điền thông tin
 *   
 *   place(): xử lý đặt hàng
 *     1. Check POST, validate
 *     2. Lấy thông tin từ $_POST
 *     3. Tính total_amount từ Cart
 *     4. Bắt đầu transaction (DB::beginTransaction)
 *     5. Order::create(data)
 *     6. OrderItem::createMany(orderId, cartItems)
 *     7. foreach cart items: Product::decreaseStock
 *     8. Cart::clear()
 *     9. Commit transaction
 *     10. createLog('create_order')
 *     11. setFlash + redirect order detail
 * 
 * YÊU CẦU: Phải có giỏ hàng mới được checkout
 */

require_once __DIR__ . '/../BaseController.php';

class ClientOrderController extends BaseController
{
    protected $folder = 'pages';

    /**
     * Hiển thị form thanh toán
     * 
     * Output: render views/pages/checkout.php với:
     *   - $title: string 'Thanh toán'
     *   - $cartItems: array
     *   - $totalAmount: float
     *   - $currentUser: array|null (nếu đã login)
     * 
     * Nếu giỏ rỗng thì redirect về giỏ hàng
     */
    public function checkout()
    {
        // TODO: code tại đây
    }

    /**
     * Xử lý đặt hàng (POST)
     * 
     * Input:  $_POST['customer_name'], $_POST['customer_phone'],
     *         $_POST['customer_address'], $_POST['note'], $_POST['payment_method']
     * Output: redirect đến trang chi tiết đơn hàng nếu thành công
     *         hoặc quay lại checkout với lỗi
     */
    public function place()
    {
        // TODO: code tại đây
    }

    /**
     * Lịch sử đơn hàng (yêu cầu đăng nhập)
     * 
     * Output: render views/pages/order_history.php với:
     *   - $title: string 'Lịch sử đơn hàng'
     *   - $orders: array đơn hàng của user hiện tại
     * 
     * Yêu cầu: requireLogin()
     */
    public function history()
    {
        // TODO: code tại đây
    }

    /**
     * Chi tiết đơn hàng (yêu cầu đăng nhập)
     * 
     * Input:  $_GET['id']
     * Output: render views/pages/order_detail.php với:
     *   - $title: string 'Chi tiết đơn hàng'
     *   - $order: array thông tin đơn
     *   - $orderItems: array sản phẩm trong đơn
     * 
     * Kiểm tra: đơn hàng phải thuộc về user hiện tại
     */
    public function detail()
    {
        // TODO: code tại đây
    }
}
