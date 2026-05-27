<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/slug.php';
require_once __DIR__ . '/../../helpers/upload.php';
require_once __DIR__ . '/../../helpers/log.php';
require_once __DIR__ . '/../../helpers/validation.php';

require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';

class AdminProductController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $productModel = new Product();
        $categoryModel = new Category();

        $filters = [
            'keyword' => trim($_GET['keyword'] ?? ''),
            'category_id' => $_GET['category_id'] ?? '',
            'status' => $_GET['status'] ?? '',
            'sort' => $_GET['sort'] ?? 'newest',
        ];

        $products = $productModel->getAll($filters);
        $categories = $categoryModel->getActive();

        $this->renderAdmin('products/index', [
            'title' => 'Quản lý sản phẩm',
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function detail()
    {
        requireAdmin();

        $slug = $_GET['slug'] ?? '';

        $productModel = new Product();
        $product = $productModel->findBySlug($slug);

        if (!$product) {
            header('Location: index.php?area=admin&controller=product&action=index');
            exit;
        }

        $this->renderAdmin('products/detail', [
            'title' => 'Chi tiết sản phẩm',
            'product' => $product,
        ]);
    }

    public function create()
    {
        requireAdmin();

        $categoryModel = new Category();
        $categories = $categoryModel->getActive();

        $this->renderAdmin('products/create', [
            'title' => 'Thêm sản phẩm',
            'categories' => $categories,
        ]);
    }

    public function store()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=product&action=create');
            exit;
        }

        $errors = validateProduct($_POST);

        if (!empty($errors)) {
            $categoryModel = new Category();

            $this->renderAdmin('products/create', [
                'title' => 'Thêm sản phẩm',
                'errors' => $errors,
                'old' => $_POST,
                'categories' => $categoryModel->getActive(),
            ]);
            return;
        }

        $name = trim($_POST['name']);
        $image = uploadImage($_FILES['image'] ?? null, 'products');

        $productModel = new Product();

        $productModel->create([
            'category_id' => $_POST['category_id'] ?? null,
            'name' => $name,
            'slug' => createSlug($name),
            'description' => trim($_POST['description'] ?? ''),
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'] ?? null,
            'stock' => $_POST['stock'] ?? 0,
            'unit' => $_POST['unit'] ?? 'kg',
            'image' => $image,
            'status' => $_POST['status'] ?? 'active',
        ]);

        createLog('create_product');

        header('Location: index.php?area=admin&controller=product&action=index');
        exit;
    }

    public function edit()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $productModel = new Product();
        $categoryModel = new Category();

        $product = $productModel->find($id);

        if (!$product) {
            header('Location: index.php?area=admin&controller=product&action=index');
            exit;
        }

        $this->renderAdmin('products/edit', [
            'title' => 'Sửa sản phẩm',
            'product' => $product,
            'categories' => $categoryModel->getActive(),
        ]);
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=product&action=index');
            exit;
        }

        $id = $_POST['id'] ?? null;

        $productModel = new Product();
        $categoryModel = new Category();

        $oldProduct = $productModel->find($id);

        if (!$oldProduct) {
            header('Location: index.php?area=admin&controller=product&action=index');
            exit;
        }

        $errors = validateProduct($_POST);

        if (!empty($errors)) {
            $this->renderAdmin('products/edit', [
                'title' => 'Sửa sản phẩm',
                'errors' => $errors,
                'product' => array_merge($oldProduct, $_POST),
                'categories' => $categoryModel->getActive(),
            ]);
            return;
        }

        $name = trim($_POST['name']);
        $image = $oldProduct['image'];

        $newImage = uploadImage($_FILES['image'] ?? null, 'products');

        if ($newImage) {
            $image = $newImage;
        }

        $productModel->update($id, [
            'category_id' => $_POST['category_id'] ?? null,
            'name' => $name,
            'slug' => createSlug($name),
            'description' => trim($_POST['description'] ?? ''),
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'] ?? null,
            'stock' => $_POST['stock'] ?? 0,
            'unit' => $_POST['unit'] ?? 'kg',
            'image' => $image,
            'status' => $_POST['status'] ?? 'active',
        ]);

        createLog('update_product');

        header('Location: index.php?area=admin&controller=product&action=index');
        exit;
    }

    public function hide()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $productModel = new Product();
        $productModel->hide($id);

        createLog('hide_product');

        header('Location: index.php?area=admin&controller=product&action=index');
        exit;
    }

    public function active()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $productModel = new Product();
        $productModel->active($id);

        createLog('active_product');

        header('Location: index.php?area=admin&controller=product&action=index');
        exit;
    }

    public function outOfStock()
    {
        requireAdmin();

        $id = $_GET['id'] ?? null;

        $productModel = new Product();
        $productModel->markOutOfStock($id);

        createLog('out_of_stock_product');

        header('Location: index.php?area=admin&controller=product&action=index');
        exit;
    }
}