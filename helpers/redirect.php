<?php

function redirect($area, $controller, $action, $params = [])
{
    $url = "index.php?area={$area}&controller={$controller}&action={$action}";

    foreach ($params as $key => $value) {
        $url .= '&' . urlencode($key) . '=' . urlencode($value);
    }

    header("Location: {$url}");
    exit;
}

function redirectClient($controller, $action, $params = [])
{
    redirect('client', $controller, $action, $params);
}

function redirectAdmin($controller, $action, $params = [])
{
    redirect('admin', $controller, $action, $params);
}

function redirectBack()
{
    $url = $_SERVER['HTTP_REFERER'] ?? 'index.php?area=client&controller=pages&action=home';

    header("Location: {$url}");
    exit;
}
