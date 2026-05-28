<?php

function dd($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    exit;
}

function dumpData($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function formatMoney($amount)
{
    return number_format((float) $amount, 0, ',', '.') . 'đ';
}

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function isGet()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}
