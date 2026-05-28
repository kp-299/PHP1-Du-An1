<?php

/**
 * FILE: models/Order.php
 * CHỨC NĂNG: Model xử lý bảng orders
 */

require_once __DIR__ . '/BaseModel.php';

class Order extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'orders';
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO orders (
                user_id,
                customer_name,
                customer_phone,
                customer_address,
                total_amount,
                note,
                status,
                payment_method,
                payment_status
            )
            VALUES (
                :user_id,
                :customer_name,
                :customer_phone,
                :customer_address,
                :total_amount,
                :note,
                :status,
                :payment_method,
                :payment_status
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'user_id' => $data['user_id'] ?? null,
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_address' => $data['customer_address'],
            'total_amount' => $data['total_amount'],
            'note' => $data['note'] ?? null,
            'status' => $data['status'] ?? 'pending',
            'payment_method' => $data['payment_method'] ?? 'cod',
            'payment_status' => $data['payment_status'] ?? 'unpaid',
        ]);

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function getAllOrders($filters = [])
    {
        $sql = "
            SELECT 
                o.*,
                u.name AS user_name,
                u.email AS user_email
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND o.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['keyword'])) {
            $sql .= "
                AND (
                    o.customer_name LIKE :keyword
                    OR o.customer_phone LIKE :keyword
                    OR u.name LIKE :keyword
                    OR u.email LIKE :keyword
                )
            ";

            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(o.created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(o.created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }

        $sql .= " ORDER BY o.created_at DESC";

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

    public function getByUserId($userId)
    {
        $sql = "
            SELECT *
            FROM orders
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function findWithUser($id)
    {
        $sql = "
            SELECT 
                o.*,
                u.name AS user_name,
                u.email AS user_email
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $sql = "
            UPDATE orders
            SET status = :status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    }

    public function updatePaymentStatus($id, $paymentStatus)
    {
        $sql = "
            UPDATE orders
            SET payment_status = :payment_status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'payment_status' => $paymentStatus
        ]);
    }

    public function cancel($id)
    {
        $sql = "
            UPDATE orders
            SET status = 'cancelled'
            WHERE id = :id
            AND status = 'pending'
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countByStatus($status)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM orders
            WHERE status = :status
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'status' => $status
        ]);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function getTotalRevenue()
    {
        $sql = "
            SELECT COALESCE(SUM(total_amount), 0) AS total
            FROM orders
            WHERE status = 'completed'
        ";

        $stmt = $this->db->query($sql);

        $result = $stmt->fetch();

        return (float) $result['total'];
    }

    public function getTodayOrders()
    {
        $sql = "
            SELECT *
            FROM orders
            WHERE DATE(created_at) = CURDATE()
            ORDER BY created_at DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function countTodayOrders()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM orders
            WHERE DATE(created_at) = CURDATE()
        ";

        $stmt = $this->db->query($sql);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }
}