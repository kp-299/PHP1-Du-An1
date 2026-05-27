<?php

$routes = [
    'client' => [
        'pages' => [
            'file' => __DIR__ . '/controllers/client/PagesController.php',
            'class' => 'ClientPagesController',
            'actions' => ['home', 'contact', 'error']
        ],

        'auth' => [
            'file' => __DIR__ . '/controllers/client/AuthController.php',
            'class' => 'ClientAuthController',
            'actions' => [
                'login',
                'register',
                'handleLogin',
                'handleRegister',
                'logout'
            ]
        ],

        'product' => [
            'file' => __DIR__ . '/controllers/client/ProductController.php',
            'class' => 'ClientProductController',
            'actions' => [
                'index',
                'detail'
            ]
        ],

        'post' => [
            'file' => __DIR__ . '/controllers/client/PostController.php',
            'class' => 'ClientPostController',
            'actions' => [
                'index',
                'detail'
            ]
        ],

        'video' => [
            'file' => __DIR__ . '/controllers/client/VideoController.php',
            'class' => 'ClientVideoController',
            'actions' => [
                'index',
                'detail'
            ]
        ],

        'cart' => [
            'file' => __DIR__ . '/controllers/client/CartController.php',
            'class' => 'ClientCartController',
            'actions' => [
                'index',
                'add',
                'update',
                'remove',
                'clear'
            ]
        ],

        'order' => [
            'file' => __DIR__ . '/controllers/client/OrderController.php',
            'class' => 'ClientOrderController',
            'actions' => [
                'checkout',
                'handleCheckout',
                'history',
                'detail',
                'cancel'
            ]
        ],

        'user' => [
            'file' => __DIR__ . '/controllers/client/UserController.php',
            'class' => 'ClientUserController',
            'actions' => [
                'profile',
                'editProfile',
                'updateProfile',
                'changePassword'
            ]
        ],
    ],

    'admin' => [
        'dashboard' => [
            'file' => __DIR__ . '/controllers/admin/DashboardController.php',
            'class' => 'AdminDashboardController',
            'actions' => ['index']
        ],

        'category' => [
            'file' => __DIR__ . '/controllers/admin/CategoryController.php',
            'class' => 'AdminCategoryController',
            'actions' => ['index', 'create', 'store', 'edit', 'update', 'hide']
        ],

        'product' => [
            'file' => __DIR__ . '/controllers/admin/ProductController.php',
            'class' => 'AdminProductController',
            'actions' => ['index', 'create', 'store', 'edit', 'update', 'hide', 'detail']
        ],

        'order' => [
            'file' => __DIR__ . '/controllers/admin/OrderController.php',
            'class' => 'AdminOrderController',
            'actions' => ['index', 'detail', 'updateStatus', 'cancel']
        ],

        'user' => [
            'file' => __DIR__ . '/controllers/admin/UserController.php',
            'class' => 'AdminUserController',
            'actions' => ['index', 'detail', 'updateStatus']
        ],

        'log' => [
            'file' => __DIR__ . '/controllers/admin/LogController.php',
            'class' => 'AdminLogController',
            'actions' => ['index']
        ],

        'setting' => [
            'file' => __DIR__ . '/controllers/admin/SettingController.php',
            'class' => 'AdminSettingController',
            'actions' => ['index', 'update']
        ],
    ],
];

if (!isset($routes[$area])) {
    $area = 'client';
    $controller = 'pages';
    $action = 'error';
}

if (!isset($routes[$area][$controller])) {
    $area = 'client';
    $controller = 'pages';
    $action = 'error';
}

$route = $routes[$area][$controller];

if (!in_array($action, $route['actions'])) {
    $area = 'client';
    $controller = 'pages';
    $action = 'error';
    $route = $routes[$area][$controller];
}

$controllerFile = $route['file'];

if (!file_exists($controllerFile)) {
    die('Controller file not found: ' . $controllerFile);
}

require_once $controllerFile;

$className = $route['class'];

if (!class_exists($className)) {
    die('Controller class not found: ' . $className);
}

$controllerObject = new $className();

if (!method_exists($controllerObject, $action)) {
    die('Action not found: ' . $action);
}

$controllerObject->$action();