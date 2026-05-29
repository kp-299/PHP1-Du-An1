<?php

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
                method,
                created_at
            )
            VALUES (
                :user_id,
                :action,
                :ip_address,
                :browser,
                :url,
                :method,
                NOW()
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'user_id' => $data['user_id'] ?? null,
            'action' => $data['action'] ?? 'unknown',
            'ip_address' => $data['ip_address'] ?? null,
            'browser' => $data['browser'] ?? null,
            'url' => $data['url'] ?? null,
            'method' => $data['method'] ?? null,
        ]);

        return $result ? $this->db->lastInsertId() : false;
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

        if (!empty($filters['log_action'])) {
            $sql .= " AND l.action LIKE :log_action";
            $params['log_action'] = '%' . $filters['log_action'] . '%';
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND l.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }

        if (!empty($filters['method'])) {
            $sql .= " AND l.method = :method";
            $params['method'] = $filters['method'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(l.created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(l.created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }

        $sql .= " ORDER BY l.created_at DESC, l.id DESC";

        if (isset($filters['limit'])) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        if (isset($filters['limit'])) {
            $stmt->bindValue(':limit', (int)$filters['limit'], PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)($filters['offset'] ?? 0), PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countFiltered($filters = [])
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM logs l
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['log_action'])) {
            $sql .= " AND l.action LIKE :log_action";
            $params['log_action'] = '%' . $filters['log_action'] . '%';
        }

        if (!empty($filters['user_id'])) {
            $sql .= " AND l.user_id = :user_id";
            $params['user_id'] = $filters['user_id'];
        }

        if (!empty($filters['method'])) {
            $sql .= " AND l.method = :method";
            $params['method'] = $filters['method'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(l.created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(l.created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function clearAll()
    {
        return $this->db->exec("DELETE FROM logs") !== false;
    }

    public function clearOld($days = 30)
    {
        $stmt = $this->db->prepare("
            DELETE FROM logs
            WHERE created_at < DATE_SUB(NOW(), INTERVAL :days DAY)
        ");

        $stmt->bindValue(':days', (int)$days, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
