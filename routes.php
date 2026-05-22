<?php

$routes = [
    'pages' => [
        'file' => __DIR__ . '/controllers/pages_controller.php',
        'class' => 'PagesController',
        'actions' => ['home', 'cart', 'contact', 'product', 'productDetail', 'error']
    ],

    'auth' => [
        'file' => __DIR__ . '/controllers/auth_controller.php',
        'class' => 'AuthController',
        'actions' => ['login', 'register', 'logout']
    ],

    'admin' => [
        'file' => __DIR__ . '/controllers/admin_controller.php',
        'class' => 'AdminController',
        'actions' => ['dashboard', 'products', 'orders', 'settings']
    ],
];

if (!isset($routes[$controller])) {
    $controller = 'pages';
    $action = 'error';
}

$route = $routes[$controller];

if (!in_array($action, $route['actions'])) {
    $controller = 'pages';
    $action = 'error';
    $route = $routes[$controller];
}

require_once $route['file'];

$className = $route['class'];

if (!class_exists($className)) {
    die('Controller class not found: ' . $className);
}

$controllerObject = new $className();

if (!method_exists($controllerObject, $action)) {
    die('Action not found: ' . $action);
}

$controllerObject->$action();
