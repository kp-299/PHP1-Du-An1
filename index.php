<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/connection.php';

$controller = $_GET['controller'] ?? 'pages';
$action = $_GET['action'] ?? 'home';

require_once __DIR__ . '/routes.php';