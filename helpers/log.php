<?php
/**
 * FILE: helpers/log.php
 * CHỨC NĂNG: Ghi log hoạt động của người dùng (login, order, ...)
 * 
 * PHỤ THUỘC:
 *   - models/Log.php (Log model)
 *   - helpers/auth.php (currentUserId)
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/log.php';
 *   createLog('login');
 *   createLog('create_order');
 */

/**
 * Ghi log hoạt động
 * 
 * Input:
 *   - $action: string - mô tả hành động (vd: 'login', 'logout', 'create_order', 'register')
 * 
 * Output: void - không return gì, chỉ ghi vào DB
 * 
 * Dữ liệu thu thập:
 *   - user_id:   currentUserId() (có thể null nếu chưa login)
 *   - action:    $action
 *   - ip_address: $_SERVER['REMOTE_ADDR'] ?? ''
 *   - browser:   $_SERVER['HTTP_USER_AGENT'] ?? ''
 *   - url:       $_SERVER['REQUEST_URI'] ?? ''
 *   - method:    $_SERVER['REQUEST_METHOD'] ?? ''
 * 
 * Các bước cần code:
 *   1. require_once model Log (nếu chưa load)
 *      require_once __DIR__ . '/../models/Log.php';
 *   2. Tạo mảng $data với các thông tin trên
 *   3. Gọi (new Log())->create($data)
 * 
 * LƯU Ý: Nên dùng try-catch phòng trường hợp DB lỗi (không làm crash app)
 */
function createLog($action)
{
    // TODO: code tại đây
}
