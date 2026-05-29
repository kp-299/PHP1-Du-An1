<?php

/**
 * FILE: models/Product.php
 * CHỨC NĂNG: Model xử lý bảng products
 */

require_once __DIR__ . '/BaseModel.php';

class Product extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'products';
    }

    public function getAll($filters = [])
    {
        $sql = "
            SELECT 
                p.*,
                c.name AS category_name,
                c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND p.name LIKE :keyword";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['category_slug'])) {
            $sql .= " AND c.slug = :category_slug";
            $params['category_slug'] = $filters['category_slug'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND p.status = :status";
            $params['status'] = $filters['status'];
        }

        $sort = $filters['sort'] ?? 'newest';

        switch ($sort) {
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC";
                break;

            case 'price_desc':
                $sql .= " ORDER BY p.price DESC";
                break;

            case 'oldest':
                $sql .= " ORDER BY p.id ASC";
                break;

            case 'newest':
            default:
                $sql .= " ORDER BY p.id DESC";
                break;
        }

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

    public function getActiveProducts()
    {
        return $this->getAll([
            'status' => 'active'
        ]);
    }

    public function getLatest($limit = 8)
    {
        $sql = "
            SELECT 
                p.*,
                c.name AS category_name,
                c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.status = 'active'
            ORDER BY p.created_at DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findBySlug($slug)
    {
        $sql = "
            SELECT 
                p.*,
                c.name AS category_name,
                c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.slug = :slug
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
            INSERT INTO products (
                category_id,
                name,
                slug,
                description,
                price,
                sale_price,
                stock,
                unit,
                image,
                status
            )
            VALUES (
                :category_id,
                :name,
                :slug,
                :description,
                :price,
                :sale_price,
                :stock,
                :unit,
                :image,
                :status
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'unit' => $data['unit'] ?? 'kg',
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
            UPDATE products
            SET
                category_id = :category_id,
                name = :name,
                slug = :slug,
                description = :description,
                price = :price,
                sale_price = :sale_price,
                stock = :stock,
                unit = :unit,
                image = :image,
                status = :status
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'category_id' => $data['category_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'unit' => $data['unit'] ?? 'kg',
            'image' => $data['image'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
    }

    public function hide($id)
    {
        $sql = "
            UPDATE products
            SET status = 'hidden'
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function markOutOfStock($id)
    {
        $sql = "
            UPDATE products
            SET status = 'out_of_stock'
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
            UPDATE products
            SET status = 'active'
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function decreaseStock($id, $quantity)
    {
        $sql = "
            UPDATE products
            SET stock = stock - :quantity
            WHERE id = :id
            AND stock >= :quantity
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'id' => $id,
            'quantity' => $quantity
        ]);

        if (!$result) {
            return false;
        }

        $product = $this->find($id);

        if ($product && (int) $product['stock'] <= 0) {
            $this->markOutOfStock($id);
        }

        return true;
    }

    public function increaseStock($id, $quantity)
    {
        $sql = "
            UPDATE products
            SET stock = stock + :quantity
            WHERE id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'quantity' => $quantity
        ]);
    }

    public function countByStatus($status)
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM products
            WHERE status = :status
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'status' => $status
        ]);

        $result = $stmt->fetch();

        return (int) $result['total'];
    }

    public function countFiltered($filters = [])
    {
        $sql = "SELECT COUNT(*) AS total
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.status = 'active'";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND p.name LIKE :keyword";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['stock_filter'])) {
            if ($filters['stock_filter'] === 'in_stock') {
                $sql .= " AND p.stock > 0";
            }

            if ($filters['stock_filter'] === 'out_of_stock') {
                $sql .= " AND p.stock <= 0";
            }
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $row = $stmt->fetch();

        return (int) ($row['total'] ?? 0);
    }

    public function getClientProducts($filters = [])
    {
        $sql = "SELECT p.*, c.name AS category_name, c.slug AS category_slug
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.status = 'active'";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND p.name LIKE :keyword";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['category_id'])) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $filters['category_id'];
        }

        if (!empty($filters['stock_filter'])) {
            if ($filters['stock_filter'] === 'in_stock') {
                $sql .= " AND p.stock > 0";
            }

            if ($filters['stock_filter'] === 'out_of_stock') {
                $sql .= " AND p.stock <= 0";
            }
        }

        $sort = $filters['sort'] ?? 'newest';

        if ($sort === 'price_asc') {
            $sql .= " ORDER BY COALESCE(NULLIF(p.sale_price, 0), p.price) ASC";
        } elseif ($sort === 'price_desc') {
            $sql .= " ORDER BY COALESCE(NULLIF(p.sale_price, 0), p.price) DESC";
        } elseif ($sort === 'oldest') {
            $sql .= " ORDER BY p.id ASC";
        } else {
            $sql .= " ORDER BY p.id DESC";
        }

        $sql .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->bindValue(':limit', (int) ($filters['limit'] ?? 18), PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) ($filters['offset'] ?? 0), PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findDetailById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id
         WHERE p.id = :id
         LIMIT 1"
        );

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch();
    }

    public function getRelatedProducts($categoryId, $exceptId, $limit = 12)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.name AS category_name, c.slug AS category_slug
         FROM products p
         LEFT JOIN categories c ON p.category_id = c.id
         WHERE p.status = 'active'
           AND p.category_id = :category_id
           AND p.id != :id
         ORDER BY p.id DESC
         LIMIT :limit"
        );

        $stmt->bindValue(':category_id', (int) $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':id', (int) $exceptId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getImages($productId)
    {
        try {
            $stmt = $this->db->prepare(
                "SELECT * FROM product_images
             WHERE product_id = :product_id
             ORDER BY id ASC"
            );

            $stmt->execute([
                'product_id' => $productId
            ]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }
}
