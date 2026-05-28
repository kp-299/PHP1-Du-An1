<?php

function uploadImage($file, $folder)
{
    if (empty($file) || empty($file['name'])) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowedTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
        'image/gif'
    ];

    if (!in_array($file['type'], $allowedTypes)) {
        return null;
    }

    $maxSize = 5 * 1024 * 1024;

    if ($file['size'] > $maxSize) {
        return null;
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $fileName = time() . '_' . uniqid() . '.' . $extension;

    $uploadDir = __DIR__ . '/../uploads/' . $folder . '/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetPath = $uploadDir . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        return null;
    }

    return 'uploads/' . $folder . '/' . $fileName;
}

function deleteImage($path)
{
    if (empty($path)) {
        return false;
    }

    $fullPath = __DIR__ . '/../' . $path;

    if (file_exists($fullPath)) {
        return unlink($fullPath);
    }

    return false;
}
