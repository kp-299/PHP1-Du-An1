<?php

$controllers = [
  'pages' => ['home', 'cart', 'contact', 'product', 'productDetail', 'error'],
];

if (
  !array_key_exists($controller, $controllers) ||
  !in_array($action, $controllers[$controller])
) {
  $controller = 'pages';
  $action = 'error';
}

$controllerFile = __DIR__ . '/controllers/' . $controller . '_controller.php';

if (!file_exists($controllerFile)) {
  die('Controller file not found: ' . $controllerFile);
}

require_once $controllerFile;

$klass = str_replace('_', '', ucwords($controller, '_')) . 'Controller';

if (!class_exists($klass)) {
  die('Controller class not found: ' . $klass);
}

$controllerInstance = new $klass();

if (!method_exists($controllerInstance, $action)) {
  die('Action not found: ' . $action);
}

$controllerInstance->$action();