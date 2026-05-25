<?php
/**
 * FILE: helpers/auth.php
 * CHỨC NĂNG: Xác thực người dùng - kiểm tra đăng nhập, phân quyền
 * 
 * PHỤ THUỘC: 
 *   - Session đã được start ở index.php
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/auth.php';
 *   if (isLoggedIn()) { ... }
 *   requireLogin(); // chặn nếu chưa đăng nhập
 */

/**
 * Kiểm tra xem user đã đăng nhập chưa
 * 
 * Input:  (dựa vào $_SESSION['user'])
 * Output: true nếu đã đăng nhập, false nếu chưa
 * Gợi ý:   return isset($_SESSION['user']);
 */
function isLoggedIn()
{
    // TODO: code tại đây
}

/**
 * Lấy thông tin user hiện tại
 * 
 * Input:  (dựa vào $_SESSION['user'])
 * Output: Mảng ['id', 'name', 'email', 'role'] hoặc null nếu chưa đăng nhập
 * Gợi ý:   return $_SESSION['user'] ?? null;
 */
function currentUser()
{
    // TODO: code tại đây
}

/**
 * Lấy ID của user hiện tại
 * 
 * Input:  (dựa vào $_SESSION['user'])
 * Output: int ID hoặc null
 * Gợi ý:   return $_SESSION['user']['id'] ?? null;
 */
function currentUserId()
{
    // TODO: code tại đây
}

/**
 * Lấy role của user hiện tại
 * 
 * Input:  (dựa vào $_SESSION['user'])
 * Output: string 'admin'|'user' hoặc null
 */
function currentUserRole()
{
    // TODO: code tại đây
}

/**
 * Kiểm tra có phải admin không
 * 
 * Input:  (dựa vào $_SESSION['user']['role'])
 * Output: true nếu role === 'admin'
 */
function isAdmin()
{
    // TODO: code tại đây
}

/**
 * Yêu cầu đăng nhập - nếu chưa đăng nhập thì redirect về login
 * 
 * Input:  (không có tham số)
 * Output: redirect đến trang login nếu chưa đăng nhập
 * Gợi ý:   if (!isLoggedIn()) {
 *              header('Location: index.php?area=client&controller=auth&action=login');
 *              exit;
 *          }
 */
function requireLogin()
{
    // TODO: code tại đây
}

/**
 * Yêu cầu chưa đăng nhập - nếu đã đăng nhập thì redirect về home
 * 
 * Input:  (không có tham số)
 * Output: redirect về home nếu đã đăng nhập
 * Dùng cho: Trang login/register - không cho user đã login vào
 */
function requireGuest()
{
    // TODO: code tại đây
}

/**
 * Yêu cầu quyền admin - nếu không phải admin thì redirect về home
 * 
 * Input:  (không có tham số)
 * Output: redirect nếu không phải admin
 * Gợi ý:   if (!isAdmin()) {
 *              header('Location: index.php?area=client&controller=pages&action=home');
 *              exit;
 *          }
 */
function requireAdmin()
{
    // TODO: code tại đây
}
