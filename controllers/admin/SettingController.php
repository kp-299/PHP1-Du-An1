<?php

require_once __DIR__ . '/../BaseController.php';

require_once __DIR__ . '/../../helpers/auth.php';
require_once __DIR__ . '/../../helpers/upload.php';

require_once __DIR__ . '/../../models/WebSetting.php';

class AdminSettingController extends BaseController
{
    public function index()
    {
        requireAdmin();

        $settingModel = new WebSetting();

        $this->renderAdmin('settings/index', [
            'title' => 'Cài đặt website',
            'settings' => $settingModel->getSimpleSettings(),
            'homeHeroBanners' => $settingModel->getJsonValue('home_hero_banners'),
            'homeBottomBanners' => $settingModel->getJsonValue('home_bottom_banners'),
            'productHeaderBanners' => $settingModel->getJsonValue('product_header_banners'),
        ]);
    }

    public function updateContent()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=setting&action=index');
            exit;
        }

        $settingModel = new WebSetting();

        $settingModel->updateMany([
            'site_name' => [
                'value' => trim($_POST['site_name'] ?? ''),
                'type' => 'text',
            ],
            'footer_content' => [
                'value' => trim($_POST['footer_content'] ?? ''),
                'type' => 'text',
            ],
            'home_hero_title' => [
                'value' => trim($_POST['home_hero_title'] ?? ''),
                'type' => 'text',
            ],
            'home_hero_subtitle' => [
                'value' => trim($_POST['home_hero_subtitle'] ?? ''),
                'type' => 'text',
            ],
            'home_product_title' => [
                'value' => trim($_POST['home_product_title'] ?? ''),
                'type' => 'text',
            ],
            'home_post_title' => [
                'value' => trim($_POST['home_post_title'] ?? ''),
                'type' => 'text',
            ],
            'home_video_title' => [
                'value' => trim($_POST['home_video_title'] ?? ''),
                'type' => 'text',
            ],
            'contact_phone' => [
                'value' => trim($_POST['contact_phone'] ?? ''),
                'type' => 'text',
            ],
            'contact_email' => [
                'value' => trim($_POST['contact_email'] ?? ''),
                'type' => 'text',
            ],
            'contact_address' => [
                'value' => trim($_POST['contact_address'] ?? ''),
                'type' => 'text',
            ],
            'popup_enabled' => [
                'value' => ($_POST['popup_enabled'] ?? '0') === '1' ? '1' : '0',
                'type' => 'text',
            ],
            'popup_title' => [
                'value' => trim($_POST['popup_title'] ?? ''),
                'type' => 'text',
            ],
            'popup_content' => [
                'value' => trim($_POST['popup_content'] ?? ''),
                'type' => 'text',
            ],
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cập nhật nội dung website thành công',
        ];

        header('Location: index.php?area=admin&controller=setting&action=index&tab=content');
        exit;
    }

    public function updateTheme()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=setting&action=index');
            exit;
        }

        $settingModel = new WebSetting();

        $backgroundImage = $settingModel->getValue('background_image', '');

        if (!empty($_FILES['background_image']['name'])) {
            $newBackgroundImage = uploadImage($_FILES['background_image'], 'uploads/settings');

            if ($newBackgroundImage) {
                $backgroundImage = $newBackgroundImage;
            }
        }

        $settingModel->updateMany([
            'primary_color' => [
                'value' => trim($_POST['primary_color'] ?? '#22c55e'),
                'type' => 'color',
            ],
            'secondary_color' => [
                'value' => trim($_POST['secondary_color'] ?? '#84cc16'),
                'type' => 'color',
            ],
            'accent_color' => [
                'value' => trim($_POST['accent_color'] ?? '#f97316'),
                'type' => 'color',
            ],
            'background_type' => [
                'value' => trim($_POST['background_type'] ?? 'color'),
                'type' => 'text',
            ],
            'background_color' => [
                'value' => trim($_POST['background_color'] ?? '#f8fafc'),
                'type' => 'color',
            ],
            'background_gradient' => [
                'value' => trim($_POST['background_gradient'] ?? ''),
                'type' => 'text',
            ],
            'background_image' => [
                'value' => $backgroundImage,
                'type' => 'image',
            ],
            'font_family' => [
                'value' => trim($_POST['font_family'] ?? 'Inter, sans-serif'),
                'type' => 'text',
            ],
            'site_subtitle' => [
                'value' => trim($_POST['site_subtitle'] ?? ''),
                'type' => 'text',
            ],

            'homepage_notice' => [
                'value' => trim($_POST['homepage_notice'] ?? ''),
                'type' => 'text',
            ],

            'auth_login_title' => [
                'value' => trim($_POST['auth_login_title'] ?? ''),
                'type' => 'text',
            ],

            'auth_login_subtitle' => [
                'value' => trim($_POST['auth_login_subtitle'] ?? ''),
                'type' => 'text',
            ],

            'auth_register_title' => [
                'value' => trim($_POST['auth_register_title'] ?? ''),
                'type' => 'text',
            ],

            'auth_register_subtitle' => [
                'value' => trim($_POST['auth_register_subtitle'] ?? ''),
                'type' => 'text',
            ],
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cập nhật màu sắc và font thành công',
        ];

        header('Location: index.php?area=admin&controller=setting&action=index&tab=theme');
        exit;
    }

    public function updateBanners()
    {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?area=admin&controller=setting&action=index');
            exit;
        }

        $settingModel = new WebSetting();

        $this->handleMultipleBannerUpload($settingModel, 'home_hero_banners', 'home_hero_banners');
        $this->handleMultipleBannerUpload($settingModel, 'home_bottom_banners', 'home_bottom_banners');
        $this->handleMultipleBannerUpload($settingModel, 'product_header_banners', 'product_header_banners');

        if (!empty($_FILES['post_header_banner']['name'])) {
            $image = uploadImage($_FILES['post_header_banner'], 'uploads/settings');

            if ($image) {
                $settingModel->updateSetting('post_header_banner', $image, 'image');
            }
        }

        if (!empty($_FILES['video_header_banner']['name'])) {
            $image = uploadImage($_FILES['video_header_banner'], 'uploads/settings');

            if ($image) {
                $settingModel->updateSetting('video_header_banner', $image, 'image');
            }
        }

        if (!empty($_FILES['logo']['name'])) {
            $logo = uploadImage($_FILES['logo'], 'uploads/settings');

            if ($logo) {
                $settingModel->updateSetting('logo', $logo, 'image');
            }
        }

        if (!empty($_FILES['auth_image']['name'])) {
            $authImage = uploadImage($_FILES['auth_image'], 'uploads/settings');

            if ($authImage) {
                $settingModel->updateSetting('auth_login_image', $authImage, 'image');
                $settingModel->updateSetting('auth_register_image', $authImage, 'image');
            }
        }

        if (!empty($_FILES['auth_login_image']['name'])) {
            $authLoginImage = uploadImage($_FILES['auth_login_image'], 'uploads/settings');

            if ($authLoginImage) {
                $settingModel->updateSetting('auth_login_image', $authLoginImage, 'image');
            }
        }

        if (!empty($_FILES['auth_register_image']['name'])) {
            $authRegisterImage = uploadImage($_FILES['auth_register_image'], 'uploads/settings');

            if ($authRegisterImage) {
                $settingModel->updateSetting('auth_register_image', $authRegisterImage, 'image');
            }
        }

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Cập nhật logo và banner thành công',
        ];

        header('Location: index.php?area=admin&controller=setting&action=index&tab=banners');
        exit;
    }

    public function removeBanner()
    {
        requireAdmin();

        $key = $_GET['key'] ?? '';
        $image = $_GET['image'] ?? '';

        $allowedKeys = [
            'home_hero_banners',
            'home_bottom_banners',
            'product_header_banners',
        ];

        if (in_array($key, $allowedKeys) && $image !== '') {
            $settingModel = new WebSetting();
            $settingModel->removeImageFromJson($key, $image);
        }

        header('Location: index.php?area=admin&controller=setting&action=index&tab=banners');
        exit;
    }

    private function handleMultipleBannerUpload($settingModel, $inputName, $settingKey)
    {
        if (empty($_FILES[$inputName]['name'][0])) {
            return;
        }

        $uploadedImages = [];

        foreach ($_FILES[$inputName]['name'] as $index => $name) {
            if (empty($name)) {
                continue;
            }

            $file = [
                'name' => $_FILES[$inputName]['name'][$index],
                'type' => $_FILES[$inputName]['type'][$index],
                'tmp_name' => $_FILES[$inputName]['tmp_name'][$index],
                'error' => $_FILES[$inputName]['error'][$index],
                'size' => $_FILES[$inputName]['size'][$index],
            ];

            $image = uploadImage($file, 'uploads/settings');

            if ($image) {
                $uploadedImages[] = $image;
            }
        }

        $settingModel->appendImages($settingKey, $uploadedImages, 8);
    }
}
