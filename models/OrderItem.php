<?php
/**
 * FILE: models/OrderItem.php
 * CHỨC NĂNG: Model xử lý bảng order_items (chi tiết đơn hàng)
 * 
 * BẢNG: order_items
 *   id, order_id, product_id (nullable), product_name, product_price,
 *   quantity, unit, subtotal
 * 
 * LƯU Ý: Lưu product_name, product_price, unit để giữ đúng dữ liệu
 *         khi sản phẩm thay đổi giá sau này
 * 
 * CÁCH DÙNG:
 *   $orderItemModel = new OrderItem();
 *   $items = $orderItemModel->getByOrderId(1);
 */

require_once __DIR__ . '/BaseModel.php';

class OrderItem extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'order_items';
    }

    /**
     * Thêm một item vào đơn hàng
     * 
     * Input:
     *   - $data: array [
     *       'order_id'      => int,
     *       'product_id'    => int|null,
     *       'product_name'  => string,
     *       'product_price' => int|float,
     *       'quantity'      => int,
     *       'unit'          => string,
     *       'subtotal'      => int|float
     *     ]
     * 
     * Output: int|false - ID vừa insert
     * 
     * SQL: INSERT INTO order_items (...) VALUES (...)
     */
    public function create($data)
    {
        // TODO: code tại đây
    }

    /**
     * Thêm nhiều item cùng lúc (khi checkout)
     * 
     * Input:
     *   - $orderId: int - ID đơn hàng
     *   - $cartItems: array - mảng các item từ giỏ hàng
     *     Mỗi item có dạng: [
     *       'id'       => product_id,
     *       'name'     => product_name,
     *       'price'    => giá,
     *       'sale_price' => giá khuyến mãi,
     *       'quantity' => số lượng,
     *       'unit'     => đơn vị
     *     ]
     * 
     * Output: bool
     * 
     * Các bước:
     *   1. Duyệt $cartItems
     *   2. Với mỗi item, tính subtotal = price * quantity (nếu có sale_price thì dùng)
     *   3. Gọi $this->create() cho từng item
     *   4. return true
     * 
     * LƯU Ý: Có thể dùng transaction để đảm bảo toàn vẹn dữ liệu
     */
    public function createMany($orderId, $cartItems)
    {
        // TODO: code tại đây
    }

    /**
     * Lấy danh sách item theo order_id
     * 
     * Input:
     *   - $orderId: int
     * 
     * Output: array - các sản phẩm trong đơn
     * 
     * SQL: SELECT * FROM order_items WHERE order_id = :orderId
     */
    public function getByOrderId($orderId)
    {
        // TODO: code tại đây
    }

    /**
     * Xóa tất cả item của một đơn hàng
     * 
     * Input:
     *   - $orderId: int
     * 
     * Output: bool
     * 
     * SQL: DELETE FROM order_items WHERE order_id = :orderId
     */
    public function deleteByOrderId($orderId)
    {
        // TODO: code tại đây
    }
}
