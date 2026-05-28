<?php

require_once __DIR__ . '/../models/Log.php';

function createLog($action)
{
    try {
        $logModel = new Log();

        return $logModel->create([
            'user_id' => $_SESSION['user']['id'] ?? null,
            'action' => $action,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'browser' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'url' => $_SERVER['REQUEST_URI'] ?? null,
            'method' => $_SERVER['REQUEST_METHOD'] ?? null,
        ]);
    } catch (Exception $e) {
        return false;
    }
}
