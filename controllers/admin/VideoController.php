<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/redirect.php';
require_once __DIR__ . '/../../helpers/slug.php';
require_once __DIR__ . '/../../helpers/upload.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/Video.php';

class AdminVideoController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $videoModel = new Video();

        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'status' => $_GET['status'] ?? '',
            'video_type' => $_GET['video_type'] ?? '',
        ];

        $videos = $videoModel->getAll($filters);

        $this->renderAdmin('videos/index', [
            'title' => 'Quản lý video',
            'videos' => $videos,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        requireAdmin();

        $this->renderAdmin('videos/create', [
            'title' => 'Thêm video',
            'old' => [],
            'errors' => [],
        ]);
    }

    public function store()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirectAdmin('video', 'index');
        }

        $title = trim($_POST['title'] ?? '');
        $videoType = $_POST['video_type'] ?? 'short';
        $videoUrl = trim($_POST['video_url'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $duration = $_POST['duration'] ?? null;
        $status = $_POST['status'] ?? 'draft';

        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tiêu đề video không được để trống';
        }

        if (!in_array($videoType, ['short', 'long'])) {
            $errors['video_type'] = 'Loại video không hợp lệ';
        }

        $thumbnail = null;
        $videoFile = null;

        if (!empty($_FILES['thumbnail']['name'])) {
            $thumbnail = uploadImage($_FILES['thumbnail'], 'videos/thumbnails');
        }

        if (!empty($_FILES['video_file']['name'])) {
            $videoFile = uploadVideo($_FILES['video_file'], 'videos/files');
        }

        if ($videoFile === null && $videoUrl === '') {
            $errors['video_file'] = 'Bạn cần upload video hoặc nhập URL video';
        }

        if (!empty($errors)) {
            $this->renderAdmin('videos/create', [
                'title' => 'Thêm video',
                'old' => $_POST,
                'errors' => $errors,
            ]);
            return;
        }

        $videoModel = new Video();

        $videoModel->create([
            'title' => $title,
            'slug' => createSlug($title),
            'video_type' => $videoType,
            'thumbnail' => $thumbnail,
            'video_file' => $videoFile,
            'video_url' => $videoUrl,
            'description' => $description,
            'duration' => $duration !== '' ? $duration : null,
            'author_id' => $_SESSION['user']['id'] ?? null,
            'status' => $status,
        ]);

        createLog('create_video');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Thêm video thành công',
        ];

        redirectAdmin('video', 'index');
    }

    public function edit()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            redirectAdmin('video', 'index');
        }

        $videoModel = new Video();
        $video = $videoModel->find($id);

        if (!$video) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Không tìm thấy video',
            ];

            redirectAdmin('video', 'index');
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
            redirectAdmin('video', 'index');
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            redirectAdmin('video', 'index');
        }

        $videoModel = new Video();
        $video = $videoModel->find($id);

        if (!$video) {
            redirectAdmin('video', 'index');
        }

        $title = trim($_POST['title'] ?? '');
        $videoType = $_POST['video_type'] ?? 'short';
        $videoUrl = trim($_POST['video_url'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $duration = $_POST['duration'] ?? null;
        $status = $_POST['status'] ?? 'draft';

        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tiêu đề video không được để trống';
        }

        if (!in_array($videoType, ['short', 'long'])) {
            $errors['video_type'] = 'Loại video không hợp lệ';
        }

        $thumbnail = $video['thumbnail'];
        $videoFile = $video['video_file'];

        if (!empty($_FILES['thumbnail']['name'])) {
            $newThumbnail = uploadImage($_FILES['thumbnail'], 'videos/thumbnails');

            if ($newThumbnail) {
                $thumbnail = $newThumbnail;
            }
        }

        if (!empty($_FILES['video_file']['name'])) {
            $newVideoFile = uploadVideo($_FILES['video_file'], 'videos/files');

            if ($newVideoFile) {
                $videoFile = $newVideoFile;
            }
        }

        if ($videoFile === null && $videoUrl === '') {
            $errors['video_file'] = 'Bạn cần upload video hoặc nhập URL video';
        }

        if (!empty($errors)) {
            $video = array_merge($video, $_POST);

            $this->renderAdmin('videos/edit', [
                'title' => 'Sửa video',
                'video' => $video,
                'errors' => $errors,
            ]);
            return;
        }

        $videoModel->update($id, [
            'title' => $title,
            'slug' => createSlug($title),
            'video_type' => $videoType,
            'thumbnail' => $thumbnail,
            'video_file' => $videoFile,
            'video_url' => $videoUrl,
            'description' => $description,
            'duration' => $duration !== '' ? $duration : null,
            'status' => $status,
        ]);

        createLog('update_video');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cập nhật video thành công',
        ];

        redirectAdmin('video', 'index');
    }

    public function detail()
    {
        requireAdmin();

        $slug = $_GET['slug'] ?? '';

        if ($slug === '') {
            redirectAdmin('video', 'index');
        }

        $videoModel = new Video();
        $video = $videoModel->findBySlug($slug);

        if (!$video) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Không tìm thấy video',
            ];

            redirectAdmin('video', 'index');
        }

        $this->renderAdmin('videos/detail', [
            'title' => 'Chi tiết video',
            'video' => $video,
        ]);
    }

    public function publish()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $videoModel = new Video();
            $videoModel->publish($id);
            createLog('publish_video');
        }

        redirectAdmin('video', 'index');
    }

    public function hide()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $videoModel = new Video();
            $videoModel->hide($id);
            createLog('hide_video');
        }

        redirectAdmin('video', 'index');
    }

    public function draft()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $videoModel = new Video();
            $videoModel->draft($id);
            createLog('draft_video');
        }

        redirectAdmin('video', 'index');
    }

    public function delete()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $videoModel = new Video();
            $videoModel->delete($id);
            createLog('delete_video');
        }

        redirectAdmin('video', 'index');
    }
}