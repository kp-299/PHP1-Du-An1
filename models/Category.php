<?php
/**
 * FILE: models/Category.php
 * CHỨC NĂNG: Model xử lý bảng categories (danh mục sản phẩm)
 * 
 * BẢNG: categories
 *   id, name, slug, description, image,
 *   status (active/hidden), created_at, updated_at
 * 
 * CÁCH DÙNG:
 *   $categoryModel = new Category();
 *   $categories = $categoryModel->getActive();
 */

require_once __DIR__ . '/BaseModel.php';

class Category extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'categories';
    }

    /**
     * Lấy danh sách danh mục (có filter)
     * 
     * Input:
     *   - $filters: array [
     *       'status'  => string (optional),
     *       'keyword' => string (optional),
     *       'limit'   => int,
     *       'offset'  => int
     *     ]
     * 
     * Output: array
     * 
     * SQL: SELECT * FROM categories WHERE 1=1 + điều kiện động, ORDER BY id DESC
     */
    public function getAll($filters = [])
    {
        // TODO: code tại đây
    }

    /**
     * Lấy danh mục đang active (cho client)
     * 
     * Input:  (không tham số)
     * Output: array - danh sách categories có status = 'active'
     * 
     * SQL: SELECT * FROM categories WHERE status = 'active' ORDER BY id DESC
     */
    public function getActive()
    {
        // TODO: code tại đây
    }

    /**
     * Tìm danh mục theo slug
     * 
     * Input:
     *   - $slug: string
     * 
     * Output: array|false
     * 
     * SQL: SELECT * FROM categories WHERE slug = :slug LIMIT 1
     */
    public function findBySlug($slug)
    {
        // TODO: code tại đây
    }

    /**
     * Thêm danh mục mới
     * 
     * Input:
     *   - $data: array ['name', 'slug', 'description', 'image', 'status']
     * 
     * Output: int|false - ID vừa tạo
     * 
     * SQL: INSERT INTO categories (name, slug, ...) VALUES (...)
     */
    public function create($data)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật danh mục
     * 
     * Input:
     *   - $id: int
     *   - $data: array ['name', 'slug', 'description', 'image', 'status']
     * 
     * Output: bool
     * 
     * SQL: UPDATE categories SET ... WHERE id = :id
     */
    public function update($id, $data)
    {
        // TODO: code tại đây
    }

    /**
     * Ẩn danh mục (set status = 'hidden')
     * 
     * Input:
     *   - $id: int
     * 
     * Output: bool
     * 
     * SQL: UPDATE categories SET status = 'hidden' WHERE id = :id
     */
    public function hide($id)
    {
        // TODO: code tại đây
    }

    /**
     * Hiện danh mục (set status = 'active')
     * 
     * Input:
     *   - $id: int
     * 
     * Output: bool
     * 
     * SQL: UPDATE categories SET status = 'active' WHERE id = :id
     */
    public function active($id)
    {
        // TODO: code tại đây
    }

    /**
     * Xóa cứng danh mục (dùng nếu cần xóa thật)
     * 
     * Input:
     *   - $id: int
     * 
     * Output: bool
     * 
     * SQL: DELETE FROM categories WHERE id = :id
     */
    public function deleteHard($id)
    {
        // TODO: code tại đây
    }

    /**
     * Kiểm tra danh mục có sản phẩm không
     * 
     * Input:
     *   - $id: int
     * 
     * Output: bool - true nếu có sản phẩm
     * 
     * SQL: SELECT COUNT(*) FROM products WHERE category_id = :id
     */
    public function hasProducts($id)
    {
        // TODO: code tại đây
    }

    /**
     * Đếm danh mục active
     * 
     * Output: int
     */
    public function countActive()
    {
        // TODO: code tại đây
    }

    /**
     * Đếm danh mục hidden
     * 
     * Output: int
     */
    public function countHidden()
    {
        // TODO: code tại đây
    }
}
