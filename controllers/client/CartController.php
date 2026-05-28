<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../models/Cart.php';
require_once __DIR__ . '/../../models/WebSetting.php';

require_once __DIR__ . '/../../helpers/log.php';

class ClientCartController extends BaseController
{
    protected $folder = 'pages';

    public function index()
    {
        $cartModel = new Cart();
        $settingModel = new WebSetting();

        $cartItems = $cartModel->getItems();
        $totalAmount = $cartModel->getTotalAmount();
        $totalQuantity = $cartModel->getTotalQuantity();
        $settings = $settingModel->getSimpleSettings();

        $this->render('cart', [
            'title' => 'Giỏ hàng',
            'cartItems' => $cartItems,
            'totalAmount' => $totalAmount,
            'totalQuantity' => $totalQuantity,
            'settings' => $settings,
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=product&action=index');
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);

        if (!$productId || $quantity <= 0) {
            header('Location: index.php?area=client&controller=product&action=index');
            exit;
        }

        $cartModel = new Cart();

        $cartModel->add($productId, $quantity);

        createLog('add_to_cart');

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=cart&action=index');
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);

        $cartModel = new Cart();

        if ($productId) {
            $cartModel->update($productId, $quantity);
        }

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }

    public function remove()
    {
        $productId = $_GET['product_id'] ?? null;

        $cartModel = new Cart();

        if ($productId) {
            $cartModel->remove($productId);
        }

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }

    public function clear()
    {
        $cartModel = new Cart();

        $cartModel->clear();

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }
}