<?php

require_once __DIR__ . '/config/connection.php';

try {
    $db = DB::getInstance();

    echo 'Kết nối DB thành công!<br>';

    $result = $db->query('SELECT DATABASE() AS db')->fetch();

    echo 'Database: ' . $result['db'];
} catch (PDOException $e) {
    echo 'Lỗi DB: ' . $e->getMessage();
}
