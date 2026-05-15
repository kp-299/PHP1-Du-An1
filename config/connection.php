<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'demo_mvc');
define('DB_USER', 'root');
define('DB_PASS', '');

class DB
{
  // Biến lưu kết nối database duy nhất
  private static $instance = null;

  // Hàm lấy kết nối database
  public static function getInstance()
  {
    // Nếu chưa có kết nối thì tạo mới
    if (!isset(self::$instance)) {

      try {

        self::$instance = new PDO(
          'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
          DB_USER,
          DB_PASS,
          [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          ]
        );
      } catch (PDOException $ex) {

        die($ex->getMessage());
      }
    }

    return self::$instance;
  }
}