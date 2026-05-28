<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/connection.php';

$area = $_GET['area'] ?? 'client';
$controller = $_GET['controller'] ?? 'pages';
$action = $_GET['action'] ?? 'home';

$area = strtolower(trim($area));
$controller = strtolower(trim($controller));
$action = trim($action);

require_once __DIR__ . '/routes.php';