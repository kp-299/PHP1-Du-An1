<?php
/**
 * FILE: helpers/redirect.php
 * CHỨC NĂNG: Hỗ trợ chuyển hướng (redirect) giữa các trang
 * 
 * PHỤ THUỘC: Không
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/redirect.php';
 *   redirect('client', 'pages', 'home');
 *   redirectClient('product', 'index');
 *   redirectAdmin('dashboard', 'index');
 */

/**
 * Chuyển hướng đến một URL bất kỳ
 * 
 * Input:
 *   - $area: string (ví dụ: 'client', 'admin')
 *   - $controller: string (ví dụ: 'pages', 'product')
 *   - $action: string (ví dụ: 'home', 'index')
 *   - $params: array (optional) các tham số query string thêm, ví dụ ['id' => 5]
 * 
 * Output: redirect HTTP, không return gì
 * Gợi ý:
 *   $url = "index.php?area=$area&controller=$controller&action=$action";
 *   foreach ($params as $key => $value) {
 *       $url .= "&$key=$value";
 *   }
 *   header("Location: $url");
 *   exit;
 */
function redirect($area, $controller, $action = 'index', $params = [])
{
    // TODO: code tại đây
}

/**
 * Chuyển hướng trang client (không cần truyền area)
 * 
 * Input:
 *   - $controller: string
 *   - $action: string (mặc định 'index')
 *   - $params: array (optional)
 * 
 * Output: redirect đến index.php?area=client&controller=...&action=...
 * Gợi ý: gọi redirect('client', $controller, $action, $params)
 */
function redirectClient($controller, $action = 'index', $params = [])
{
    // TODO: code tại đây
}

/**
 * Chuyển hướng trang admin (không cần truyền area)
 * 
 * Input:
 *   - $controller: string
 *   - $action: string (mặc định 'index')
 *   - $params: array (optional)
 * 
 * Output: redirect đến index.php?area=admin&controller=...&action=...
 */
function redirectAdmin($controller, $action = 'index', $params = [])
{
    // TODO: code tại đây
}

/**
 * Quay lại trang trước đó
 * 
 * Input:  (dựa vào $_SERVER['HTTP_REFERER'])
 * Output: redirect về trang trước, nếu không có thì về home client
 * Gợi ý:
 *   $referer = $_SERVER['HTTP_REFERER'] ?? 'index.php?area=client&controller=pages&action=home';
 *   header("Location: $referer");
 *   exit;
 */
function redirectBack()
{
    // TODO: code tại đây
}
