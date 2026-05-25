<?php
/**
 * FILE: controllers/client/AuthController.php
 * CHỨC NĂNG: Xử lý đăng ký, đăng nhập, đăng xuất cho Client
 * 
 * CLASS: ClientAuthController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=client&controller=auth&action=login    -> hiện form login
 *   POST index.php?area=client&controller=auth&action=handleLogin -> xử lý login
 *   GET  index.php?area=client&controller=auth&action=register -> hiện form register
 *   POST index.php?area=client&controller=auth&action=handleRegister -> xử lý register
 *   GET  index.php?area=client&controller=auth&action=logout   -> logout
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/login.php
 *   views/pages/register.php
 * 
 * LƯU ĐỒ XỬ LÝ LOGIN:
 *   handleLogin():
 *     1. Check method POST (isPost())
 *     2. Lấy email, password từ $_POST
 *     3. Validate (validateLogin)
 *     4. Tìm user theo email (User::findByEmail)
 *     5. Kiểm tra password (password_verify)
 *     6. Kiểm tra status != 'blocked'
 *     7. Lưu $_SESSION['user'] = [id, name, email, role]
 *     8. Ghi log 'login' (createLog)
 *     9. Nếu role admin -> redirect admin dashboard
 *        Nếu role user -> redirect client home
 * 
 * LƯU ĐỒ XỬ LÝ REGISTER:
 *   handleRegister():
 *     1. Check POST
 *     2. Validate (validateRegister)
 *     3. Kiểm tra email đã tồn tại chưa (User::findByEmail)
 *     4. password_hash($password, PASSWORD_DEFAULT)
 *     5. User::create([...])
 *     6. Ghi log 'register'
 *     7. setFlash success + redirect login
 */

require_once __DIR__ . '/../BaseController.php';

class ClientAuthController extends BaseController
{
    protected $folder = 'pages';

    /**
     * Hiển thị form đăng nhập
     * 
     * Output: render views/pages/login.php
     *   - $title: string 'Đăng nhập'
     */
    public function login()
    {
        // TODO: code tại đây
    }

    /**
     * Hiển thị form đăng ký
     * 
     * Output: render views/pages/register.php
     *   - $title: string 'Đăng ký'
     */
    public function register()
    {
        // TODO: code tại đây
    }

    /**
     * Xử lý đăng nhập (POST)
     * 
     * Input:  $_POST['email'], $_POST['password']
     * Output: redirect đến trang phù hợp hoặc quay lại form login với lỗi
     */
    public function handleLogin()
    {
        // TODO: code tại đây
    }

    /**
     * Xử lý đăng ký (POST)
     * 
     * Input:  $_POST['name'], $_POST['email'], $_POST['password'], $_POST['confirm_password']
     * Output: redirect về login nếu thành công, quay lại form register nếu lỗi
     */
    public function handleRegister()
    {
        // TODO: code tại đây
    }

    /**
     * Xử lý đăng xuất
     * 
     * Các bước:
     *   1. createLog('logout')
     *   2. unset($_SESSION['user'])
     *   3. session_regenerate_id(true)
     *   4. redirect về trang chủ
     */
    public function logout()
    {
        // TODO: code tại đây
    }
}
