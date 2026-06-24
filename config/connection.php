<?php
define('DB_HOST', '103.57.223.36');
define('DB_PORT', '3306');
define('DB_NAME', 'bcalhqzjhosting_ban_trai_cay');
define('DB_USER', 'bcalhqzjhosting_ban_trai_cay');
define('DB_PASS', 'jM*&zWt#5+P4vQ~');

// ==================== CLASS DB ====================

class DB
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $ex) {
                die('Lỗi kết nối DB: ' . $ex->getMessage());
            }
        }

        return self::$instance;
    }
}
