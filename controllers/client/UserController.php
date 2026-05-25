<?php
/**
 * FILE: controllers/client/UserController.php
 * CHỨC NĂNG: Xử lý thông tin cá nhân của user (dashboard user)
 * 
 * CLASS: ClientUserController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=client&controller=user&action=profile     -> xem thông tin
 *   POST index.php?area=client&controller=user&action=update      -> cập nhật thông tin
 *   POST index.php?area=client&controller=user&action=changePassword -> đổi mật khẩu
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/profile.php
 * 
 * YÊU CẦU: Tất cả action đều cần requireLogin()
 * 
 * CÁCH DÙNG:
 *   $userModel = new User();
 *   $user = $userModel->find($userId);
 *   $userModel->updateProfile($userId, $data);
 *   $userModel->updatePassword($userId, $newHash);
 */

require_once __DIR__ . '/../BaseController.php';

class ClientUserController extends BaseController
{
    protected $folder = 'pages';

    /**
     * Hiển thị thông tin cá nhân
     * 
     * Output: render views/pages/profile.php với:
     *   - $title: string 'Thông tin cá nhân'
     *   - $user: array thông tin user hiện tại (lấy từ DB)
     * 
     * Gợi ý: $user = (new User())->find(currentUserId());
     */
    public function profile()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật thông tin cá nhân (POST)
     * 
     * Input:  $_POST['name'], $_POST['phone'], $_POST['address']
     * Output: redirect về profile + flash message
     * 
     * Các bước:
     *   1. require POST
     *   2. Lấy dữ liệu từ $_POST
     *   3. Gọi (new User())->updateProfile($userId, $data)
     *   4. setFlash success
     *   5. redirect về profile
     */
    public function update()
    {
        // TODO: code tại đây
    }

    /**
     * Đổi mật khẩu (POST)
     * 
     * Input:  $_POST['current_password'], $_POST['new_password'], $_POST['confirm_password']
     * Output: redirect về profile + flash
     * 
     * Các bước:
     *   1. Lấy user từ DB (có password_hash)
     *   2. Kiểm tra current_password (password_verify)
     *   3. Kiểm tra new_password == confirm_password
     *   4. Hash password mới
     *   5. updatePassword
     *   6. setFlash success
     */
    public function changePassword()
    {
        // TODO: code tại đây
    }
}
