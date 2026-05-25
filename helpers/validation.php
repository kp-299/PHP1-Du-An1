<?php
/**
 * FILE: helpers/validation.php
 * CHỨC NĂNG: Validation dữ liệu đầu vào cho các form
 * 
 * PHỤ THUỘC: Không
 * 
 * CÁCH DÙNG:
 *   require_once __DIR__ . '/helpers/validation.php';
 *   $errors = validateRegister($_POST);
 *   if (!empty($errors)) { ... }
 * 
 * CÁC HÀM validate đều trả về:
 *   - Mảng rỗng [] nếu hợp lệ
 *   - Mảng ['field_name' => 'message lỗi'] nếu có lỗi
 */

// ==================== HÀM CƠ BẢN ====================

/**
 * Kiểm tra trường bắt buộc
 * 
 * Input:
 *   - $value: string - giá trị cần kiểm tra
 *   - $fieldName: string - tên trường (để ghi lỗi)
 * 
 * Output: string rỗng nếu OK, string lỗi nếu không
 * Gợi ý: if (empty(trim($value))) return "$fieldName không được để trống";
 */
function required($value, $fieldName)
{
    // TODO: code tại đây
}

/**
 * Kiểm tra email hợp lệ
 * 
 * Input:
 *   - $email: string
 * 
 * Output: string rỗng nếu OK, string lỗi nếu không
 * Gợi ý: if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return 'Email không hợp lệ';
 */
function isEmail($email)
{
    // TODO: code tại đây
}

/**
 * Kiểm tra độ dài tối thiểu
 * 
 * Input:
 *   - $value: string
 *   - $min: int
 *   - $fieldName: string
 * 
 * Output: string rỗng nếu OK, string lỗi nếu không
 */
function minLength($value, $min, $fieldName)
{
    // TODO: code tại đây
}

/**
 * Kiểm tra độ dài tối đa
 * 
 * Input:
 *   - $value: string
 *   - $max: int
 *   - $fieldName: string
 * 
 * Output: string rỗng nếu OK, string lỗi nếu không
 */
function maxLength($value, $max, $fieldName)
{
    // TODO: code tại đây
}

/**
 * Kiểm tra có phải số không
 * 
 * Input:
 *   - $value: mixed
 * 
 * Output: string rỗng nếu OK, string lỗi nếu không
 */
function isNumber($value)
{
    // TODO: code tại đây
}

/**
 * Kiểm tra số dương
 * 
 * Input:
 *   - $value: mixed
 * 
 * Output: string rỗng nếu OK, string lỗi nếu không
 */
function isPositiveNumber($value)
{
    // TODO: code tại đây
}

// ==================== HÀM VALIDATE FORM ====================

/**
 * Validate form đăng ký
 * 
 * Input:
 *   - $data: array ['name', 'email', 'password', 'confirm_password']
 * 
 * Output: array ['field' => 'message lỗi', ...] hoặc [] nếu OK
 * 
 * Kiểm tra:
 *   - name: required, min 2, max 50
 *   - email: required, isEmail
 *   - password: required, min 6
 *   - confirm_password: required, phải match với password
 */
function validateRegister($data)
{
    $errors = [];
    // TODO: code kiểm tra từng field ở đây
    // Ví dụ:
    // $nameErr = required($data['name'] ?? '', 'Họ tên');
    // if ($nameErr) $errors['name'] = $nameErr;
    return $errors;
}

/**
 * Validate form đăng nhập
 * 
 * Input:
 *   - $data: array ['email', 'password']
 * 
 * Output: array ['field' => 'message lỗi', ...] hoặc [] nếu OK
 * 
 * Kiểm tra:
 *   - email: required
 *   - password: required
 */
function validateLogin($data)
{
    $errors = [];
    // TODO: code tại đây
    return $errors;
}

/**
 * Validate form sản phẩm (dùng cho admin)
 * 
 * Input:
 *   - $data: array ['category_id', 'name', 'price', 'stock', ...]
 * 
 * Output: array lỗi hoặc [] nếu OK
 * 
 * Kiểm tra:
 *   - category_id: required, isNumber
 *   - name: required, min 2, max 200
 *   - price: required, isPositiveNumber
 *   - stock: required, isNumber
 *   - unit: required
 */
function validateProduct($data)
{
    $errors = [];
    // TODO: code tại đây
    return $errors;
}

/**
 * Validate form danh mục (dùng cho admin)
 * 
 * Input:
 *   - $data: array ['name']
 * 
 * Output: array lỗi hoặc [] nếu OK
 * 
 * Kiểm tra:
 *   - name: required, min 2, max 100
 */
function validateCategory($data)
{
    $errors = [];
    // TODO: code tại đây
    return $errors;
}

/**
 * Validate form thanh toán / đặt hàng
 * 
 * Input:
 *   - $data: array ['customer_name', 'customer_phone', 'customer_address']
 * 
 * Output: array lỗi hoặc [] nếu OK
 * 
 * Kiểm tra:
 *   - customer_name: required
 *   - customer_phone: required (có thể check số điện thoại)
 *   - customer_address: required
 */
function validateCheckout($data)
{
    $errors = [];
    // TODO: code tại đây
    return $errors;
}
