<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/slug.php';
require_once __DIR__ . '/../../helpers/upload.php';
require_once __DIR__ . '/../../helpers/log.php';
require_once __DIR__ . '/../../helpers/validation.php';

require_once __DIR__ . '/../../models/Category.php';

class AdminCategoryController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $categoryModel = new Category();

        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'status' => $_GET['status'] ?? '',
        ];

        $categories = $categoryModel->getAll($filters);

        $this->renderAdmin('categories/index', [
            'title' => 'Quản lý danh mục',
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function create()
    {
        requireAdmin();

        $this->renderAdmin('categories/create', [
            'title' => 'Thêm danh mục',
        ]);
    }

    public function store()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=category&action=create');
            exit;
        }

        $errors = validateCategory($_POST);

        if (!empty($errors)) {
            $this->renderAdmin('categories/create', [
                'title' => 'Thêm danh mục',
                'errors' => $errors,
                'old' => $_POST,
            ]);
            return;
        }

        $name = trim($_POST['name']);
        $slug = createSlug($name);
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'active';

        $image = uploadImage($_FILES['image'] ?? null, 'categories');

        $categoryModel = new Category();

        $categoryModel->create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'image' => $image,
            'status' => $status,
        ]);

        createLog('create_category');

        header('Location: index.php?area=admin&controller=category&action=index');
        exit;
    }

    public function edit()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $categoryModel = new Category();
        $category = $categoryModel->find($id);

        if (!$category) {
            header('Location: index.php?area=admin&controller=category&action=index');
            exit;
        }

        $this->renderAdmin('categories/edit', [
            'title' => 'Sửa danh mục',
            'category' => $category,
        ]);
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=category&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;

        $categoryModel = new Category();
        $oldCategory = $categoryModel->find($id);

        if (!$oldCategory) {
            header('Location: index.php?area=admin&controller=category&action=index');
            exit;
        }

        $errors = validateCategory($_POST);

        if (!empty($errors)) {
            $this->renderAdmin('categories/edit', [
                'title' => 'Sửa danh mục',
                'errors' => $errors,
                'category' => array_merge($oldCategory, $_POST),
            ]);
            return;
        }

        $name = trim($_POST['name']);
        $slug = createSlug($name);
        $description = trim($_POST['description'] ?? '');
        $status = $_POST['status'] ?? 'active';

        $image = $oldCategory['image'];
        $newImage = uploadImage($_FILES['image'] ?? null, 'categories');

        if ($newImage) {
            $image = $newImage;
        }

        $categoryModel->update($id, [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'image' => $image,
            'status' => $status,
        ]);

        createLog('update_category');

        header('Location: index.php?area=admin&controller=category&action=index');
        exit;
    }

    public function hide()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $categoryModel = new Category();
        $categoryModel->hide($id);

        createLog('hide_category');

        header('Location: index.php?area=admin&controller=category&action=index');
        exit;
    }

    public function active()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $categoryModel = new Category();
        $categoryModel->active($id);

        createLog('active_category');

        header('Location: index.php?area=admin&controller=category&action=index');
        exit;
    }

    public function delete()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $categoryModel = new Category();

        if ($categoryModel->hasProducts($id)) {
            $categoryModel->hide($id);
        } else {
            $categoryModel->deleteHard($id);
        }

        createLog('delete_category');

        header('Location: index.php?area=admin&controller=category&action=index');
        exit;
    }
}