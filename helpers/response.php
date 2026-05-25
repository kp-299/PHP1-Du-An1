<?php
/**
 * FILE: helpers/response.php
 * CHỨC NĂNG: Các hàm tiện ích cho việc debug, format dữ liệu, kiểm tra method
 * 
 * PHỤ THUỘC: Không
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/response.php';
 *   dd($variable); // dump và dừng
 *   echo formatMoney(150000); // "150,000₫"
 */

/**
 * dump và die - dùng để debug
 * 
 * Input:
 *   - $data: mixed - biến bất kỳ muốn xem
 * 
 * Output: in ra màn hình có dạng <pre> và dừng script
 * Gợi ý:
 *   echo '<pre>';
 *   var_dump($data);
 *   echo '</pre>';
 *   die;
 */
function dd($data)
{
    // TODO: code tại đây
}

/**
 * dump không die - chỉ in ra để xem
 * 
 * Input:
 *   - $data: mixed
 * 
 * Output: in ra màn hình có dạng <pre>
 */
function dumpData($data)
{
    // TODO: code tại đây
}

/**
 * Escape HTML - chống XSS
 * 
 * Input:
 *   - $data: string - dữ liệu cần hiển thị ra HTML
 * 
 * Output: string đã được htmlspecialchars
 * Gợi ý: return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
 * 
 * CÁCH DÙNG TRONG VIEW: <?= e($product['name']) ?>
 */
function e($data)
{
    // TODO: code tại đây
}

/**
 * Format tiền VNĐ
 * 
 * Input:
 *   - $amount: int|float - số tiền
 * 
 * Output: string ví dụ "150,000₫"
 * Gợi ý: return number_format($amount, 0, ',', '.') . '₫';
 */
function formatMoney($amount)
{
    // TODO: code tại đây
}

/**
 * Kiểm tra method POST
 * 
 * Input:  (dựa vào $_SERVER['REQUEST_METHOD'])
 * Output: true nếu là POST
 * Gợi ý: return $_SERVER['REQUEST_METHOD'] === 'POST';
 */
function isPost()
{
    // TODO: code tại đây
}

/**
 * Kiểm tra method GET
 * 
 * Input:  (dựa vào $_SERVER['REQUEST_METHOD'])
 * Output: true nếu là GET
 */
function isGet()
{
    // TODO: code tại đây
}

/**
 * Lấy giá trị từ $_POST an toàn
 * 
 * Input:
 *   - $key: string - tên field
 *   - $default: mixed - giá trị mặc định (mặc định null)
 * 
 * Output: giá trị từ $_POST[$key] hoặc $default nếu không tồn tại
 */
function inputPost($key, $default = null)
{
    // TODO: code tại đây
}

/**
 * Lấy giá trị từ $_GET an toàn
 * 
 * Input:
 *   - $key: string - tên tham số
 *   - $default: mixed - giá trị mặc định
 * 
 * Output: giá trị từ $_GET[$key] hoặc $default
 */
function inputGet($key, $default = null)
{
    // TODO: code tại đây
}

/**
 * Set flash message (lưu vào session, chỉ hiện 1 lần)
 * 
 * Input:
 *   - $type: string 'success'|'error'|'warning'|'info'
 *   - $message: string nội dung
 * 
 * Output: lưu vào $_SESSION['flash']
 * Gợi ý: $_SESSION['flash'] = ['type' => $type, 'message' => $message];
 */
function setFlash($type, $message)
{
    // TODO: code tại đây
}

/**
 * Lấy flash message và xóa khỏi session
 * 
 * Input:  (dựa vào $_SESSION['flash'])
 * Output: array ['type' => ..., 'message' => ...] hoặc null nếu không có
 * Gợi ý:
 *   if (isset($_SESSION['flash'])) {
 *       $flash = $_SESSION['flash'];
 *       unset($_SESSION['flash']);
 *       return $flash;
 *   }
 *   return null;
 */
function getFlash()
{
    // TODO: code tại đây
}
