<?php
/**
 * FILE: models/Order.php
 * CHỨC NĂNG: Model xử lý bảng orders (đơn hàng)
 * 
 * BẢNG: orders
 *   id, user_id (nullable), customer_name, customer_phone, customer_address,
 *   total_amount, note, status (pending/confirmed/shipping/completed/cancelled),
 *   payment_method (cod/bank_transfer), payment_status (unpaid/paid),
 *   created_at, updated_at
 * 
 * CÁC STATUS:
 *   pending     - chờ xác nhận
 *   confirmed   - đã xác nhận
 *   shipping    - đang giao
 *   completed   - đã giao
 *   cancelled   - đã hủy
 * 
 * CÁCH DÙNG:
 *   $orderModel = new Order();
 *   $orderId = $orderModel->create($orderData);
 *   $orders = $orderModel->getAllOrders(['status' => 'pending']);
 */

require_once __DIR__ . '/BaseModel.php';

class Order extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'orders';
    }

    /**
     * Tạo đơn hàng mới
     * 
     * Input:
     *   - $data: array [
     *       'user_id'         => int|null,
     *       'customer_name'    => string,
     *       'customer_phone'   => string,
     *       'customer_address' => string,
     *       'total_amount'     => int|float,
     *       'note'            => string (optional),
     *       'payment_method'  => string (mặc định 'cod'),
     *       'payment_status'  => string (mặc định 'unpaid'),
     *       'status'          => string (mặc định 'pending')
     *     ]
     * 
     * Output: int|false - ID đơn hàng vừa tạo
     * 
     * SQL: INSERT INTO orders (...) VALUES (...)
     */
    public function create($data)
    {
        // TODO: code tại đây
    }

    /**
     * Lấy danh sách đơn hàng (có filter, join user)
     * 
     * Input:
     *   - $filters: array [
     *       'status'    => string,
     *       'keyword'   => string (tìm theo tên/SĐT),
     *       'date_from' => string (Y-m-d),
     *       'date_to'   => string (Y-m-d),
     *       'limit'     => int,
     *       'offset'    => int
     *     ]
     * 
     * Output: array - mỗi order có thêm user_name, user_email nếu có user_id
     * 
     * SQL:
     *   SELECT o.*, u.name AS user_name, u.email AS user_email
     *   FROM orders o
     *   LEFT JOIN users u ON o.user_id = u.id
     *   WHERE 1=1 + điều kiện động
     *   ORDER BY o.created_at DESC
     */
    public function getAllOrders($filters = [])
    {
        // TODO: code tại đây
    }

    /**
     * Lấy đơn hàng theo user_id
     * 
     * Input:
     *   - $userId: int
     * 
     * Output: array - danh sách đơn hàng của user đó
     * 
     * SQL: SELECT * FROM orders WHERE user_id = :userId ORDER BY created_at DESC
     */
    public function getByUserId($userId)
    {
        // TODO: code tại đây
    }

    /**
     * Tìm đơn hàng kèm thông tin user
     * 
     * Input:
     *   - $id: int
     * 
     * Output: array|false - chi tiết đơn hàng + user_name, user_email
     * 
     * SQL: SELECT o.*, u.name AS user_name, u.email AS user_email
     *      FROM orders o
     *      LEFT JOIN users u ON o.user_id = u.id
     *      WHERE o.id = :id LIMIT 1
     */
    public function findWithUser($id)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật trạng thái đơn hàng
     * 
     * Input:
     *   - $id: int
     *   - $status: string (pending|confirmed|shipping|completed|cancelled)
     * 
     * Output: bool
     * 
     * SQL: UPDATE orders SET status = :status WHERE id = :id
     */
    public function updateStatus($id, $status)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật trạng thái thanh toán
     * 
     * Input:
     *   - $id: int
     *   - $paymentStatus: string (unpaid|paid)
     * 
     * Output: bool
     */
    public function updatePaymentStatus($id, $paymentStatus)
    {
        // TODO: code tại đây
    }

    /**
     * Hủy đơn hàng
     * 
     * Input:
     *   - $id: int
     * 
     * Output: bool
     * 
     * Chỉ cho hủy đơn có status = 'pending'
     * SQL: UPDATE orders SET status = 'cancelled' WHERE id = :id AND status = 'pending'
     */
    public function cancel($id)
    {
        // TODO: code tại đây
    }

    /**
     * Đếm đơn hàng theo trạng thái
     * 
     * Input:
     *   - $status: string
     * 
     * Output: int
     */
    public function countByStatus($status)
    {
        // TODO: code tại đây
    }

    /**
     * Tính tổng doanh thu (các đơn đã completed)
     * 
     * Input:  (không tham số)
     * Output: int|float - tổng total_amount của các đơn completed
     * 
     * SQL: SELECT COALESCE(SUM(total_amount), 0) FROM orders WHERE status = 'completed'
     */
    public function getTotalRevenue()
    {
        // TODO: code tại đây
    }

    /**
     * Lấy đơn hàng hôm nay
     * 
     * Input:  (không tham số)
     * Output: array - danh sách đơn trong ngày
     * 
     * SQL: SELECT * FROM orders WHERE DATE(created_at) = CURDATE() ORDER BY created_at DESC
     */
    public function getTodayOrders()
    {
        // TODO: code tại đây
    }

    /**
     * Đếm đơn hàng hôm nay
     * 
     * Output: int
     */
    public function countTodayOrders()
    {
        // TODO: code tại đây
    }
}
