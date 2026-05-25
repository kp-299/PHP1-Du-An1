<?php
/**
 * FILE: controllers/admin/SettingController.php
 * CHỨC NĂNG: Quản lý cài đặt website (logo, banner, thông tin, ...)
 * 
 * CLASS: AdminSettingController
 * 
 * ROUTE MẪU:
 *   GET  index.php?area=admin&controller=setting&action=index      -> form cài đặt
 *   POST index.php?area=admin&controller=setting&action=update     -> lưu cài đặt
 *   POST index.php?area=admin&controller=setting&action=updateLogo -> cập nhật logo
 *   POST index.php?area=admin&controller=setting&action=updateBanner -> cập nhật banner
 * 
 * VIEW TƯƠNG ỨNG:
 *   views/pages/admin/setting_index.php
 * 
 * YÊU CẦU: requireAdmin()
 * 
 * CÁC SETTING MẪU:
 *   site_name       => text
 *   homepage_notice => text
 *   footer_content  => text
 *   primary_color   => color (mã hex)
 *   font_family     => text
 *   logo            => image (upload)
 *   banner          => image (upload)
 */

require_once __DIR__ . '/../BaseController.php';

class AdminSettingController extends BaseController
{
    protected $folder = 'pages/admin';

    /**
     * Trang cài đặt website
     * 
     * Output: render view với:
     *   - $title: string 'Cài đặt website'
     *   - $settings: array (dạng key=>value từ WebSetting::getSimpleSettings())
     */
    public function index()
    {
        // TODO: code tại đây
    }

    /**
     * Lưu cài đặt chung (POST)
     * 
     * Input:  $_POST['site_name'], $_POST['homepage_notice'],
     *         $_POST['footer_content'], $_POST['primary_color'], $_POST['font_family']
     * 
     * Output: redirect về trang cài đặt
     * 
     * Gợi ý:
     *   $settings = new WebSetting();
     *   $settings->updateMany($_POST);
     *   setFlash('success', 'Đã cập nhật cài đặt');
     *   redirectAdmin('setting', 'index');
     */
    public function update()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật logo (POST)
     * 
     * Input:  $_FILES['logo']
     * Output: redirect về trang cài đặt
     * 
     * Các bước:
     *   1. Upload ảnh mới (uploadImage($_FILES['logo'], 'settings'))
     *   2. Nếu upload thành công, xóa ảnh logo cũ (deleteImage)
     *   3. WebSetting::updateSetting('logo', $newPath)
     */
    public function updateLogo()
    {
        // TODO: code tại đây
    }

    /**
     * Cập nhật banner (POST)
     * 
     * Input:  $_FILES['banner']
     * Output: redirect về trang cài đặt
     * 
     * Tương tự updateLogo
     */
    public function updateBanner()
    {
        // TODO: code tại đây
    }
}
