<?php
/**
 * FILE: index.php (ENTRY POINT)
 * CHỨC NĂNG: Điểm vào của ứng dụng - khởi tạo session, load config, route
 * 
 * CẤU TRÚC URL:
 *   index.php?area=client&controller=pages&action=home
 *   index.php?area=client&controller=auth&action=login
 *   index.php?area=admin&controller=dashboard&action=index
 * 
 * DEFAULT:
 *   area       = client
 *   controller = pages
 *   action     = home
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/config/connection.php';

// TODO: Sau này có thể load .env tại đây
// require_once __DIR__ . '/helpers/env.php';

$area       = $_GET['area'] ?? 'client';
$controller = $_GET['controller'] ?? 'pages';
$action     = $_GET['action'] ?? 'home';

require_once __DIR__ . '/routes.php';