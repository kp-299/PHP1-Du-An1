<?php
$activeTab = $_GET['tab'] ?? 'content';

function activeSettingTab($tab, $activeTab)
{
    return $tab === $activeTab
        ? 'bg-slate-950 text-white shadow-sm'
        : 'bg-white text-slate-600 hover:bg-slate-100';
}

function settingValue($settings, $key, $default = '')
{
    return htmlspecialchars($settings[$key] ?? $default);
}

function settingImage($settings, $key)
{
    return $settings[$key] ?? '';
}
?>

<div class="admin-page max-w-7xl mx-auto">
    <div class="mb-6 sm:mb-8">
        <p class="text-sm text-slate-500">Admin Dashboard</p>

        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
            Cài đặt website
        </h1>

        <p class="text-slate-500 mt-2 max-w-3xl">
            Quản lý thông tin website, logo, banner, ảnh auth, popup, màu sắc và font chữ hiển thị ngoài client.
        </p>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div
            class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> mb-6 rounded-3xl">
            <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="bg-white border border-slate-200 rounded-[2rem] p-2 mb-6 shadow-sm">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
            <a href="index.php?area=admin&controller=setting&action=index&tab=content"
                class="px-5 py-3 rounded-2xl text-center font-bold transition <?= activeSettingTab('content', $activeTab) ?>">
                Nội dung
            </a>

            <a href="index.php?area=admin&controller=setting&action=index&tab=banners"
                class="px-5 py-3 rounded-2xl text-center font-bold transition <?= activeSettingTab('banners', $activeTab) ?>">
                Logo & Banner
            </a>

            <a href="index.php?area=admin&controller=setting&action=index&tab=theme"
                class="px-5 py-3 rounded-2xl text-center font-bold transition <?= activeSettingTab('theme', $activeTab) ?>">
                Màu sắc & Font
            </a>
        </div>
    </div>

    <?php if ($activeTab === 'content'): ?>
        <form action="index.php?area=admin&controller=setting&action=updateContent" method="POST" class="space-y-6">
            <!-- Website info -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Thông tin website
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Các thông tin này dùng cho navbar, footer và trang liên hệ.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tên website
                        </label>

                        <input type="text" name="site_name" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'site_name', 'Fresh Fruit Store') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Subtitle website
                        </label>

                        <input type="text" name="site_subtitle" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'site_subtitle', 'Fresh Fruit Store') ?>"
                            placeholder="Ví dụ: Trái cây tươi mỗi ngày">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Số điện thoại liên hệ
                        </label>

                        <input type="text" name="contact_phone" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'contact_phone') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Email liên hệ
                        </label>

                        <input type="email" name="contact_email" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'contact_email') ?>">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Địa chỉ liên hệ
                        </label>

                        <input type="text" name="contact_address" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'contact_address') ?>">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Footer content
                        </label>

                        <textarea name="footer_content"
                            class="textarea textarea-bordered rounded-2xl w-full min-h-28"><?= settingValue($settings, 'footer_content') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Home content -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Nội dung trang Home
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Các tiêu đề chính hiển thị ở trang chủ client.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Hero title
                        </label>

                        <input type="text" name="home_hero_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'home_hero_title') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Hero subtitle
                        </label>

                        <input type="text" name="home_hero_subtitle" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'home_hero_subtitle') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tiêu đề section sản phẩm
                        </label>

                        <input type="text" name="home_product_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'home_product_title') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tiêu đề section video
                        </label>

                        <input type="text" name="home_video_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'home_video_title') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tiêu đề section bài viết
                        </label>

                        <input type="text" name="home_post_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'home_post_title') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Thông báo nhỏ ở hero
                        </label>

                        <input type="text" name="homepage_notice" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'homepage_notice', 'Giảm giá trái cây tươi mỗi ngày') ?>">
                    </div>
                </div>
            </div>

            <!-- Auth content -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Nội dung Login / Register
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Tiêu đề và mô tả bên phần ảnh của trang đăng nhập, đăng ký.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Login title
                        </label>

                        <input type="text" name="auth_login_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'auth_login_title', 'Chào mừng quay lại') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Register title
                        </label>

                        <input type="text" name="auth_register_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'auth_register_title', 'Tạo tài khoản mới') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Login subtitle
                        </label>

                        <textarea name="auth_login_subtitle"
                            class="textarea textarea-bordered rounded-2xl w-full min-h-24"><?= settingValue($settings, 'auth_login_subtitle') ?></textarea>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Register subtitle
                        </label>

                        <textarea name="auth_register_subtitle"
                            class="textarea textarea-bordered rounded-2xl w-full min-h-24"><?= settingValue($settings, 'auth_register_subtitle') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Modal popup -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5 mb-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                            Modal popup
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Popup sẽ hiện một lần trong phiên truy cập của user.
                        </p>
                    </div>

                    <div class="w-full lg:w-64">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Trạng thái popup
                        </label>

                        <select name="popup_enabled" class="select select-bordered rounded-2xl w-full">
                            <option value="0" <?= (($settings['popup_enabled'] ?? '0') === '0') ? 'selected' : '' ?>>
                                Tắt popup
                            </option>

                            <option value="1" <?= (($settings['popup_enabled'] ?? '0') === '1') ? 'selected' : '' ?>>
                                Bật popup
                            </option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Tiêu đề popup
                        </label>

                        <input type="text" name="popup_title" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'popup_title') ?>" placeholder="Ưu đãi hôm nay">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Nội dung popup
                        </label>

                        <input type="text" name="popup_content" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'popup_content') ?>"
                            placeholder="Giảm giá 20% cho đơn hàng đầu tiên.">
                    </div>
                </div>
            </div>

            <div class="sticky bottom-4 flex justify-end">
                <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl shadow-lg">
                    Lưu nội dung
                </button>
            </div>
        </form>
    <?php endif; ?>

    <?php if ($activeTab === 'banners'): ?>
        <form action="index.php?area=admin&controller=setting&action=updateBanners" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            <!-- Logo -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Logo website
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Logo dùng cho admin sidebar, client navbar và footer.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-5">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Upload logo
                        </label>

                        <input type="file" name="logo" class="file-input file-input-bordered rounded-2xl w-full bg-white">

                        <p class="text-xs text-slate-500 mt-2">
                            Nên dùng ảnh vuông, nền trong suốt hoặc nền đơn giản.
                        </p>
                    </div>

                    <div
                        class="rounded-3xl bg-slate-50 border border-slate-200 p-5 flex items-center justify-center min-h-40">
                        <?php if (!empty($settings['logo'])): ?>
                            <img src="<?= htmlspecialchars($settings['logo']) ?>" class="max-h-28 rounded-2xl object-cover"
                                alt="Logo">
                        <?php else: ?>
                            <span class="text-slate-400">Chưa có logo</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Auth image -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Ảnh trang Login / Register
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Có thể upload một ảnh dùng chung hoặc upload riêng từng ảnh.
                    </p>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
                    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-5">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Ảnh dùng chung
                        </label>

                        <input type="file" name="auth_image"
                            class="file-input file-input-bordered rounded-2xl w-full bg-white">

                        <p class="text-xs text-slate-500 mt-2">
                            Nếu upload ảnh này, hệ thống sẽ áp dụng cho cả login và register.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-5">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Ảnh Login
                        </label>

                        <input type="file" name="auth_login_image"
                            class="file-input file-input-bordered rounded-2xl w-full">

                        <div
                            class="mt-4 rounded-3xl bg-slate-100 border border-slate-200 overflow-hidden h-44 flex items-center justify-center">
                            <?php if (!empty($settings['auth_login_image'])): ?>
                                <img src="<?= htmlspecialchars($settings['auth_login_image']) ?>"
                                    class="w-full h-full object-cover" alt="Login image">
                            <?php else: ?>
                                <span class="text-slate-400 text-sm">Chưa có ảnh login</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-5">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Ảnh Register
                        </label>

                        <input type="file" name="auth_register_image"
                            class="file-input file-input-bordered rounded-2xl w-full">

                        <div
                            class="mt-4 rounded-3xl bg-slate-100 border border-slate-200 overflow-hidden h-44 flex items-center justify-center">
                            <?php if (!empty($settings['auth_register_image'])): ?>
                                <img src="<?= htmlspecialchars($settings['auth_register_image']) ?>"
                                    class="w-full h-full object-cover" alt="Register image">
                            <?php else: ?>
                                <span class="text-slate-400 text-sm">Chưa có ảnh register</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $bannerGroups = [
                'home_hero_banners' => [
                    'label' => 'Home - Hero carousel',
                    'desc' => 'Banner chính ở hero trang chủ.',
                    'items' => $homeHeroBanners ?? [],
                ],
                'home_bottom_banners' => [
                    'label' => 'Home - Bottom carousel',
                    'desc' => 'Banner quảng cáo phía gần cuối trang chủ.',
                    'items' => $homeBottomBanners ?? [],
                ],
                'product_header_banners' => [
                    'label' => 'Product - Header carousel',
                    'desc' => 'Banner đầu trang danh sách sản phẩm.',
                    'items' => $productHeaderBanners ?? [],
                ],
            ];
            ?>

            <?php foreach ($bannerGroups as $key => $group): ?>
                <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                                <?= htmlspecialchars($group['label']) ?>
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                <?= htmlspecialchars($group['desc']) ?> Tối đa 8 ảnh.
                            </p>
                        </div>

                        <span class="badge badge-neutral rounded-xl">
                            <?= count($group['items']) ?>/8 ảnh
                        </span>
                    </div>

                    <input type="file" name="<?= htmlspecialchars($key) ?>[]"
                        class="file-input file-input-bordered rounded-2xl w-full" multiple>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-5">
                        <?php foreach ($group['items'] as $image): ?>
                            <div class="relative rounded-3xl overflow-hidden border border-slate-200 bg-slate-50 group">
                                <img src="<?= htmlspecialchars($image) ?>" class="w-full h-40 object-cover" alt="Banner">

                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/25 transition"></div>

                                <a href="index.php?area=admin&controller=setting&action=removeBanner&key=<?= urlencode($key) ?>&image=<?= urlencode($image) ?>"
                                    class="btn btn-xs btn-error absolute top-3 right-3 rounded-xl"
                                    onclick="return confirm('Xóa banner này?')">
                                    Xóa
                                </a>
                            </div>
                        <?php endforeach; ?>

                        <?php if (empty($group['items'])): ?>
                            <div
                                class="col-span-full rounded-3xl border border-dashed border-slate-300 p-8 text-center text-slate-400">
                                Chưa có banner.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Single header banners -->
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Header ảnh đơn cho Post / Video
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Mỗi trang dùng một ảnh header riêng.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Post header banner
                        </label>

                        <input type="file" name="post_header_banner"
                            class="file-input file-input-bordered rounded-2xl w-full">

                        <div
                            class="mt-4 rounded-3xl bg-slate-100 border border-slate-200 overflow-hidden h-44 flex items-center justify-center">
                            <?php if (!empty($settings['post_header_banner'])): ?>
                                <img src="<?= htmlspecialchars($settings['post_header_banner']) ?>"
                                    class="w-full h-full object-cover" alt="Post header">
                            <?php else: ?>
                                <span class="text-slate-400 text-sm">Chưa có ảnh post header</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Video header banner
                        </label>

                        <input type="file" name="video_header_banner"
                            class="file-input file-input-bordered rounded-2xl w-full">

                        <div
                            class="mt-4 rounded-3xl bg-slate-100 border border-slate-200 overflow-hidden h-44 flex items-center justify-center">
                            <?php if (!empty($settings['video_header_banner'])): ?>
                                <img src="<?= htmlspecialchars($settings['video_header_banner']) ?>"
                                    class="w-full h-full object-cover" alt="Video header">
                            <?php else: ?>
                                <span class="text-slate-400 text-sm">Chưa có ảnh video header</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sticky bottom-4 flex justify-end">
                <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl shadow-lg">
                    Lưu logo & banner
                </button>
            </div>
        </form>
    <?php endif; ?>

    <?php if ($activeTab === 'theme'): ?>
        <form action="index.php?area=admin&controller=setting&action=updateTheme" method="POST"
            enctype="multipart/form-data" class="space-y-6">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Màu sắc website
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Các màu này sẽ dùng cho button, gradient và điểm nhấn ngoài client.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Primary color
                        </label>

                        <input type="color" name="primary_color" class="input input-bordered rounded-2xl w-full h-14"
                            value="<?= settingValue($settings, 'primary_color', '#22c55e') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Secondary color
                        </label>

                        <input type="color" name="secondary_color" class="input input-bordered rounded-2xl w-full h-14"
                            value="<?= settingValue($settings, 'secondary_color', '#84cc16') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Accent color
                        </label>

                        <input type="color" name="accent_color" class="input input-bordered rounded-2xl w-full h-14"
                            value="<?= settingValue($settings, 'accent_color', '#f97316') ?>">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Background & Font
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Cấu hình nền website và font chữ tổng thể.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Loại background
                        </label>

                        <select name="background_type" class="select select-bordered rounded-2xl w-full">
                            <?php $bgType = $settings['background_type'] ?? 'color'; ?>

                            <option value="color" <?= $bgType === 'color' ? 'selected' : '' ?>>
                                Màu đơn
                            </option>

                            <option value="gradient" <?= $bgType === 'gradient' ? 'selected' : '' ?>>
                                Gradient
                            </option>

                            <option value="image" <?= $bgType === 'image' ? 'selected' : '' ?>>
                                Ảnh
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Font family
                        </label>

                        <select name="font_family" class="select select-bordered rounded-2xl w-full">
                            <?php $font = $settings['font_family'] ?? 'Inter, sans-serif'; ?>

                            <option value="Inter, sans-serif" <?= $font === 'Inter, sans-serif' ? 'selected' : '' ?>>
                                Inter
                            </option>

                            <option value="Arial, sans-serif" <?= $font === 'Arial, sans-serif' ? 'selected' : '' ?>>
                                Arial
                            </option>

                            <option value="Roboto, sans-serif" <?= $font === 'Roboto, sans-serif' ? 'selected' : '' ?>>
                                Roboto
                            </option>

                            <option value="Poppins, sans-serif" <?= $font === 'Poppins, sans-serif' ? 'selected' : '' ?>>
                                Poppins
                            </option>

                            <option value="system-ui, sans-serif"
                                <?= $font === 'system-ui, sans-serif' ? 'selected' : '' ?>>
                                System UI
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Background color
                        </label>

                        <input type="color" name="background_color" class="input input-bordered rounded-2xl w-full h-14"
                            value="<?= settingValue($settings, 'background_color', '#f8fafc') ?>">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Background image
                        </label>

                        <input type="file" name="background_image"
                            class="file-input file-input-bordered rounded-2xl w-full">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Background gradient CSS
                        </label>

                        <input type="text" name="background_gradient" class="input input-bordered rounded-2xl w-full"
                            value="<?= settingValue($settings, 'background_gradient') ?>"
                            placeholder="linear-gradient(135deg, #ecfdf5 0%, #f7fee7 50%, #fefce8 100%)">
                    </div>
                </div>
            </div>

            <div class="sticky bottom-4 flex justify-end">
                <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl shadow-lg">
                    Lưu màu sắc & font
                </button>
            </div>
        </form>
    <?php endif; ?>
</div>