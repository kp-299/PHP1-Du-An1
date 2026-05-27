<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/upload.php';
require_once __DIR__ . '/../../helpers/log.php';

require_once __DIR__ . '/../../models/WebSetting.php';

class AdminSettingController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $settingModel = new WebSetting();

        $settings = $settingModel->getSimpleSettings();

        $this->renderAdmin('settings/index', [
            'title' => 'Cài đặt website',
            'settings' => $settings,
        ]);
    }

    public function update()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=setting&action=index');
            exit;
        }

        $settingModel = new WebSetting();

        foreach ($_POST as $key => $value) {
            $settingModel->createOrUpdate($key, $value);
        }

        $logo = uploadImage($_FILES['logo'] ?? null, 'settings');

        if ($logo) {
            $settingModel->createOrUpdate('logo', $logo, 'image');
        }

        $banner = uploadImage($_FILES['banner'] ?? null, 'settings');

        if ($banner) {
            $settingModel->createOrUpdate('banner', $banner, 'image');
        }

        createLog('update_settings');

        header('Location: index.php?area=admin&controller=setting&action=index');
        exit;
    }
}