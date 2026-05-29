<?php

require_once __DIR__ . '/../models/Log.php';

function createLog($action, $userId = null)
{
    try {
        $logModel = new Log();

        $currentUser = $_SESSION['user'] ?? null;

        $userId = $userId ?? ($currentUser['id'] ?? null);

        $url = $_SERVER['REQUEST_URI'] ?? '';
        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        $browser = $_SERVER['HTTP_USER_AGENT'] ?? '';

        return $logModel->create([
            'user_id' => $userId,
            'action' => $action,
            'ip_address' => $ipAddress,
            'browser' => $browser,
            'url' => $url,
            'method' => $method,
        ]);
    } catch (Throwable $e) {
        return false;
    }
}
