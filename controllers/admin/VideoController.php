<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/slug.php';
require_once __DIR__ . '/../../helpers/upload.php';

require_once __DIR__ . '/../../models/Video.php';

class AdminVideoController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $videoModel = new Video();

        $keyword = trim($_GET['keyword'] ?? '');
        $videoType = trim($_GET['video_type'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $filters = [
            'keyword' => $keyword,
            'video_type' => $videoType,
            'status' => $status,
            'limit' => 100,
            'offset' => 0,
        ];

        $videos = $videoModel->getAll($filters);

        $this->renderAdmin('videos/index', [
            'title' => 'Quản lý video',
            'videos' => $videos,
            'filters' => [
                'keyword' => $keyword,
                'video_type' => $videoType,
                'status' => $status,
            ],
        ]);
    }

    public function create()
    {
        requireAdmin();

        $this->renderAdmin('videos/create', [
            'title' => 'Thêm video',
            'errors' => [],
            'old' => [
                'video_type' => 'short',
                'status' => 'draft',
            ],
        ]);
    }

    public function store()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=video&action=create');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $videoType = trim($_POST['video_type'] ?? 'short');
        $videoUrl = trim($_POST['video_url'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $status = trim($_POST['status'] ?? 'draft');

        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tiêu đề không được để trống';
        }

        if (!in_array($videoType, ['short', 'long'])) {
            $errors['video_type'] = 'Loại video không hợp lệ';
        }

        if (!in_array($status, ['draft', 'published', 'hidden'])) {
            $errors['status'] = 'Trạng thái không hợp lệ';
        }

        if ($videoUrl === '') {
            $errors['video_url'] = 'Vui lòng nhập link YouTube';
        } elseif (!$this->isValidYoutubeUrl($videoUrl)) {
            $errors['video_url'] = 'Link YouTube không hợp lệ';
        }

        $thumbnail = '';

        if (!empty($_FILES['thumbnail']['name'])) {
            $thumbnail = uploadImage($_FILES['thumbnail'], 'uploads/videos');

            if (!$thumbnail) {
                $errors['thumbnail'] = 'Upload thumbnail thất bại';
            }
        }

        /**
         * Optional: vẫn cho upload video file nếu sau này cần.
         * Nhưng flow chính bây giờ là video_url.
         */
        $videoFile = '';

        if (!empty($_FILES['video_file']['name'])) {
            $videoFile = uploadFile($_FILES['video_file'], 'uploads/videos', [
                'mp4',
                'webm',
                'ogg',
                'mov',
            ]);

            if (!$videoFile) {
                $errors['video_file'] = 'Upload file video thất bại';
            }
        }

        if (!empty($errors)) {
            $this->renderAdmin('videos/create', [
                'title' => 'Thêm video',
                'errors' => $errors,
                'old' => $_POST,
            ]);
            return;
        }

        $videoModel = new Video();

        $slug = createSlug($title);

        if ($videoModel->findBySlug($slug)) {
            $slug .= '-' . time();
        }

        $videoModel->create([
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'thumbnail' => $thumbnail,
            'video_url' => $videoUrl,
            'video_file' => $videoFile,
            'video_type' => $videoType,
            'duration' => $duration !== '' ? (int)$duration : null,
            'status' => $status,
            'user_id' => $_SESSION['user']['id'] ?? null,
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Thêm video thành công',
        ];

        header('Location: index.php?area=admin&controller=video&action=index');
        exit;
    }

    public function edit()
    {
        requireAdmin();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $videoModel = new Video();
        $video = $videoModel->find($id);

        if (!$video) {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $this->renderAdmin('videos/edit', [
            'title' => 'Sửa video',
            'video' => $video,
            'errors' => [],
        ]);
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $videoModel = new Video();
        $video = $videoModel->find($id);

        if (!$video) {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $videoType = trim($_POST['video_type'] ?? 'short');
        $videoUrl = trim($_POST['video_url'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $status = trim($_POST['status'] ?? 'draft');

        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tiêu đề không được để trống';
        }

        if (!in_array($videoType, ['short', 'long'])) {
            $errors['video_type'] = 'Loại video không hợp lệ';
        }

        if (!in_array($status, ['draft', 'published', 'hidden'])) {
            $errors['status'] = 'Trạng thái không hợp lệ';
        }

        if ($videoUrl === '') {
            $errors['video_url'] = 'Vui lòng nhập link YouTube';
        } elseif (!$this->isValidYoutubeUrl($videoUrl)) {
            $errors['video_url'] = 'Link YouTube không hợp lệ';
        }

        $thumbnail = $video['thumbnail'] ?? '';

        if (!empty($_FILES['thumbnail']['name'])) {
            $newThumbnail = uploadImage($_FILES['thumbnail'], 'uploads/videos');

            if (!$newThumbnail) {
                $errors['thumbnail'] = 'Upload thumbnail thất bại';
            } else {
                $thumbnail = $newThumbnail;
            }
        }

        $videoFile = $video['video_file'] ?? '';

        if (!empty($_FILES['video_file']['name'])) {
            $newVideoFile = uploadFile($_FILES['video_file'], 'uploads/videos', [
                'mp4',
                'webm',
                'ogg',
                'mov',
            ]);

            if (!$newVideoFile) {
                $errors['video_file'] = 'Upload file video thất bại';
            } else {
                $videoFile = $newVideoFile;
            }
        }

        if (!empty($errors)) {
            $video['title'] = $title;
            $video['description'] = $description;
            $video['video_type'] = $videoType;
            $video['video_url'] = $videoUrl;
            $video['duration'] = $duration;
            $video['status'] = $status;
            $video['thumbnail'] = $thumbnail;
            $video['video_file'] = $videoFile;

            $this->renderAdmin('videos/edit', [
                'title' => 'Sửa video',
                'video' => $video,
                'errors' => $errors,
            ]);
            return;
        }

        $slug = $video['slug'];

        if ($title !== $video['title']) {
            $slug = createSlug($title);

            $existing = $videoModel->findBySlug($slug);

            if ($existing && (int)$existing['id'] !== $id) {
                $slug .= '-' . time();
            }
        }

        $videoModel->update($id, [
            'title' => $title,
            'slug' => $slug,
            'description' => $description,
            'thumbnail' => $thumbnail,
            'video_url' => $videoUrl,
            'video_file' => $videoFile,
            'video_type' => $videoType,
            'duration' => $duration !== '' ? (int)$duration : null,
            'status' => $status,
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cập nhật video thành công',
        ];

        header('Location: index.php?area=admin&controller=video&action=index');
        exit;
    }

    public function detail()
    {
        requireAdmin();

        $slug = trim($_GET['slug'] ?? '');

        if ($slug === '') {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $videoModel = new Video();
        $video = $videoModel->findBySlug($slug);

        if (!$video) {
            header('Location: index.php?area=admin&controller=video&action=index');
            exit;
        }

        $this->renderAdmin('videos/detail', [
            'title' => 'Chi tiết video',
            'video' => $video,
        ]);
    }

    public function publish()
    {
        requireAdmin();

        $this->updateStatusByGetId('published');
    }

    public function hide()
    {
        requireAdmin();

        $this->updateStatusByGetId('hidden');
    }

    public function draft()
    {
        requireAdmin();

        $this->updateStatusByGetId('draft');
    }

    public function delete()
    {
        requireAdmin();

        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $videoModel = new Video();
            $videoModel->delete($id);

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Xóa video thành công',
            ];
        }

        header('Location: index.php?area=admin&controller=video&action=index');
        exit;
    }

    private function updateStatusByGetId($status)
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            $videoModel = new Video();
            $videoModel->updateStatus($id, $status);
        }

        header('Location: index.php?area=admin&controller=video&action=index');
        exit;
    }

    private function isValidYoutubeUrl($url)
    {
        return preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//', $url);
    }
}
