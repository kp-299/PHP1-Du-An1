<?php

require_once __DIR__ . '/BaseModel.php';

class Video extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'videos';
    }

    public function getAll($filters = [])
    {
        $sql = "SELECT v.*, u.name AS author_name
                FROM videos v
                LEFT JOIN users u ON v.author_id = u.id
                WHERE 1=1";

        $params = [];

        if (!empty($filters['keyword'])) {
            $sql .= " AND (v.title LIKE :keyword OR v.description LIKE :keyword)";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        if (!empty($filters['status'])) {
            $sql .= " AND v.status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['video_type'])) {
            $sql .= " AND v.video_type = :video_type";
            $params['video_type'] = $filters['video_type'];
        }

        $sql .= " ORDER BY v.id DESC";

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
            "SELECT v.*, u.name AS author_name
             FROM videos v
             LEFT JOIN users u ON v.author_id = u.id
             WHERE v.slug = :slug
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
            "INSERT INTO videos 
                (title, slug, video_type, thumbnail, video_file, video_url, description, duration, author_id, status)
             VALUES 
                (:title, :slug, :video_type, :thumbnail, :video_file, :video_url, :description, :duration, :author_id, :status)"
        );

        $success = $stmt->execute([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'video_type' => $data['video_type'] ?? 'short',
            'thumbnail' => $data['thumbnail'] ?? null,
            'video_file' => $data['video_file'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'description' => $data['description'] ?? null,
            'duration' => $data['duration'] ?? null,
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
            "UPDATE videos
             SET 
                title = :title,
                slug = :slug,
                video_type = :video_type,
                thumbnail = :thumbnail,
                video_file = :video_file,
                video_url = :video_url,
                description = :description,
                duration = :duration,
                status = :status
             WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'title' => $data['title'],
            'slug' => $data['slug'],
            'video_type' => $data['video_type'] ?? 'short',
            'thumbnail' => $data['thumbnail'] ?? null,
            'video_file' => $data['video_file'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'description' => $data['description'] ?? null,
            'duration' => $data['duration'] ?? null,
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    public function publish($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE videos SET status = 'published' WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function hide($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE videos SET status = 'hidden' WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function draft($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE videos SET status = 'draft' WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function increaseView($id)
    {
        $stmt = $this->db->prepare(
            "UPDATE videos SET view_count = view_count + 1 WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function countByStatus($status)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) AS total FROM videos WHERE status = :status"
        );

        $stmt->execute([
            'status' => $status
        ]);

        $row = $stmt->fetch();

        return (int) ($row['total'] ?? 0);
    }

    public function countByType($type)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) AS total FROM videos WHERE video_type = :video_type"
        );

        $stmt->execute([
            'video_type' => $type
        ]);

        $row = $stmt->fetch();

        return (int) ($row['total'] ?? 0);
    }

    public function getPublished($limit = 10)
    {
        $stmt = $this->db->prepare(
            "SELECT *
             FROM videos
             WHERE status = 'published'
             ORDER BY id DESC
             LIMIT :limit"
        );

        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}