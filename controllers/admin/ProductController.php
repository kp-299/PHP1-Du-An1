<?php
/**
 * FILE: controllers/admin/ProductController.php
 * CHỨC NĂNG: CRUD sản phẩm cho Admin
 * 
 * CLASS: AdminProductController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=admin&controller=product&action=index        -> danh sách SP
 *   GET  index.php?area=admin&controller=product&action=create       -> form thêm
 *   POST index.php?area=admin&controller=product&action=store        -> lưu thêm
 *   GET  index.php?area=admin&controller=product&action=edit&id=1    -> form sửa
 *   POST index.php?area=admin&controller=product&action=update       -> lưu sửa
 *   POST index.php?area=admin&controller=product&action=hide         -> ẩn
 *   POST index.php?area=admin&controller=product&action=active       -> hiện
 *   POST index.php?area=admin&controller=product&action=markOutOfStock -> hết hàng
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/product_index.php
 *   views/pages/admin/product_form.php
 * 
 * YÊU CẦU: requireAdmin()
 */

require_once __DIR__ . '/../BaseController.php';

class AdminProductController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Danh sách sản phẩm
     * 
     * Output: render view với:
     *   - $title: string
     *   - $products: array (có category_name)
     *   - $categories: array (để lọc)
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Form thêm sản phẩm
     * 
     * Output: render view với $product = null, $categories
     */
    public function create()
    {
        // TODO: code tại đây
    }

    /**
     * Lưu sản phẩm mới (POST)
     * 
     * Input:  $_POST['category_id', 'name', 'price', 'sale_price', 'stock', 'unit', 'description', 'status']
     *         $_FILES['image']
     * Output: redirect về index
     * 
     * Các bước:
     *   1. Validate (validateProduct)
     *   2. Tạo slug
     *   3. Upload ảnh
     *   4. Product::create(data)
     *   5. setFlash + redirect
     */
    public function store()
    {
        // TODO: code tại đây
    }

    /**
     * Form sửa sản phẩm
     * 
     * Input:  $_GET['id']
     * Output: render view với $product, $categories
     */
    public function edit()
    {
        // TODO: code tại đây
    }

    /**
     * Lưu cập nhật sản phẩm (POST)
     * 
     * Input:  $_POST
     * Output: redirect về index
     * 
     * Lưu ý: Nếu có upload ảnh mới thì xóa ảnh cũ
     */
    public function update()
    {
        // TODO: code tại đây
    }

    /**
     * Ẩn sản phẩm (POST)
     */
    public function hide()
    {
        // TODO: code tại đây
    }

    /**
     * Hiện sản phẩm (POST)
     */
    public function active()
    {
        // TODO: code tại đây
    }

    /**
     * Đánh dấu hết hàng (POST)
     */
    public function markOutOfStock()
    {
        // TODO: code tại đây
    }
}
