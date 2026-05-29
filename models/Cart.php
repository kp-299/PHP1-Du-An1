<?php

require_once __DIR__ . '/Product.php';

class Cart
{
    private string $sessionKey = 'cart';

    public function __construct()
    {
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    public function add($productId, $quantity = 1)
    {
        $productId = (int)$productId;
        $quantity = max(1, (int)$quantity);

        if ($productId <= 0) {
            return false;
        }

        if (isset($_SESSION[$this->sessionKey][$productId])) {
            $_SESSION[$this->sessionKey][$productId] += $quantity;
        } else {
            $_SESSION[$this->sessionKey][$productId] = $quantity;
        }

        return true;
    }

    public function update($productId, $quantity)
    {
        $productId = (int)$productId;
        $quantity = (int)$quantity;

        if ($productId <= 0) {
            return false;
        }

        if ($quantity <= 0) {
            unset($_SESSION[$this->sessionKey][$productId]);
            return true;
        }

        $_SESSION[$this->sessionKey][$productId] = $quantity;

        return true;
    }

    public function remove($productId)
    {
        $productId = (int)$productId;

        if (isset($_SESSION[$this->sessionKey][$productId])) {
            unset($_SESSION[$this->sessionKey][$productId]);
        }

        return true;
    }

    public function clear()
    {
        $_SESSION[$this->sessionKey] = [];
        return true;
    }

    public function isEmpty()
    {
        return empty($_SESSION[$this->sessionKey]);
    }

    public function getRawItems()
    {
        return $_SESSION[$this->sessionKey] ?? [];
    }

    public function getItems()
    {
        $cart = $this->getRawItems();

        if (empty($cart)) {
            return [];
        }

        $productModel = new Product();
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $product = $productModel->findById($productId);

            if (!$product) {
                unset($_SESSION[$this->sessionKey][$productId]);
                continue;
            }

            $product['quantity'] = (int)$quantity;
            $items[] = $product;
        }

        return $items;
    }

    public function getTotalQuantity()
    {
        return array_sum($_SESSION[$this->sessionKey] ?? []);
    }

    public function getTotalAmount()
    {
        $items = $this->getItems();
        $total = 0;

        foreach ($items as $item) {
            $price = $item['price'] ?? 0;

            if (!empty($item['sale_price']) && $item['sale_price'] > 0) {
                $price = $item['sale_price'];
            }

            $total += $price * ($item['quantity'] ?? 1);
        }

        return $total;
    }
}
