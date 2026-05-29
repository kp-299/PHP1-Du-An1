<?php

function currentUser()
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn()
{
    return !empty($_SESSION['user']);
}

function isAdmin()
{
    return isLoggedIn() && ($_SESSION['user']['role'] ?? '') === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? 'index.php';

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }
}

function requireAdmin()
{
    if (!isLoggedIn()) {
        $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? 'index.php';

        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }

    if (!isAdmin()) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Bạn không có quyền truy cập admin dashboard.',
        ];

        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }
}

function guestOnly()
{
    if (isLoggedIn()) {
        if (isAdmin()) {
            header('Location: index.php?area=admin&controller=dashboard&action=index');
            exit;
        }

        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }
}
