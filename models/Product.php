<?php
/**
 * FILE: models/Product.php
 * CHỨC NĂNG: Model xử lý bảng products
 * 
 * BẢNG: products
 *   id, category_id, name, slug, description, price, sale_price,
 *   stock, unit, image, status (active/hidden/out_of_stock),
 *   created_at, updated_at
 * 
 * CÁCH DÙNG:
 *   $productModel = new Product();
 *   $products = $productModel->getActiveProducts();
 *   $latest = $productModel->getLatest(8);
 */

require_once __DIR__ . '/BaseModel.php';

class Product extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'products';
    }

    /**
     * Lấy danh sách sản phẩm (có filter, join category)
     * 
     * Input:
     *   - $filters: array [
     *       'keyword'     => string (tìm theo tên),
     *       'category_id' => int (lọc theo danh mục),
     *       'status'      => string,
     *       'sort'        => string 'price_asc'|'price_desc'|'newest'|'oldest',
     *       'limit'       => int,
     *       'offset'      => int
     *     ]
     * 
     * Output: array - mỗi product có thêm category_name, category_slug
     * 
     * SQL mẫu:
     *   SELECT p.*, c.name AS category_name, c.slug AS category_slug
     *   FROM products p
     *   LEFT JOIN categories c ON p.category_id = c.id
     *   WHERE 1=1
     *   + điều kiện động
     *   ORDER BY p.id DESC
     *   LIMIT :limit OFFSET :offset
     */
    public function getAll($filters = [])
    {
        // TODO: code tại đây
    }

    /**
     * Lấy sản phẩm đang active (cho client)
     * 
     * Input:  (không tham số)
     * Output: array - sản phẩm có status = 'active'
     */
    public function getActiveProducts()
    {
        // TODO: code tại đây
    }

    /**
     * Lấy sản phẩm mới nhất
     * 
     * Input:
     *   - $limit: int (mặc định 8)
     * 
     * Output: array - $limit sản phẩm mới nhất (status = active)
     * 
     * SQL: SELECT ... FROM products WHERE status='active' ORDER BY created_at DESC LIMIT :limit
     */
    public function getLatest($limit = 8)
    {
        // TODO: code tại đây
    }

    /**
     * Tìm sản phẩm theo slug (kèm category)
     * 
     * Input:
     *   - $slug: string
     * 
     * Output: array|false - có thêm category_name, category_slug
     * 
     * SQL: SELECT p.*, c.name AS category_name, c.slug AS category_slug
     *      FROM products p
     *      LEFT JOIN categories c ON p.category_id = c.id
     *      WHERE p.slug = :slug LIMIT 1
     */
    public function findBySlug($slug)
    {
        // TODO: code tại đây
    }

    /**
     * Thêm sản phẩm mới
     * 
     * Input:
     *   - $data: array ['category_id', 'name', 'slug', 'description',
     *                    'price', 'sale_price', 'stock', 'unit', 'image', 'status']
     * 
     * Output: int|false
     */
    public function create($data)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật sản phẩm
     * 
     * Input:
     *   - $id: int
     *   - $data: array các trường cần update
     * 
     * Output: bool
     */
    public function update($id, $data)
    {
        // TODO: code tại đây
    }

    /**
     * Ẩn sản phẩm (status = 'hidden')
     * 
     * Input: $id: int
     * Output: bool
     */
    public function hide($id)
    {
        // TODO: code tại đây
    }

    /**
     * Đánh dấu hết hàng (status = 'out_of_stock')
     * 
     * Input: $id: int
     * Output: bool
     */
    public function markOutOfStock($id)
    {
        // TODO: code tại đây
    }

    /**
     * Hiện sản phẩm (status = 'active')
     * 
     * Input: $id: int
     * Output: bool
     */
    public function active($id)
    {
        // TODO: code tại đây
    }

    /**
     * Giảm số lượng tồn kho
     * 
     * Input:
     *   - $id: int
     *   - $quantity: int - số lượng cần giảm
     * 
     * Output: bool
     * 
     * SQL: UPDATE products SET stock = stock - :quantity WHERE id = :id AND stock >= :quantity
     * (Có thể check nếu stock <= 0 thì tự động markOutOfStock)
     */
    public function decreaseStock($id, $quantity)
    {
        // TODO: code tại đây
    }

    /**
     * Tăng số lượng tồn kho (khi hủy đơn)
     * 
     * Input:
     *   - $id: int
     *   - $quantity: int
     * 
     * Output: bool
     */
    public function increaseStock($id, $quantity)
    {
        // TODO: code tại đây
    }

    /**
     * Đếm sản phẩm theo status
     * 
     * Input:
     *   - $status: string 'active'|'hidden'|'out_of_stock'
     * 
     * Output: int
     */
    public function countByStatus($status)
    {
        // TODO: code tại đây
    }
}
