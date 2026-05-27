<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/WebSetting.php';

class ClientPagesController extends BaseController
{
    protected $folder = 'pages';

    public function home()
    {
        $productModel = new Product();
        $categoryModel = new Category();
        $settingModel = new WebSetting();

        $products = $productModel->getLatest(8);
        $categories = $categoryModel->getActive();
        $settings = $settingModel->getSimpleSettings();

        $this->render('home', [
            'title' => 'Trang chủ',
            'products' => $products,
            'categories' => $categories,
            'settings' => $settings,
        ]);
    }

    public function contact()
    {
        $settingModel = new WebSetting();

        $settings = $settingModel->getSimpleSettings();

        $this->render('contact', [
            'title' => 'Liên hệ',
            'settings' => $settings,
        ]);
    }

    public function error()
    {
        http_response_code(404);

        $this->render('error', [
            'title' => '404 - Không tìm thấy trang',
        ]);
    }
}