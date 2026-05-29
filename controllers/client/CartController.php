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

        $this->render('cart', [
            'title' => 'Giỏ hàng',
            'settings' => $settingModel->getSimpleSettings(),

            'cartItems' => $cartModel->getItems(),
            'totalAmount' => $cartModel->getTotalAmount(),

            'cartTotalQuantity' => $cartModel->getTotalQuantity(),
            'cartTotalAmount' => $cartModel->getTotalAmount(),
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=client&controller=product&action=index');
            exit;
        }

        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        $cartModel = new Cart();

        if ($cartModel->add($productId, $quantity)) {
            createLog('add_to_cart_' . $productId);

            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Đã thêm sản phẩm vào giỏ hàng.',
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Không thể thêm sản phẩm vào giỏ hàng.',
            ];
        }

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
        $quantity = $_POST['quantity'] ?? 1;

        $cartModel = new Cart();
        $cartModel->update($productId, $quantity);

        createLog('update_cart_' . $productId);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã cập nhật giỏ hàng.',
        ];

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }

    public function remove()
    {
        $productId = $_GET['product_id'] ?? ($_GET['id'] ?? null);

        $cartModel = new Cart();
        $cartModel->remove($productId);

        createLog('remove_cart_item_' . $productId);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
        ];

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }

    public function clear()
    {
        $cartModel = new Cart();
        $cartModel->clear();

        createLog('clear_cart');

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Đã xóa toàn bộ giỏ hàng.',
        ];

        header('Location: index.php?area=client&controller=cart&action=index');
        exit;
    }
}
