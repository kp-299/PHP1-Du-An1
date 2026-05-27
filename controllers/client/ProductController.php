<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/WebSetting.php';

class ClientProductController extends BaseController
{
    protected $folder = 'pages';

    public function index()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $settingModel = new WebSetting();

        $keyword = trim($_GET['keyword'] ?? '');
        $categoryId = $_GET['category_id'] ?? '';
        $categorySlug = $_GET['category'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $products = $productModel->getAll([
            'keyword' => $keyword,
            'category_id' => $categoryId,
            'category_slug' => $categorySlug,
            'status' => 'active',
            'sort' => $sort,
        ]);

        $categories = $categoryModel->getActive();
        $settings = $settingModel->getSimpleSettings();

        $this->render('product', [
            'title' => 'Sản phẩm',
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
            'keyword' => $keyword,
            'categoryId' => $categoryId,
            'categorySlug' => $categorySlug,
            'sort' => $sort,
        ]);
    }

    public function detail()
    {
        $slug = $_GET['slug'] ?? '';

        if ($slug === '') {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $productModel = new Product();
        $settingModel = new WebSetting();

        $product = $productModel->findBySlug($slug);
        $settings = $settingModel->getSimpleSettings();

        if (!$product || $product['status'] !== 'active') {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $this->render('productDetail', [
            'title' => $product['name'],
            'product' => $product,
            'settings' => $settings,
        ]);
    }
}