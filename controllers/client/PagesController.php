<?php
/**
 * FILE: controllers/client/PagesController.php
 * CHỨC NĂNG: Xử lý các trang tĩnh cho Client (home, contact, about, ...)
 * 
 * CLASS: ClientPagesController
 * 
 * ROUTE MẪU:
 *   index.php?area=client&controller=pages&action=home
 *   index.php?area=client&controller=pages&action=contact
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/home.php
 *   views/pages/contact.php
 * 
 * CÁCH DÙNG:
 *   $controller = new ClientPagesController();
 *   $controller->home();
 */

require_once __DIR__ . '/../BaseController.php';

class ClientPagesController extends BaseController
{
    protected $folder = 'pages';

    /**
     * Trang chủ - Hiển thị sản phẩm mới + danh mục
     * 
     * Input:  (dựa vào $_GET)
     * Output: render view pages/home với các biến:
     *   - $title: string 'Trang chủ'
     *   - $products: array - 8 sản phẩm mới nhất (Product::getLatest(8))
     *   - $categories: array - danh mục active (Category::getActive())
     *   - $settings: array - web settings dạng key=>value
     * 
     * Các bước cần code:
     *   1. require_once các model cần dùng (Product, Category, WebSetting)
     *   2. Lấy dữ liệu từ model
     *   3. Gọi $this->render('home', [...])
     */
    public function home()
    {
        // TODO: code tại đây
    }

    /**
     * Trang liên hệ
     * 
     * Output: render views/pages/contact.php
     *   - $title: string 'Liên hệ'
     *   - $settings: array
     */
    public function contact()
    {
        // TODO: code tại đây
    }

    /**
     * Trang lỗi 404
     * 
     * Output: render views/pages/error.php
     *   - $title: string '404 - Không tìm thấy trang'
     */
    public function error()
    {
        // TODO: code tại đây
    }
}
