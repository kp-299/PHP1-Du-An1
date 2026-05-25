<?php
/**
 * FILE: models/User.php
 * CHỨC NĂNG: Model xử lý bảng users (user + admin)
 * 
 * BẢNG: users
 *   id, name, email, password_hash, phone, address,
 *   role (user/admin), avatar, status (active/blocked),
 *   created_at, updated_at
 * 
 * CÁCH DÙNG:
 *   $userModel = new User();
 *   $user = $userModel->findByEmail('test@gmail.com');
 */

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'users';
    }

    /**
     * Tìm user theo email
     * 
     * Input:
     *   - $email: string
     * 
     * Output: array|false - thông tin user hoặc false nếu không tìm thấy
     * 
     * SQL: SELECT * FROM users WHERE email = :email LIMIT 1
     */
    public function findByEmail($email)
    {
        // TODO: code tại đây
    }

    /**
     * Tạo user mới
     * 
     * Input:
     *   - $data: array [
     *       'name'          => string,
     *       'email'         => string,
     *       'password_hash' => string (đã hash = password_hash()),
     *       'phone'         => string (optional),
     *       'address'       => string (optional),
     *       'role'          => string (mặc định 'user'),
     *       'status'        => string (mặc định 'active')
     *     ]
     * 
     * Output: int|false - ID vừa insert hoặc false nếu lỗi
     * 
     * SQL: INSERT INTO users (...) VALUES (...)
     * Gợi ý dùng: $this->db->lastInsertId() để lấy ID
     */
    public function create($data)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật thông tin user (không bao gồm password)
     * 
     * Input:
     *   - $id: int
     *   - $data: array ['name', 'phone', 'address', ...]
     * 
     * Output: bool
     * 
     * SQL: UPDATE users SET name=:name, phone=:phone, ... WHERE id=:id
     */
    public function updateProfile($id, $data)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật mật khẩu
     * 
     * Input:
     *   - $id: int
     *   - $passwordHash: string - password_hash() mới
     * 
     * Output: bool
     * 
     * SQL: UPDATE users SET password_hash=:password_hash WHERE id=:id
     */
    public function updatePassword($id, $passwordHash)
    {
        // TODO: code tại đây
    }

    /**
     * Lấy danh sách users (có filter)
     * 
     * Input:
     *   - $filters: array [
     *       'keyword' => string (optional - tìm theo name/email),
     *       'role'    => string (optional - 'user'/'admin'),
     *       'status'  => string (optional - 'active'/'blocked'),
     *       'limit'   => int (optional),
     *       'offset'  => int (optional)
     *     ]
     * 
     * Output: array - danh sách users
     * 
     * SQL gợi ý: SELECT * FROM users WHERE 1=1 + các điều kiện động
     *   Nếu có keyword: AND (name LIKE :keyword OR email LIKE :keyword)
     *   Nếu có role: AND role = :role
     *   ORDER BY id DESC
     */
    public function getAllUsers($filters = [])
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật trạng thái (active/blocked)
     * 
     * Input:
     *   - $id: int
     *   - $status: string 'active' hoặc 'blocked'
     * 
     * Output: bool
     * 
     * SQL: UPDATE users SET status=:status WHERE id=:id
     */
    public function updateStatus($id, $status)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật role (user/admin)
     * 
     * Input:
     *   - $id: int
     *   - $role: string 'user' hoặc 'admin'
     * 
     * Output: bool
     */
    public function updateRole($id, $role)
    {
        // TODO: code tại đây
    }

    /**
     * Đếm số user theo role
     * 
     * Input:
     *   - $role: string 'user' hoặc 'admin'
     * 
     * Output: int
     * 
     * SQL: SELECT COUNT(*) FROM users WHERE role = :role
     */
    public function countByRole($role)
    {
        // TODO: code tại đây
    }
}
