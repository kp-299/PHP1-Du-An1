<?php

/**
 * FILE: models/Log.php
 * CHỨC NĂNG: Model xử lý bảng logs
 */

require_once __DIR__ . '/BaseModel.php';

class Log extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'logs';
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO logs (
                user_id,
                action,
                ip_address,
                browser,
                url,
                method
            )
            VALUES (
                :user_id,
                :action,
                :ip_address,
                :browser,
                :url,
                :method
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'user_id' => $data['user_id'] ?? null,
            'action' => $data['action'],
            'ip_address' => $data['ip_address'] ?? null,
            'browser' => $data['browser'] ?? null,
            'url' => $data['url'] ?? null,
            'method' => $data['method'] ?? null,
        ]);

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function getAllLogs($filters = [])
    {
        $sql = "
            SELECT 
                l.*,
                u.name AS user_name,
                u.email AS user_email
            FROM logs l
            LEFT JOIN users u ON l.user_id = u.id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['action'])) {
            $sql .= " AND l.action = :action";
            $params['action'] = $filters['action'];
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND l.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(l.created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(l.created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }

        $sql .= " ORDER BY l.created_at DESC";

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

    public function clearAll()
    {
        $sql = "DELETE FROM logs";

        return $this->db->exec($sql) !== false;
    }

    public function clearOld($days = 30)
    {
        $sql = "
            DELETE FROM logs
            WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':days', (int) $days, PDO::PARAM_INT);

        return $stmt->execute();
    }
}