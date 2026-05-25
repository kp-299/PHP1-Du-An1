<?php
/**
 * FILE: models/WebSetting.php
 * CHỨC NĂNG: Model xử lý bảng web_settings (cài đặt website động)
 * 
 * BẢNG: web_settings
 *   id, setting_key, setting_value, type (text/image/color), updated_at
 * 
 * CÁC SETTING MẪU:
 *   site_name       => 'Trái Cây Tươi'
 *   logo            => 'uploads/settings/logo.png'
 *   banner          => 'uploads/settings/banner.jpg'
 *   primary_color   => '#16a34a'
 *   font_family     => 'Inter, sans-serif'
 *   homepage_notice => 'Giảm giá 20%...'
 *   footer_content  => '© 2024 Trái Cây Tươi'
 * 
 * CÁCH DÙNG:
 *   $setting = new WebSetting();
 *   $siteName = $setting->getValue('site_name');
 *   $allSettings = $setting->getAllSettings();
 *   $setting->updateSetting('site_name', 'Trái Cây Tươi Siêu Sạch');
 */

require_once __DIR__ . '/BaseModel.php';

class WebSetting extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        // TODO: set tên bảng
        // $this->table = 'web_settings';
    }

    /**
     * Lấy tất cả settings dạng mảng key-value (dùng cho view)
     * 
     * Input:  (không tham số)
     * Output: array - tất cả settings
     * 
     * Gợi ý:
     *   $stmt = $this->db->query("SELECT * FROM {$this->table}");
     *   return $stmt->fetchAll();
     */
    public function getAllSettings()
    {
        // TODO: code tại đây
    }

    /**
     * Lấy settings dạng key => value (dễ dùng trong view)
     * 
     * Input:  (không tham số)
     * Output: array ['site_name' => 'Trái Cây Tươi', 'logo' => '...', ...]
     * 
     * Gợi ý:
     *   $settings = $this->getAllSettings();
     *   $result = [];
     *   foreach ($settings as $s) {
     *       $result[$s['setting_key']] = $s['setting_value'];
     *   }
     *   return $result;
     */
    public function getSimpleSettings()
    {
        // TODO: code tại đây
    }

    /**
     * Lấy giá trị của một setting
     * 
     * Input:
     *   - $key: string - tên setting
     * 
     * Output: string|null - giá trị hoặc null nếu không tồn tại
     * 
     * SQL: SELECT setting_value FROM web_settings WHERE setting_key = :key LIMIT 1
     */
    public function getValue($key)
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật giá trị setting
     * 
     * Input:
     *   - $key: string
     *   - $value: string
     * 
     * Output: bool
     * 
     * SQL: UPDATE web_settings SET setting_value = :value, updated_at = NOW()
     *      WHERE setting_key = :key
     */
    public function updateSetting($key, $value)
    {
        // TODO: code tại đây
    }

    /**
     * Tạo mới hoặc cập nhật setting (upsert)
     * 
     * Input:
     *   - $key: string
     *   - $value: string
     *   - $type: string (mặc định 'text')
     * 
     * Output: bool
     * 
     * Các bước:
     *   1. Kiểm tra setting đã tồn tại chưa (getValue)
     *   2. Nếu có: gọi updateSetting
     *   3. Nếu chưa: INSERT INTO web_settings (setting_key, setting_value, type)
     *      VALUES (:key, :value, :type)
     */
    public function createOrUpdate($key, $value, $type = 'text')
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật nhiều settings cùng lúc
     * 
     * Input:
     *   - $settings: array ['key1' => 'value1', 'key2' => 'value2', ...]
     * 
     * Output: bool
     * 
     * Gợi ý: Dùng transaction, duyệt mảng và gọi createOrUpdate cho mỗi cặp
     */
    public function updateMany($settings)
    {
        // TODO: code tại đây
    }
}
