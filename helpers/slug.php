<?php
/**
 * FILE: helpers/slug.php
 * CHỨC NĂNG: Tạo slug từ chuỗi tiếng Việt (dùng cho URL thân thiện)
 * 
 * PHỤ THUỘC: Không
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/slug.php';
 *   $slug = createSlug('Táo đỏ nhập khẩu');
 *   // Kết quả: 'tao-do-nhap-khau'
 */

/**
 * Tạo slug từ chuỗi ký tự (hỗ trợ tiếng Việt)
 * 
 * Input:
 *   - $str: string - chuỗi cần tạo slug (ví dụ: 'Táo đỏ Mỹ')
 * 
 * Output: string - slug đã được xử lý (ví dụ: 'tao-do-my')
 * 
 * Các bước cần xử lý:
 *   1. Loại bỏ dấu tiếng Việt (dùng strtr để map ký tự có dấu -> không dấu)
 *      Ví dụ: 'à' -> 'a', 'á' -> 'a', 'ạ' -> 'a', 'đ' -> 'd', ...
 *   2. Chuyển sang chữ thường: strtolower()
 *   3. Thay khoảng trắng và ký tự đặc biệt bằng dấu gạch ngang
 *   4. Loại bỏ dấu gạch ngang thừa ở đầu/cuối
 * 
 * Gợi ý:
 *   $unicode = [
 *       'a' => 'àáảãạăằắẳẵặâầấẩẫậ',
 *       'd' => 'đ',
 *       'e' => 'èéẻẽẹêềếểễệ',
 *       'i' => 'ìíỉĩị',
 *       'o' => 'òóỏõọôồốổỗộơờớởỡợ',
 *       'u' => 'ùúủũụưừứửữự',
 *       'y' => 'ỳýỷỹỵ',
 *   ];
 *   foreach ($unicode as $ascii => $accents) {
 *       $str = str_replace(preg_split('//u', $accents, -1, PREG_SPLIT_NO_EMPTY), $ascii, $str);
 *   }
 *   $str = strtolower(trim($str));
 *   $str = preg_replace('/[^a-z0-9-]/', '-', $str);
 *   $str = preg_replace('/-+/', '-', $str);
 *   return trim($str, '-');
 */
function createSlug($str)
{
    // TODO: code tại đây
}
