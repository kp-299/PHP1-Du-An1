<?php
/**
 * FILE: helpers/seed.php
 * CHỨC NĂNG: Hỗ trợ tạo password hash cho seed data
 * Dùng để tạo tài khoản admin ban đầu
 * 
 * CÁCH DÙNG (tạm thời chạy riêng):
 *   1. require_once __DIR__ . '/helpers/seed.php';
 *   2. echo makePasswordHash('admin123');
 *   3. Copy kết quả vào câu lệnh INSERT
 * 
 * LƯU Ý AN TOÀN: Xóa file này hoặc không cho public truy cập sau khi seed xong!
 */

/**
 * Tạo password hash từ password gốc
 * 
 * Input:
 *   - $password: string - mật khẩu gốc (vd: 'admin123')
 * 
 * Output: string - hash password (vd: '$2y$10$...')
 * Gợi ý: return password_hash($password, PASSWORD_DEFAULT);
 */
function makePasswordHash($password)
{
    // TODO: code tại đây
}

/**
 * Xác thực password với hash
 * 
 * Input:
 *   - $password: string - mật khẩu gốc cần kiểm tra
 *   - $hash: string - hash từ DB
 * 
 * Output: bool - true nếu đúng
 * Gợi ý: return password_verify($password, $hash);
 */
function verifyPassword($password, $hash)
{
    // TODO: code tại đây
}

/**
 * In ra hash của một password (dùng để seed từ CLI)
 * 
 * Input:
 *   - $password: string
 * 
 * Output: echo hash ra màn hình
 * 
 * Cách dùng tạm:
 *   php -r "require 'helpers/seed.php'; printPasswordHash('admin123');"
 */
function printPasswordHash($password)
{
    // TODO: code tại đây
}
