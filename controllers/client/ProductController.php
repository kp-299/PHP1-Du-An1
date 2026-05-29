<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/Cart.php';

class ClientProductController extends BaseController
{
    protected $folder = 'pages';

    public function index()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $postModel = new Post();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();
        $categories = $categoryModel->getActive();

        $keyword = trim($_GET['keyword'] ?? '');
        $categorySlug = trim($_GET['category'] ?? '');
        $stockFilter = trim($_GET['stock_filter'] ?? '');
        $sort = trim($_GET['sort'] ?? 'newest');

        $categoryId = null;
        $currentCategory = null;

        if ($categorySlug !== '') {
            $currentCategory = $categoryModel->findBySlug($categorySlug);

            if ($currentCategory) {
                $categoryId = $currentCategory['id'];
            }
        }

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $limit = 18;
        $offset = ($page - 1) * $limit;

        $filters = [
            'keyword' => $keyword,
            'category_id' => $categoryId,
            'stock_filter' => $stockFilter,
            'sort' => $sort,
            'limit' => $limit,
            'offset' => $offset,
        ];

        $products = $productModel->getClientProducts($filters);
        $totalProducts = $productModel->countFiltered($filters);
        $totalPages = max(1, ceil($totalProducts / $limit));

        $posts = $postModel->getPublished(6);

        $this->render('products', [
            'title' => 'Sản phẩm',
            'settings' => $settings,

            'categories' => $categories,
            'currentCategory' => $currentCategory,

            'products' => $products,
            'posts' => $posts,

            'filters' => [
                'keyword' => $keyword,
                'category' => $categorySlug,
                'stock_filter' => $stockFilter,
                'sort' => $sort,
            ],

            'page' => $page,
            'totalPages' => $totalPages,
            'totalProducts' => $totalProducts,

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }

    public function detail()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?area=client&controller=product&action=index');
            exit;
        }

        $productModel = new Product();
        $categoryModel = new Category();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();
        $categories = $categoryModel->getActive();

        $product = $productModel->findDetailById($id);

        if (!$product) {
            header('Location: index.php?area=client&controller=pages&action=error');
            exit;
        }

        $productImages = $productModel->getImages($id);

        $relatedProducts = $productModel->getRelatedProducts(
            $product['category_id'],
            $product['id'],
            12
        );

        $this->render('productDetail', [
            'title' => $product['name'],
            'settings' => $settings,

            'categories' => $categories,

            'product' => $product,
            'productImages' => $productImages,
            'relatedProducts' => $relatedProducts,

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }
}
