<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Video.php';
require_once __DIR__ . '/../../models/WebSetting.php';
require_once __DIR__ . '/../../models/Cart.php';

class ClientPagesController extends BaseController
{
    protected $folder = 'pages';

    public function home()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $postModel = new Post();
        $videoModel = new Video();
        $settingModel = new WebSetting();
        $cartModel = new Cart();

        $settings = $settingModel->getSimpleSettings();

        $categories = $categoryModel->getActive();

        $latestProducts = $productModel->getLatest(8);

        $activeProducts = $productModel->getActiveProducts();

        $posts = $postModel->getPublished(6);

        $videos = $videoModel->getPublished(6);

        $shortVideos = $videoModel->getAll([
            'video_type' => 'short',
            'status' => 'published',
            'limit' => 6,
            'offset' => 0,
        ]);

        $longVideos = $videoModel->getAll([
            'video_type' => 'long',
            'status' => 'published',
            'limit' => 6,
            'offset' => 0,
        ]);

        $cartItems = $cartModel->getItems();
        $cartTotalQuantity = $cartModel->getTotalQuantity();
        $cartTotalAmount = $cartModel->getTotalAmount();

        $this->render('home', [
            'title' => $settings['site_name'] ?? 'Trang chủ',
            'settings' => $settings,

            'categories' => $categories,

            'latestProducts' => $latestProducts,
            'activeProducts' => $activeProducts,

            'posts' => $posts,

            'videos' => $videos,
            'shortVideos' => $shortVideos,
            'longVideos' => $longVideos,

            'cartItems' => $cartItems,
            'cartTotalQuantity' => $cartTotalQuantity,
            'cartTotalAmount' => $cartTotalAmount,
        ]);
    }

    public function contact()
    {
        $settingModel = new WebSetting();

        $this->render('contact', [
            'title' => 'Liên hệ',
            'settings' => $settingModel->getSimpleSettings(),
        ]);
    }

    public function error()
    {
        $this->render('error', [
            'title' => '404 - Không tìm thấy trang',
        ]);
    }
}
