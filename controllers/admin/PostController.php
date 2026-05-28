<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/redirect.php';
require_once __DIR__ . '/../../helpers/slug.php';
require_once __DIR__ . '/../../helpers/upload.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/Post.php';

class AdminPostController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $postModel = new Post();

        $filters = [
            'keyword' => $_GET['keyword'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];

        $posts = $postModel->getAll($filters);

        $this->renderAdmin('posts/index', [
            'title' => 'Quản lý bài viết',
            'posts' => $posts,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        requireAdmin();

        $this->renderAdmin('posts/create', [
            'title' => 'Thêm bài viết',
            'old' => [],
            'errors' => [],
        ]);
    }

    public function store()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirectAdmin('post', 'index');
        }

        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'draft';

        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tiêu đề không được để trống';
        }

        if ($content === '') {
            $errors['content'] = 'Nội dung không được để trống';
        }

        if (!empty($errors)) {
            $this->renderAdmin('posts/create', [
                'title' => 'Thêm bài viết',
                'old' => $_POST,
                'errors' => $errors,
            ]);
            return;
        }

        $thumbnail = null;

        if (!empty($_FILES['thumbnail']['name'])) {
            $thumbnail = uploadImage($_FILES['thumbnail'], 'posts/thumbnails');
        }

        $postModel = new Post();

        $postModel->create([
            'title' => $title,
            'slug' => createSlug($title),
            'thumbnail' => $thumbnail,
            'summary' => $summary,
            'content' => $content,
            'author_id' => $_SESSION['user']['id'] ?? null,
            'status' => $status,
        ]);

        createLog('create_post');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Thêm bài viết thành công',
        ];

        redirectAdmin('post', 'index');
    }

    public function edit()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            redirectAdmin('post', 'index');
        }

        $postModel = new Post();
        $post = $postModel->find($id);

        if (!$post) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Không tìm thấy bài viết',
            ];

            redirectAdmin('post', 'index');
        }

        $this->renderAdmin('posts/edit', [
            'title' => 'Sửa bài viết',
            'post' => $post,
            'errors' => [],
        ]);
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirectAdmin('post', 'index');
        }

        $id = $_POST['id'] ?? null;

        if (!$id) {
            redirectAdmin('post', 'index');
        }

        $postModel = new Post();
        $post = $postModel->find($id);

        if (!$post) {
            redirectAdmin('post', 'index');
        }

        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $content = trim($_POST['content'] ?? '');
        $status = $_POST['status'] ?? 'draft';

        $errors = [];

        if ($title === '') {
            $errors['title'] = 'Tiêu đề không được để trống';
        }

        if ($content === '') {
            $errors['content'] = 'Nội dung không được để trống';
        }

        if (!empty($errors)) {
            $post = array_merge($post, $_POST);

            $this->renderAdmin('posts/edit', [
                'title' => 'Sửa bài viết',
                'post' => $post,
                'errors' => $errors,
            ]);
            return;
        }

        $thumbnail = $post['thumbnail'];

        if (!empty($_FILES['thumbnail']['name'])) {
            $newThumbnail = uploadImage($_FILES['thumbnail'], 'posts/thumbnails');

            if ($newThumbnail) {
                $thumbnail = $newThumbnail;
            }
        }

        $postModel->update($id, [
            'title' => $title,
            'slug' => createSlug($title),
            'thumbnail' => $thumbnail,
            'summary' => $summary,
            'content' => $content,
            'status' => $status,
        ]);

        createLog('update_post');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cập nhật bài viết thành công',
        ];

        redirectAdmin('post', 'index');
    }

    public function detail()
    {
        requireAdmin();

        $slug = $_GET['slug'] ?? '';

        if ($slug === '') {
            redirectAdmin('post', 'index');
        }

        $postModel = new Post();
        $post = $postModel->findBySlug($slug);

        if (!$post) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Không tìm thấy bài viết',
            ];

            redirectAdmin('post', 'index');
        }

        $this->renderAdmin('posts/detail', [
            'title' => 'Chi tiết bài viết',
            'post' => $post,
        ]);
    }

    public function publish()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $postModel = new Post();
            $postModel->publish($id);
            createLog('publish_post');
        }

        redirectAdmin('post', 'index');
    }

    public function hide()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $postModel = new Post();
            $postModel->hide($id);
            createLog('hide_post');
        }

        redirectAdmin('post', 'index');
    }

    public function draft()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $postModel = new Post();
            $postModel->draft($id);
            createLog('draft_post');
        }

        redirectAdmin('post', 'index');
    }

    public function delete()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        if ($id) {
            $postModel = new Post();
            $postModel->delete($id);
            createLog('delete_post');
        }

        redirectAdmin('post', 'index');
    }
}