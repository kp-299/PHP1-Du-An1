<?php

/**
 * FILE: models/Category.php
 * CHỨC NĂNG: Model xử lý bảng categories
 */

require_once __DIR__ . '/BaseModel.php';

class Category extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'categories';
    }

    public function getAll($filters = [])
    {
        $sql = "
            SELECT *
            FROM categories
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['keyword'])) {
            $sql .= " AND name LIKE :keyword";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
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

    public function getActive()
    {
        $sql = "
            SELECT *
            FROM categories
            WHERE status = 'active'
            ORDER BY id DESC
        ";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    public function findBySlug($slug)
    {
        $sql = "
            SELECT *
            FROM categories
            WHERE slug = :slug
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'slug' => $slug
        ]);

        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO categories (
                name,
                slug,
                description,
                image,
                status
            )
            VALUES (
                :name,
                :slug,
                :description,
                :image,
                :status
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "
            UPDATE categories
            SET
                name = :name,
                slug = :slug,
                description = :description,
                image = :image,
                status = :status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
    }

    public function hide($id)
    {
        $sql = "
            UPDATE categories
            SET status = 'hidden'
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function active($id)
    {
        $sql = "
            UPDATE categories
            SET status = 'active'
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function deleteHard($id)
    {
        $sql = "
            DELETE FROM categories
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function hasProducts($id)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM products
            WHERE category_id = :id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $result = $stmt->fetch();

        return (int) $result['total'] > 0;
    }

    public function countActive()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM categories
            WHERE status = 'active'
        ";

        $stmt = $this->db->query($sql);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function countHidden()
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM categories
            WHERE status = 'hidden'
        ";

        $stmt = $this->db->query($sql);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }
}