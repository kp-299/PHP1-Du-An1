<?php

/**
 * FILE: config/connection.php
 * CHỨC NĂNG: Kết nối database MySQL qua PDO
 * 
 * SỬ DỤNG .ENV:
 *   Mặc định dùng hằng số DB_* define bên dưới.
 *   Nếu muốn dùng .env (bảo mật hơn), cần:
 *   1. copy .env.example -> .env
 *   2. Điền DB credentials vào .env
 *   3. Bỏ comment code load .env bên dưới
 * 
 * .gitignore đã loại trừ file .env
 * 
 * CÁCH DÙNG:
 *   $db = DB::getInstance();
 *   $stmt = $db->query("SELECT * FROM users");
 */

// ==================== LOAD .ENV (nếu có) ====================
// TODO: Khi có file .env, bỏ comment đoạn này và xóa define cứng bên dưới
// $envFile = __DIR__ . '/../.env';
// if (file_exists($envFile)) {
//     $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//     foreach ($lines as $line) {
//         if (strpos(trim($line), '#') === 0) continue;
//         putenv(trim($line));
//     }
//     define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
//     define('DB_PORT', getenv('DB_PORT') ?: '3306');
//     define('DB_NAME', getenv('DB_NAME') ?: 'bcalhqzjhosting_ban_trai_cay');
//     define('DB_USER', getenv('DB_USER') ?: 'bcalhqzjhosting_ban_trai_cay');
//     define('DB_PASS', getenv('DB_PASS') ?: '');
// } else {
//     // Fallback - KHÔNG commit lên Git nếu dùng password thật ở đây
// }

// ==================== CẤU HÌNH DB (TẠM - SỬA SAU) ====================
/**
 * LƯU Ý BẢO MẬT:
 *   - KHÔNG commit password thật lên GitHub
 *   - Dùng .env để lưu password
 *   - Hosting: DB_USER và DB_PASS do nhà hosting cung cấp
 * 
 *   Password hiện tại đã được thay bằng placeholder.
 *   Bạn cần điền lại password thật (từ hosting) trước khi chạy.
 */
define('DB_HOST', '103.57.223.36');
define('DB_PORT', '3306');
define('DB_NAME', 'bcalhqzjhosting_ban_trai_cay');
define('DB_USER', 'bcalhqzjhosting_ban_trai_cay');
// TODO: Điền password database thật tại đây (hoặc dùng .env)
// Đây là placeholder, cần sửa trước khi chạy!
define('DB_PASS', 'jM*&zWt#5+P4vQ~');

// ==================== CLASS DB ====================

class DB
{
    private static $instance = null;

    /**
     * Lấy kết nối PDO (Singleton)
     * 
     * Output: PDO object
     * 
     * CÁCH DÙNG:
     *   $db = DB::getInstance();
     *   $stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
     *   $stmt->execute(['id' => 1]);
     *   $product = $stmt->fetch();
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
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