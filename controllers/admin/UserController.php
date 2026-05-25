<?php
/**
 * FILE: controllers/admin/UserController.php
 * CHỨC NĂNG: Quản lý người dùng cho Admin
 * 
 * CLASS: AdminUserController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=admin&controller=user&action=index        -> danh sách user
 *   GET  index.php?area=admin&controller=user&action=detail&id=1  -> chi tiết user
 *   POST index.php?area=admin&controller=user&action=updateStatus -> khóa/mở user
 *   POST index.php?area=admin&controller=user&action=updateRole   -> đổi role
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/user_index.php
 *   views/pages/admin/user_detail.php
 * 
 * YÊU CẦU: requireAdmin()
 */

require_once __DIR__ . '/../BaseController.php';

class AdminUserController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Danh sách người dùng (có filter, search)
     * 
     * Output: render view với:
     *   - $title: string 'Quản lý người dùng'
     *   - $users: array
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Chi tiết người dùng
     * 
     * Input:  $_GET['id']
     * Output: render view với $user
     */
    public function detail()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật trạng thái (active/blocked)
     * 
     * Input:  $_POST['user_id'], $_POST['status']
     * Output: redirect về index
     * 
     * LƯU Ý: Không cho admin khóa chính mình
     *   if ($userId == currentUserId()) {
     *       setFlash('error', 'Không thể tự khóa chính mình');
     *       redirectBack();
     *   }
     */
    public function updateStatus()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật quyền (user/admin)
     * 
     * Input:  $_POST['user_id'], $_POST['role']
     * Output: redirect về index
     */
    public function updateRole()
    {
        // TODO: code tại đây
    }
}
