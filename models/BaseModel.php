<?php
/**
 * FILE: models/BaseModel.php
 * CHỨC NĂNG: Base Model - các Model khác extends class này
 * 
 * CÁC MODEL KẾ THỪA:
 *   - User, Category, Product, Order, OrderItem, Log, WebSetting
 * 
 * CÁCH DÙNG:
 *   class User extends BaseModel {
 *       public function __construct() {
 *           parent::__construct(); // gọi constructor cha
 *           $this->table = 'users'; // set tên bảng
 *       }
 *   }
 */

class BaseModel
{
    /**
     * @var PDO|null $db - Kết nối database (singleton từ DB::getInstance())
     */
    protected $db;

    /**
     * @var string $table - Tên bảng trong database (phải set ở model con)
     */
    protected $table = '';

    /**
     * Constructor - lấy kết nối DB
     * 
     * Input:  (không tham số)
     * Output: Khởi tạo $this->db = DB::getInstance()
     */
    public function __construct()
    {
        require_once __DIR__ . '/../config/connection.php';
        $this->db = DB::getInstance();
    }

    /**
     * Lấy một bản ghi theo ID
     * 
     * Input:
     *   - $id: int - ID bản ghi
     * 
     * Output: array|false - mảng dữ liệu nếu tìm thấy, false nếu không
     * 
     * SQL gợi ý:
     *   SELECT * FROM {$this->table} WHERE id = :id
     * Gợi ý:
     *   $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
     *   $stmt->execute(['id' => $id]);
     *   return $stmt->fetch();
     */
    public function find($id)
    {
        // TODO: code tại đây
    }

    /**
     * Lấy tất cả bản ghi
     * 
     * Input:  (không tham số)
     * Output: array - mảng các bản ghi
     * 
     * SQL gợi ý:
     *   SELECT * FROM {$this->table} ORDER BY id DESC
     */
    public function all()
    {
        // TODO: code tại đây
    }

    /**
     * Xóa bản ghi theo ID (xóa cứng)
     * 
     * Input:
     *   - $id: int - ID cần xóa
     * 
     * Output: bool - true nếu xóa thành công
     * 
     * SQL gợi ý:
     *   DELETE FROM {$this->table} WHERE id = :id
     */
    public function delete($id)
    {
        // TODO: code tại đây
    }

    /**
     * Đếm tổng số bản ghi
     * 
     * Input:  (không tham số)
     * Output: int - tổng số bản ghi
     * 
     * SQL gợi ý:
     *   SELECT COUNT(*) AS total FROM {$this->table}
     */
    public function countAll()
    {
        // TODO: code tại đây
    }

    /**
     * Đếm số bản ghi theo điều kiện
     * 
     * Input:
     *   - $conditions: string - điều kiện SQL (vd: "status = 'active'")
     * 
     * Output: int
     * 
     * SQL gợi ý:
     *   SELECT COUNT(*) AS total FROM {$this->table} WHERE {$conditions}
     */
    public function countByCondition($conditions)
    {
        // TODO: code tại đây
    }

    /**
     * Bắt đầu transaction (dùng cho checkout, xóa nhiều, ...)
     * 
     * Gợi ý: $this->db->beginTransaction();
     */
    public function beginTransaction()
    {
        // TODO: code tại đây
    }

    /**
     * Commit transaction
     * 
     * Gợi ý: $this->db->commit();
     */
    public function commit()
    {
        // TODO: code tại đây
    }

    /**
     * Rollback transaction (khi có lỗi)
     * 
     * Gợi ý: $this->db->rollBack();
     */
    public function rollback()
    {
        // TODO: code tại đây
    }
}
