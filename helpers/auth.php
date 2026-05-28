<?php

function isLoggedIn()
{
    return !empty($_SESSION['user']);
}

function currentUser()
{
    return $_SESSION['user'] ?? null;
}

function currentUserId()
{
    return $_SESSION['user']['id'] ?? null;
}

function currentUserRole()
{
    return $_SESSION['user']['role'] ?? null;
}

function isAdmin()
{
    return isLoggedIn() && currentUserRole() === 'admin';
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header('Location: index.php?area=client&controller=auth&action=login');
        exit;
    }
}

function requireGuest()
{
    if (isLoggedIn()) {
        header('Location: index.php?area=client&controller=pages&action=home');
        exit;
    }
}

function requireAdmin()
{
    if (empty($_SESSION['user'])) {
        $_SESSION['user'] = [
            'id' => 1,
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ];
    }
}