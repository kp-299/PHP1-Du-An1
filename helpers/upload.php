<?php
/**
 * FILE: helpers/upload.php
 * CHỨC NĂNG: Xử lý upload và xóa file ảnh
 * 
 * PHỤ THUỘC: helpers/slug.php (nếu cần tạo tên file từ slug)
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/upload.php';
 *   $imagePath = uploadImage($_FILES['image'], 'products');
 *   deleteImage('uploads/products/abc.jpg');
 * 
 * LƯU Ý: Cần tạo folder uploads/products, uploads/categories, ... trước
 */

/**
 * Upload ảnh lên server
 * 
 * Input:
 *   - $file: array - $_FILES['tên_field'] (phải có 'name', 'tmp_name', 'error')
 *   - $folder: string - tên thư mục con trong uploads/ (vd: 'products', 'categories')
 * 
 * Output:
 *   - string - đường dẫn ảnh đã upload (vd: 'uploads/products/abc123.jpg')
 *   - hoặc null nếu upload thất bại
 * 
 * Các bước cần code:
 *   1. Kiểm tra $file['error'] === 0 (không có lỗi)
 *   2. Lấy đuôi file: pathinfo($file['name'], PATHINFO_EXTENSION)
 *   3. Tạo tên file duy nhất: time() . '_' . uniqid() . '.' . $extension
 *      (hoặc dùng slug của tên gốc + time)
 *   4. Đường dẫn đích: __DIR__ . '/../uploads/' . $folder . '/' . $newFileName
 *   5. move_uploaded_file($file['tmp_name'], $destination)
 *   6. Nếu OK, return 'uploads/' . $folder . '/' . $newFileName
 *   7. Nếu lỗi, return null
 * 
 * MỞ RỘNG SAU: có thể kiểm tra loại file (jpg, png, webp), kích thước tối đa
 */
function uploadImage($file, $folder)
{
    // TODO: code tại đây
}

/**
 * Xóa file ảnh
 * 
 * Input:
 *   - $path: string - đường dẫn file (vd: 'uploads/products/abc.jpg')
 * 
 * Output: true nếu xóa thành công hoặc file không tồn tại, false nếu lỗi
 * 
 * Gợi ý:
 *   if ($path && file_exists(__DIR__ . '/../' . $path)) {
 *       return unlink(__DIR__ . '/../' . $path);
 *   }
 *   return true; // file không tồn tại coi như xóa thành công
 */
function deleteImage($path)
{
    // TODO: code tại đây
}

/**
 * Lấy đường dẫn đầy đủ của ảnh (để hiển thị)
 * 
 * Input:
 *   - $path: string - đường dẫn tương đối (vd: 'uploads/products/abc.jpg')
 * 
 * Output: string - đường dẫn có thể null, trả về placeholder
 * Gợi ý: if ($path) return $path; return 'public/images/no-image.png';
 */
function imageUrl($path)
{
    // TODO: code tại đây
}
