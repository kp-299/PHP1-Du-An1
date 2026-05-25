<?php
/**
 * FILE: models/Log.php
 * CHỨC NĂNG: Model xử lý bảng logs (ghi lại hoạt động)
 * 
 * BẢNG: logs
 *   id, user_id (nullable), action, ip_address, browser,
 *   url, method, created_at
 * 
 * CÁCH DÙNG:
 *   $logModel = new Log();
 *   $logs = $logModel->getAllLogs();
 *   $logModel->clearOld(30); // xóa log cũ hơn 30 ngày
 */

require_once __DIR__ . '/BaseModel.php';

class Log extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'logs';
    }

    /**
     * Thêm log mới
     * 
     * Input:
     *   - $data: array [
     *       'user_id'    => int|null,
     *       'action'     => string,
     *       'ip_address' => string,
     *       'browser'    => string,
     *       'url'        => string,
     *       'method'     => string
     *     ]
     * 
     * Output: int|false - ID vừa insert
     * 
     * SQL: INSERT INTO logs (user_id, action, ip_address, browser, url, method)
     *      VALUES (:user_id, :action, :ip_address, :browser, :url, :method)
     */
    public function create($data)
    {
        // TODO: code tại đây
    }

    /**
     * Lấy danh sách logs (có filter)
     * 
     * Input:
     *   - $filters: array [
     *       'action'    => string (optional),
     *       'user_id'   => int (optional),
     *       'date_from' => string (optional, Y-m-d),
     *       'date_to'   => string (optional, Y-m-d),
     *       'limit'     => int,
     *       'offset'    => int
     *     ]
     * 
     * Output: array - logs kèm user_name nếu có user_id
     * 
     * SQL:
     *   SELECT l.*, u.name AS user_name
     *   FROM logs l
     *   LEFT JOIN users u ON l.user_id = u.id
     *   WHERE 1=1 + điều kiện động
     *   ORDER BY l.created_at DESC
     */
    public function getAllLogs($filters = [])
    {
        // TODO: code tại đây
    }

    /**
     * Xóa toàn bộ logs
     * 
     * Input:  (không tham số)
     * Output: bool
     * 
     * SQL: TRUNCATE TABLE logs
     * hoặc: DELETE FROM logs
     */
    public function clearAll()
    {
        // TODO: code tại đây
    }

    /**
     * Xóa logs cũ hơn N ngày
     * 
     * Input:
     *   - $days: int (mặc định 30) - số ngày giữ lại
     * 
     * Output: bool
     * 
     * SQL: DELETE FROM logs WHERE created_at < NOW() - INTERVAL :days DAY
     */
    public function clearOld($days = 30)
    {
        // TODO: code tại đây
    }
}
