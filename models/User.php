<?php

/**
 * FILE: models/User.php
 * CHỨC NĂNG: Model xử lý bảng users
 */

require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'users';
    }

    public function findByEmail($email)
    {
        $sql = "
            SELECT *
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO users (
                name,
                email,
                password_hash,
                phone,
                address,
                role,
                avatar,
                status
            )
            VALUES (
                :name,
                :email,
                :password_hash,
                :phone,
                :address,
                :role,
                :avatar,
                :status
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'role' => $data['role'] ?? 'user',
            'avatar' => $data['avatar'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function updateProfile($id, $data)
    {
        $sql = "
            UPDATE users
            SET
                name = :name,
                phone = :phone,
                address = :address,
                avatar = :avatar
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'avatar' => $data['avatar'] ?? null,
        ]);
    }

    public function updatePassword($id, $passwordHash)
    {
        $sql = "
            UPDATE users
            SET password_hash = :password_hash
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'password_hash' => $passwordHash
        ]);
    }

    public function getAllUsers($filters = [])
    {
        $sql = "
            SELECT 
                id,
                name,
                email,
                phone,
                address,
                role,
                avatar,
                status,
                created_at,
                updated_at
            FROM users
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= "
                AND (
                    name LIKE :keyword
                    OR email LIKE :keyword
                    OR phone LIKE :keyword
                )
            ";

            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['role'])) {
            $sql .= " AND role = :role";
            $params['role'] = $filters['role'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        $sql .= " ORDER BY id DESC";

        if (isset($filters['limit'])) {
            $sql .= " LIMIT :limit";

            if (isset($filters['offset'])) {
                $sql .= " OFFSET :offset";
            }
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        if (isset($filters['limit'])) {
            $stmt->bindValue(':limit', (int) $filters['limit'], PDO::PARAM_INT);

            if (isset($filters['offset'])) {
                $stmt->bindValue(':offset', (int) $filters['offset'], PDO::PARAM_INT);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function updateStatus($id, $status)
    {
        $sql = "
            UPDATE users
            SET status = :status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    }

    public function updateRole($id, $role)
    {
        $sql = "
            UPDATE users
            SET role = :role
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'role' => $role
        ]);
    }

    public function countByRole($role)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM users
            WHERE role = :role
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'role' => $role
        ]);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }
}