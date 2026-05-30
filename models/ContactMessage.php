<?php

require_once __DIR__ . '/BaseModel.php';

class ContactMessage extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'contact_messages';
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO contact_messages (
                name, email, phone, subject, message,
                status, ip_address, browser, created_at
            )
            VALUES (
                :name, :email, :phone, :subject, :message,
                :status, :ip_address, :browser, NOW()
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => $data['status'] ?? 'new',
            'ip_address' => $data['ip_address'] ?? null,
            'browser' => $data['browser'] ?? null,
        ]);

        return $result ? $this->db->lastInsertId() : false;
    }

    public function getAll($filters = [])
    {
        $sql = "
            SELECT *
            FROM contact_messages
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= "
                AND (
                    name LIKE :keyword
                    OR email LIKE :keyword
                    OR phone LIKE :keyword
                    OR subject LIKE :keyword
                    OR message LIKE :keyword
                )
            ";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }

        $sql .= " ORDER BY created_at DESC, id DESC";

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
            FROM contact_messages
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= "
                AND (
                    name LIKE :keyword
                    OR email LIKE :keyword
                    OR phone LIKE :keyword
                    OR subject LIKE :keyword
                    OR message LIKE :keyword
                )
            ";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['date_from'])) {
            $sql .= " AND DATE(created_at) >= :date_from";
            $params['date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND DATE(created_at) <= :date_to";
            $params['date_to'] = $filters['date_to'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function findById($id)
    {
        $sql = "
            SELECT *
            FROM contact_messages
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'id' => $id,
        ]);

        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $sql = "
            UPDATE contact_messages
            SET status = :status, updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'status' => $status,
        ]);
    }

    public function updateNote($id, $adminNote)
    {
        $sql = "
            UPDATE contact_messages
            SET admin_note = :admin_note, updated_at = NOW()
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'admin_note' => $adminNote,
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM contact_messages WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
        ]);
    }
}
