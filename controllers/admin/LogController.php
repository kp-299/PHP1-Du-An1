<?php
/**
 * FILE: controllers/admin/LogController.php
 * CHỨC NĂNG: Xem và quản lý logs hệ thống
 * 
 * CLASS: AdminLogController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=admin&controller=log&action=index     -> danh sách log
 *   GET  index.php?area=admin&controller=log&action=detail&id=1 -> chi tiết log
 *   POST index.php?area=admin&controller=log&action=clearAll -> xóa toàn bộ
 *   POST index.php?area=admin&controller=log&action=clearOld -> xóa log cũ
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/log_index.php
 *   views/pages/admin/log_detail.php
 * 
 * YÊU CẦU: requireAdmin()
 */

require_once __DIR__ . '/../BaseController.php';

class AdminLogController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Danh sách logs (có filter theo action, ngày)
     * 
     * Output: render view với:
     *   - $title: string 'Lịch sử hoạt động'
     *   - $logs: array (kèm user_name)
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Chi tiết log
     * 
     * Input:  $_GET['id']
     * Output: render view với $log
     */
    public function detail()
    {
        // TODO: code tại đây
    }

    /**
     * Xóa toàn bộ logs (POST)
     * 
     * Output: redirect về index + flash
     */
    public function clearAll()
    {
        // TODO: code tại đây
    }

    /**
     * Xóa logs cũ (POST)
     * 
     * Input:  $_POST['days'] (mặc định 30)
     * Output: redirect về index + flash
     */
    public function clearOld()
    {
        // TODO: code tại đây
    }
}
