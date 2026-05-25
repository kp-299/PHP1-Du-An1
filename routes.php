<?php
/**
 * FILE: routes.php
 * CHỨC NĂNG: Định tuyến dựa trên area, controller, action
 * 
 * Biến có sẵn từ index.php:
 *   $area       - 'client' hoặc 'admin'
 *   $controller - tên controller (vd: 'pages', 'product', 'auth')
 *   $action     - tên action (vd: 'home', 'index', 'login')
 */

// ==================== ĐỊNH NGHĨA ROUTE ====================

/**
 * Danh sách controller-action hợp lệ cho từng area
 * 
 * CẬP NHẬT: Khi thêm controller/action mới, thêm vào đây
 */
$routes = [
    'client' => [
        'pages'   => ['home', 'contact', 'error'],
        'product' => ['index', 'detail', 'search', 'category'],
        'cart'    => ['index', 'add', 'update', 'remove', 'clear'],
        'auth'    => ['login', 'register', 'handleLogin', 'handleRegister', 'logout'],
        'order'   => ['checkout', 'place', 'history', 'detail'],
        'user'    => ['profile', 'update', 'changePassword'],
    ],
    'admin' => [
        'dashboard' => ['index'],
        'category'  => ['index', 'create', 'store', 'edit', 'update', 'hide', 'active'],
        'product'   => ['index', 'create', 'store', 'edit', 'update', 'hide', 'active', 'markOutOfStock'],
        'order'     => ['index', 'detail', 'updateStatus', 'updatePayment', 'cancel'],
        'user'      => ['index', 'detail', 'updateStatus', 'updateRole'],
        'log'       => ['index', 'detail', 'clearAll', 'clearOld'],
        'setting'   => ['index', 'update', 'updateLogo', 'updateBanner'],
    ],
];

// ==================== KIỂM TRA ROUTE ====================

/**
 * Kiểm tra route có hợp lệ không
 * Nếu không hợp lệ -> set về default (client/pages/error)
 */
if (
    !array_key_exists($area, $routes) ||
    !array_key_exists($controller, $routes[$area]) ||
    !in_array($action, $routes[$area][$controller])
) {
    $area       = 'client';
    $controller = 'pages';
    $action     = 'error';
}

// ==================== MAP CONTROLLER CLASS ====================

/**
 * Map tên controller thành tên class
 * 
 * Client: area=client, controller=cart -> class=ClientCartController
 * Admin:  area=admin,  controller=product -> class=AdminProductController
 */
$controllerMap = [
    'client' => [
        'pages'   => 'ClientPagesController',
        'product' => 'ClientProductController',
        'cart'    => 'ClientCartController',
        'auth'    => 'ClientAuthController',
        'order'   => 'ClientOrderController',
        'user'    => 'ClientUserController',
    ],
    'admin' => [
        'dashboard' => 'AdminDashboardController',
        'category'  => 'AdminCategoryController',
        'product'   => 'AdminProductController',
        'order'     => 'AdminOrderController',
        'user'      => 'AdminUserController',
        'log'       => 'AdminLogController',
        'setting'   => 'AdminSettingController',
    ],
];

$klass = $controllerMap[$area][$controller] ?? null;

if (!$klass) {
    die('Route not found: ' . $area . '/' . $controller . '/' . $action);
}

// ==================== LOAD CONTROLLER ====================

/**
 * Xác định đường dẫn file controller
 * 
 * Client: controllers/client/ProductController.php
 * Admin:  controllers/admin/ProductController.php
 */
$controllerFile = __DIR__ . '/controllers/' . $area . '/' . $controller . 'Controller.php';

if (!file_exists($controllerFile)) {
    die('Controller file not found: ' . $controllerFile);
}

require_once $controllerFile;

if (!class_exists($klass)) {
    die('Controller class not found: ' . $klass);
}

// ==================== GỌI ACTION ====================

$controllerInstance = new $klass();

if (!method_exists($controllerInstance, $action)) {
    die('Action not found: ' . $action);
}

$controllerInstance->$action();