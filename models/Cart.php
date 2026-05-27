<?php

/**
 * FILE: models/Cart.php
 * CHỨC NĂNG: Model xử lý giỏ hàng bằng session
 */

require_once __DIR__ . '/Product.php';

class Cart
{
    public function getItems()
    {
        return $_SESSION['cart'] ?? [];
    }

    public function add($productId, $quantity = 1)
    {
        $productId = (int) $productId;
        $quantity = (int) $quantity;

        if ($productId <= 0 || $quantity <= 0) {
            return false;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $productModel = new Product();
        $product = $productModel->find($productId);

        if (!$product) {
            return false;
        }

        if (isset($product['status']) && $product['status'] !== 'active') {
            return false;
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
            return true;
        }

        $_SESSION['cart'][$productId] = [
            'id' => (int) $product['id'],
            'name' => $product['name'],
            'slug' => $product['slug'],
            'price' => (float) $product['price'],
            'sale_price' => $product['sale_price'] ?? null,
            'unit' => $product['unit'] ?? 'kg',
            'image' => $product['image'] ?? null,
            'quantity' => $quantity,
        ];

        return true;
    }

    public function update($productId, $quantity)
    {
        $productId = (int) $productId;
        $quantity = (int) $quantity;

        if (!isset($_SESSION['cart'][$productId])) {
            return false;
        }

        if ($quantity <= 0) {
            unset($_SESSION['cart'][$productId]);
            return true;
        }

        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        return true;
    }

    public function remove($productId)
    {
        $productId = (int) $productId;

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        return true;
    }

    public function clear()
    {
        unset($_SESSION['cart']);

        return true;
    }

    public function getTotalQuantity()
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $total += (int) $item['quantity'];
        }

        return $total;
    }

    public function getTotalAmount()
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $price = $item['price'];

            if (!empty($item['sale_price']) && $item['sale_price'] > 0) {
                $price = $item['sale_price'];
            }

            $total += (float) $price * (int) $item['quantity'];
        }

        return $total;
    }

    public function isEmpty()
    {
        return empty($this->getItems());
    }
}