<?php
/**
 * FILE: controllers/admin/CategoryController.php
 * CHỨC NĂNG: CRUD danh mục (category) cho Admin
 * 
 * CLASS: AdminCategoryController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=admin&controller=category&action=index     -> danh sách
 *   GET  index.php?area=admin&controller=category&action=create    -> form thêm
 *   POST index.php?area=admin&controller=category&action=store     -> lưu thêm
 *   GET  index.php?area=admin&controller=category&action=edit&id=1 -> form sửa
 *   POST index.php?area=admin&controller=category&action=update    -> lưu sửa
 *   POST index.php?area=admin&controller=category&action=hide      -> ẩn
 *   POST index.php?area=admin&controller=category&action=active    -> hiện
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/category_index.php
 *   views/pages/admin/category_form.php
 * 
 * YÊU CẦU: requireAdmin() cho tất cả action
 */

require_once __DIR__ . '/../BaseController.php';

class AdminCategoryController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Danh sách danh mục
     * 
     * Output: render view với $categories: array
     *   - $title: string 'Quản lý danh mục'
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Hiển thị form thêm danh mục
     * 
     * Output: render view category_form.php với $category = null (form rỗng)
     */
    public function create()
    {
        // TODO: code tại đây
    }

    /**
     * Lưu danh mục mới (POST)
     * 
     * Input:  $_POST['name'], $_POST['description'], $_POST['status']
     * Output: redirect về index
     * 
     * Các bước:
     *   1. Validate (validateCategory)
     *   2. Tạo slug (createSlug)
     *   3. Category::create(data)
     *   4. Upload ảnh nếu có
     *   5. setFlash + redirect
     */
    public function store()
    {
        // TODO: code tại đây
    }

    /**
     * Hiển thị form sửa danh mục
     * 
     * Input:  $_GET['id']
     * Output: render view category_form.php với $category: array
     */
    public function edit()
    {
        // TODO: code tại đây
    }

    /**
     * Lưu cập nhật danh mục (POST)
     * 
     * Input:  $_POST['id'], $_POST['name'], ...
     * Output: redirect về index
     */
    public function update()
    {
        // TODO: code tại đây
    }

    /**
     * Ẩn danh mục (POST)
     * 
     * Input:  $_POST['id']
     * Output: redirect về index
     */
    public function hide()
    {
        // TODO: code tại đây
    }

    /**
     * Hiện danh mục (POST)
     * 
     * Input:  $_POST['id']
     * Output: redirect về index
     */
    public function active()
    {
        // TODO: code tại đây
    }
}
