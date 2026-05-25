<?php
/**
 * FILE: models/Cart.php
 * CHỨC NĂNG: Model xử lý giỏ hàng (dùng session, không dùng DB)
 * 
 * LƯU TRỮ: $_SESSION['cart'] - mảng các item
 * 
 * Mỗi item trong cart có cấu trúc:
 *   [
 *       'id'       => int (product_id),
 *       'name'     => string,
 *       'slug'     => string,
 *       'price'    => int|float (giá hiện tại),
 *       'sale_price' => int|float|null,
 *       'unit'     => string,
 *       'image'    => string,
 *       'quantity' => int
 *   ]
 * 
 * CÁCH DÙNG:
 *   $cart = new Cart();
 *   $cart->add(1);          // thêm sản phẩm ID 1
 *   $cart->add(1, 3);       // thêm 3 cái
 *   $items = $cart->getItems();
 *   $total = $cart->getTotalAmount();
 * 
 * LƯU Ý: Cart KHÔNG extends BaseModel vì không dùng DB
 */

class Cart
{
    /**
     * Lấy danh sách sản phẩm trong giỏ
     * 
     * Input:  (dựa vào $_SESSION['cart'])
     * Output: array - mảng các item, mỗi item có cấu trúc như trên
     *         Nếu chưa có session cart thì trả về []
     * Gợi ý: return $_SESSION['cart'] ?? [];
     */
    public function getItems()
    {
        // TODO: code tại đây
    }

    /**
     * Thêm sản phẩm vào giỏ
     * 
     * Input:
     *   - $productId: int - ID sản phẩm
     *   - $quantity: int (mặc định 1) - số lượng thêm
     * 
     * Output: void
     * 
     * Các bước cần code:
     *   1. Nếu chưa có $_SESSION['cart'] thì khởi tạo = []
     *   2. Kiểm tra sản phẩm đã có trong giỏ chưa (duyệt theo id)
     *   3. Nếu có rồi: tăng quantity lên
     *   4. Nếu chưa: lấy thông tin sản phẩm từ DB (Product model)
     *      và thêm vào $_SESSION['cart']
     * 
     * LƯU Ý: Có thể cần require Product model để lấy thông tin
     */
    public function add($productId, $quantity = 1)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     * 
     * Input:
     *   - $productId: int
     *   - $quantity: int - số lượng mới (nếu <= 0 thì xóa khỏi giỏ)
     * 
     * Output: void
     */
    public function update($productId, $quantity)
    {
        // TODO: code tại đây
    }

    /**
     * Xóa sản phẩm khỏi giỏ
     * 
     * Input:
     *   - $productId: int
     * 
     * Output: void
     * Gợi ý: dùng array_filter hoặc duyệt mảng để xóa
     */
    public function remove($productId)
    {
        // TODO: code tại đây
    }

    /**
     * Xóa toàn bộ giỏ hàng
     * 
     * Input:  (không tham số)
     * Output: void
     * Gợi ý: unset($_SESSION['cart'])
     */
    public function clear()
    {
        // TODO: code tại đây
    }

    /**
     * Tính tổng số lượng sản phẩm trong giỏ
     * 
     * Input:  (dựa vào $_SESSION['cart'])
     * Output: int - tổng quantity của tất cả items
     * Gợi ý: array_sum(array_column($_SESSION['cart'], 'quantity'))
     */
    public function getTotalQuantity()
    {
        // TODO: code tại đây
    }

    /**
     * Tính tổng tiền giỏ hàng
     * 
     * Input:  (dựa vào $_SESSION['cart'])
     * Output: int|float - tổng tiền (giá * số lượng)
     *         Nếu có sale_price thì dùng sale_price, nếu không thì dùng price
     * Gợi ý:
     *   $total = 0;
     *   foreach ($items as $item) {
     *       $price = $item['sale_price'] > 0 ? $item['sale_price'] : $item['price'];
     *       $total += $price * $item['quantity'];
     *   }
     */
    public function getTotalAmount()
    {
        // TODO: code tại đây
    }

    /**
     * Kiểm tra giỏ hàng có rỗng không
     * 
     * Input:  (dựa vào $_SESSION['cart'])
     * Output: bool - true nếu rỗng
     */
    public function isEmpty()
    {
        // TODO: code tại đây
    }
}
