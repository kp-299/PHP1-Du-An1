<?php
/**
 * FILE: controllers/client/CartController.php
 * CHỨC NĂNG: Xử lý giỏ hàng - thêm, sửa, xóa, xem giỏ
 * 
 * CLASS: ClientCartController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=client&controller=cart&action=index   -> xem giỏ hàng
 *   POST index.php?area=client&controller=cart&action=add     -> thêm SP
 *   POST index.php?area=client&controller=cart&action=update  -> cập nhật SL
 *   POST index.php?area=client&controller=cart&action=remove  -> xóa SP
 *   POST index.php?area=client&controller=cart&action=clear   -> xóa toàn bộ
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/cart.php
 * 
 * CÁCH DÙNG:
 *   $cart = new Cart();
 *   $cart->add($productId, $quantity);
 *   $items = $cart->getItems();
 */

require_once __DIR__ . '/../BaseController.php';

class ClientCartController extends BaseController
{
    protected $folder = 'pages';

    /**
     * Hiển thị giỏ hàng
     * 
     * Output: render views/pages/cart.php với:
     *   - $title: string 'Giỏ hàng'
     *   - $cartItems: array danh sách sản phẩm
     *   - $totalAmount: int|float tổng tiền
     *   - $totalQuantity: int tổng số lượng
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Thêm sản phẩm vào giỏ (POST)
     * 
     * Input:  $_POST['product_id'], $_POST['quantity'] (mặc định 1)
     * Output: redirect về trang trước hoặc giỏ hàng
     * 
     * Các bước:
     *   1. Lấy product_id, quantity từ $_POST
     *   2. (new Cart())->add($productId, $quantity)
     *   3. setFlash('success', 'Đã thêm vào giỏ hàng')
     *   4. redirectBack()
     */
    public function add()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật số lượng (POST)
     * 
     * Input:  $_POST['product_id'], $_POST['quantity']
     * Output: redirect về giỏ hàng
     * 
     * Gợi ý:
     *   (new Cart())->update($productId, $quantity);
     *   redirectClient('cart', 'index');
     */
    public function update()
    {
        // TODO: code tại đây
    }

    /**
     * Xóa sản phẩm khỏi giỏ (POST)
     * 
     * Input:  $_POST['product_id']
     * Output: redirect về giỏ hàng
     */
    public function remove()
    {
        // TODO: code tại đây
    }

    /**
     * Xóa toàn bộ giỏ hàng (POST)
     * 
     * Output: redirect về giỏ hàng (giỏ rỗng)
     */
    public function clear()
    {
        // TODO: code tại đây
    }
}
