<?php

/**
 * FILE: models/OrderItem.php
 * CHỨC NĂNG: Model xử lý bảng order_items
 */

require_once __DIR__ . '/BaseModel.php';

class OrderItem extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        $this->table = 'order_items';
    }

    public function create($data)
    {
        $sql = "
            INSERT INTO order_items (
                order_id,
                product_id,
                product_name,
                product_price,
                quantity,
                unit,
                subtotal
            )
            VALUES (
                :order_id,
                :product_id,
                :product_name,
                :product_price,
                :quantity,
                :unit,
                :subtotal
            )
        ";

        $stmt = $this->db->prepare($sql);

        $result = $stmt->execute([
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id'] ?? null,
            'product_name' => $data['product_name'],
            'product_price' => $data['product_price'],
            'quantity' => $data['quantity'],
            'unit' => $data['unit'] ?? null,
            'subtotal' => $data['subtotal'],
        ]);

        if (!$result) {
            return false;
        }

        return $this->db->lastInsertId();
    }

    public function createMany($orderId, $cartItems)
    {
        foreach ($cartItems as $item) {
            $price = $item['price'];

            if (!empty($item['sale_price']) && $item['sale_price'] > 0) {
                $price = $item['sale_price'];
            }

            $subtotal = $price * $item['quantity'];

            $result = $this->create([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'product_price' => $price,
                'quantity' => $item['quantity'],
                'unit' => $item['unit'] ?? null,
                'subtotal' => $subtotal,
            ]);

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    public function getByOrderId($orderId)
    {
        $sql = "
            SELECT *
            FROM order_items
            WHERE order_id = :order_id
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'order_id' => $orderId
        ]);

        return $stmt->fetchAll();
    }

    public function deleteByOrderId($orderId)
    {
        $sql = "
            DELETE FROM order_items
            WHERE order_id = :order_id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'order_id' => $orderId
        ]);
    }
}