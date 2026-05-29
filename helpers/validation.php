<?php

function required($value)
{
    return trim($value ?? '') !== '';
}

function isEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function minLength($value, $length)
{
    return strlen($value ?? '') >= $length;
}

function isPositiveNumber($value)
{
    return is_numeric($value) && $value >= 0;
}

function validateLogin($data)
{
    $errors = [];

    if (!required($data['email'] ?? '')) {
        $errors['email'] = 'Email không được để trống';
    }

    if (!required($data['password'] ?? '')) {
        $errors['password'] = 'Mật khẩu không được để trống';
    }

    return $errors;
}

function validateRegister($data)
{
    $errors = [];

    if (!required($data['name'] ?? '')) {
        $errors['name'] = 'Tên không được để trống';
    }

    if (!required($data['email'] ?? '')) {
        $errors['email'] = 'Email không được để trống';
    } elseif (!isEmail($data['email'])) {
        $errors['email'] = 'Email không hợp lệ';
    }

    if (!required($data['password'] ?? '')) {
        $errors['password'] = 'Mật khẩu không được để trống';
    } elseif (!minLength($data['password'], 6)) {
        $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
    }

    if (($data['password'] ?? '') !== ($data['confirm_password'] ?? '')) {
        $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp';
    }

    return $errors;
}

function validateCategory($data)
{
    $errors = [];

    if (!required($data['name'] ?? '')) {
        $errors['name'] = 'Tên danh mục không được để trống';
    }

    return $errors;
}

function validateProduct($data)
{
    $errors = [];

    if (!required($data['name'] ?? '')) {
        $errors['name'] = 'Tên sản phẩm không được để trống';
    }

    if (!required($data['price'] ?? '')) {
        $errors['price'] = 'Giá sản phẩm không được để trống';
    } elseif (!isPositiveNumber($data['price'])) {
        $errors['price'] = 'Giá sản phẩm phải là số hợp lệ';
    }

    if (isset($data['sale_price']) && $data['sale_price'] !== '') {
        if (!isPositiveNumber($data['sale_price'])) {
            $errors['sale_price'] = 'Giá sale phải là số hợp lệ';
        }
    }

    if (isset($data['stock']) && $data['stock'] !== '') {
        if (!isPositiveNumber($data['stock'])) {
            $errors['stock'] = 'Tồn kho phải là số hợp lệ';
        }
    }

    return $errors;
}

function validateCheckout($data)
{
    $errors = [];

    $customerName = trim($data['customer_name'] ?? '');
    $customerPhone = trim($data['customer_phone'] ?? '');
    $customerEmail = trim($data['customer_email'] ?? '');
    $customerAddress = trim($data['customer_address'] ?? '');
    $paymentMethod = trim($data['payment_method'] ?? '');

    if ($customerName === '') {
        $errors['customer_name'] = 'Vui lòng nhập họ tên.';
    } elseif (mb_strlen($customerName) < 2) {
        $errors['customer_name'] = 'Họ tên tối thiểu 2 ký tự.';
    }

    if ($customerPhone === '') {
        $errors['customer_phone'] = 'Vui lòng nhập số điện thoại.';
    } elseif (!preg_match('/^(0|\+84)[0-9]{9,10}$/', $customerPhone)) {
        $errors['customer_phone'] = 'Số điện thoại không hợp lệ.';
    }

    if ($customerEmail !== '' && !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['customer_email'] = 'Email không hợp lệ.';
    }

    if ($customerAddress === '') {
        $errors['customer_address'] = 'Vui lòng nhập địa chỉ giao hàng.';
    } elseif (mb_strlen($customerAddress) < 10) {
        $errors['customer_address'] = 'Địa chỉ giao hàng cần chi tiết hơn.';
    }

    if ($paymentMethod === '') {
        $errors['payment_method'] = 'Vui lòng chọn hình thức thanh toán.';
    }

    return $errors;
}
