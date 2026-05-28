<?php

/**
 * FILE: models/BaseModel.php
 * CHỨC NĂNG: Base Model - các Model khác extends class này
 */

class BaseModel
{
    /**
     * @var PDO|null $db - Kết nối database
     */
    protected $db;

    /**
     * @var string $table - Tên bảng trong database
     */
    protected $table = '';

    /**
     * Constructor - lấy kết nối DB
     */
    public function __construct()
    {
        require_once __DIR__ . '/../config/connection.php';

        $this->db = DB::getInstance();
    }

    /**
     * Kiểm tra model con đã set tên bảng chưa
     */
    protected function checkTable()
    {
        if ($this->table === '') {
            die('Model chưa khai báo tên bảng.');
        }
    }

    /**
     * Lấy một bản ghi theo ID
     */
    public function find($id)
    {
        $this->checkTable();

        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    /**
     * Lấy tất cả bản ghi
     */
    public function all()
    {
        $this->checkTable();

        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Xóa bản ghi theo ID
     */
    public function delete($id)
    {
        $this->checkTable();

        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    /**
     * Đếm tổng số bản ghi
     */
    public function countAll()
    {
        $this->checkTable();

        $sql = "SELECT COUNT(*) AS total FROM {$this->table}";

        $stmt = $this->db->query($sql);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    /**
     * Đếm số bản ghi theo điều kiện
     *
     * Ví dụ:
     * $this->countByCondition("status = 'active'")
     */
    public function countByCondition($conditions)
    {
        $this->checkTable();

        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE {$conditions}";

        $stmt = $this->db->query($sql);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    /**
     * Bắt đầu transaction
     */
    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public function commit()
    {
        return $this->db->commit();
    }

    /**
     * Rollback transaction
     */
    public function rollback()
    {
        return $this->db->rollBack();
    }
}