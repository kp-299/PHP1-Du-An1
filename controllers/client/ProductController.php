<?php
/**
 * FILE: controllers/client/ProductController.php
 * CHỨC NĂNG: Xử lý danh sách sản phẩm và chi tiết sản phẩm cho Client
 * 
 * CLASS: ClientProductController
 * 
 * ROUTE MẪU:
 *   index.php?area=client&controller=product&action=index           -> danh sách SP
 *   index.php?area=client&controller=product&action=detail&slug=... -> chi tiết SP
 *   index.php?area=client&controller=product&action=search          -> tìm kiếm
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/product.php (danh sách)
 *   views/pages/productDetail.php (chi tiết)
 * 
 * CÁCH DÙNG:
 *   $products = (new Product())->getAll($filters);
 *   $product  = (new Product())->findBySlug($slug);
 */

require_once __DIR__ . '/../BaseController.php';

class ClientProductController extends BaseController
{
    protected $folder = 'pages';

    /**
     * Danh sách sản phẩm (có filter, search, sort)
     * 
     * Input:  $_GET['keyword'], $_GET['category_id'], $_GET['sort']
     * Output: render views/pages/product.php với:
     *   - $title: string
     *   - $products: array - danh sách sản phẩm
     *   - $categories: array - danh mục active (để lọc)
     *   - $keyword: string từ khóa tìm kiếm
     *   - $categoryId: int|null ID danh mục đang lọc
     *   - $sort: string kiểu sắp xếp
     * 
     * Các bước:
     *   1. Lấy các tham số filter từ $_GET
     *   2. Gọi Product::getAll($filters)
     *   3. Gọi Category::getActive()
     *   4. Render view
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Chi tiết sản phẩm
     * 
     * Input:  $_GET['slug']
     * Output: render views/pages/productDetail.php với:
     *   - $title: string tên sản phẩm
     *   - $product: array chi tiết sản phẩm (kèm category)
     * 
     * Nếu không tìm thấy sản phẩm -> redirect về trang lỗi
     */
    public function detail()
    {
        // TODO: code tại đây
    }

    /**
     * Tìm kiếm sản phẩm (có thể redirect về index với keyword)
     * 
     * Input:  $_GET['keyword']
     * Output: redirect đến product/index với keyword
     * 
     * Gợi ý: redirectClient('product', 'index', ['keyword' => $keyword])
     */
    public function search()
    {
        // TODO: code tại đây
    }

    /**
     * Lọc sản phẩm theo danh mục
     * 
     * Input:  $_GET['category_id']
     * Output: redirect đến product/index với category_id
     */
    public function category()
    {
        // TODO: code tại đây
    }
}
