<?php

require_once __DIR__ . '/BaseModel.php';

class Post extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'posts';
    }

    public function getAll($filters = [])
    {
        $sql = "SELECT p.*, u.name AS author_name
                FROM posts p
                LEFT JOIN users u ON p.author_id = u.id
                WHERE 1=1";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND (p.title LIKE :keyword OR p.summary LIKE :keyword)";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND p.status = :status";
            $params['status'] = $filters['status'];
        }

        $sql .= " ORDER BY p.id DESC";

        if (isset($filters['limit'])) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        if (isset($filters['limit'])) {
            $stmt->bindValue(':limit', (int) $filters['limit'], PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) ($filters['offset'] ?? 0), PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findBySlug($slug)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, u.name AS author_name
             FROM posts p
             LEFT JOIN users u ON p.author_id = u.id
             WHERE p.slug = :slug
             LIMIT 1"
        );

        $stmt->execute([
            'slug' => $slug
        ]);

        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO posts 
                (title, slug, thumbnail, summary, content, author_id, status)
             VALUES 
                (:title, :slug, :thumbnail, :summary, :content, :author_id, :status)"
        );

        $success = $stmt->execute([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'thumbnail' => $data['thumbnail'] ?? null,
            'summary' => $data['summary'] ?? null,
            'content' => $data['content'],
            'author_id' => $data['author_id'] ?? null,
            'status' => $data['status'] ?? 'draft',
        ]);

        if ($success) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare(
            "UPDATE posts
             SET 
                title = :title,
                slug = :slug,
                thumbnail = :thumbnail,
                summary = :summary,
                content = :content,
                status = :status
             WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'thumbnail' => $data['thumbnail'] ?? null,
            'summary' => $data['summary'] ?? null,
            'content' => $data['content'],
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    public function publish($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE posts SET status = 'published' WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function hide($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE posts SET status = 'hidden' WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function draft($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE posts SET status = 'draft' WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function increaseView($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE posts SET view_count = view_count + 1 WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countByStatus($status)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) AS total FROM posts WHERE status = :status"
        );

        $stmt->execute([
            'status' => $status
        ]);

        $row = $stmt->fetch();

        return (int) ($row['total'] ?? 0);
    }

    public function getPublished($limit = 10)
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM posts
             WHERE status = 'published'
             ORDER BY id DESC
             LIMIT :limit"
        );

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countFiltered($filters = [])
    {
        $sql = "SELECT COUNT(*) AS total FROM posts WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['keyword'])) {
            $sql .= " AND (title LIKE :keyword OR summary LIKE :keyword OR content LIKE :keyword)";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $row = $stmt->fetch();

        return (int)($row['total'] ?? 0);
    }

    public function getRandom($limit = 5)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, u.name AS author_name
         FROM posts p
         LEFT JOIN users u ON p.author_id = u.id
         WHERE p.status = 'published'
         ORDER BY RAND()
         LIMIT :limit"
        );

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getRelated($exceptId, $limit = 6)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, u.name AS author_name
         FROM posts p
         LEFT JOIN users u ON p.author_id = u.id
         WHERE p.status = 'published'
           AND p.id != :id
         ORDER BY p.id DESC
         LIMIT :limit"
        );

        $stmt->bindValue(':id', (int) $exceptId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
