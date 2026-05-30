<?php
require_once __DIR__ . '/../../models/WebSetting.php';

$settingModelForSidebar = new WebSetting();
$sidebarSettings = $settingModelForSidebar->getSimpleSettings();

$adminSiteName = $sidebarSettings['site_name'] ?? 'Fruit Admin';
$adminLogo = $sidebarSettings['logo'] ?? '';

$currentController = $_GET['controller'] ?? 'dashboard';
$currentAction = $_GET['action'] ?? 'index';

if (!function_exists('adminMenuClass')) {
    function adminMenuClass($controllerName)
    {
        global $currentController;

        if ($currentController === $controllerName) {
            return 'bg-white/10 text-white';
        }

        return 'text-slate-300 hover:bg-white/10 hover:text-white';
    }
}

if (!function_exists('adminSubMenuClass')) {
    function adminSubMenuClass($controllerName, $actionName)
    {
        global $currentController, $currentAction;

        if ($currentController === $controllerName && $currentAction === $actionName) {
            return 'bg-gradient-to-r from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20';
        }

        return 'text-slate-400 hover:bg-white/10 hover:text-white';
    }
}

if (!function_exists('isOpenMenu')) {
    function isOpenMenu($controllerName)
    {
        global $currentController;

        return $currentController === $controllerName;
    }
}
?>

<aside class="w-72 sm:w-80 lg:w-72 h-screen bg-slate-950 text-white flex flex-col shrink-0 border-r border-slate-900">
    <!-- Logo -->
    <div class="px-4 sm:px-5 py-5 border-b border-white/10">
        <a href="index.php?area=admin&controller=dashboard&action=index" class="flex items-center gap-3 min-w-0">
            <div
                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-400 to-lime-500 flex items-center justify-center text-2xl shadow-lg overflow-hidden shrink-0">
                <?php if (!empty($adminLogo)): ?>
                    <img src="<?= htmlspecialchars($adminLogo) ?>" class="w-full h-full object-cover" alt="Logo">
                <?php else: ?>
                    🍊
                <?php endif; ?>
            </div>

            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold tracking-tight leading-tight truncate">
                    <?= htmlspecialchars($adminSiteName) ?>
                </h1>

                <p class="text-sm text-slate-400 mt-1 truncate">
                    Quản trị website
                </p>
            </div>
        </a>
    </div>

    <!-- Menu -->
    <div class="flex-1 overflow-y-auto px-4 py-5">
        <div class="space-y-7">
            <!-- Dashboard -->
            <div>
                <p class="px-3 mb-3 text-xs uppercase tracking-[0.22em] text-slate-500 font-semibold">
                    Tổng quan
                </p>

                <a href="index.php?area=admin&controller=dashboard&action=index"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminSubMenuClass('dashboard', 'index') ?>">
                    <span class="text-lg shrink-0">📊</span>
                    <span class="font-semibold truncate">Dashboard</span>
                </a>
            </div>

            <!-- Content -->
            <div>
                <p class="px-3 mb-3 text-xs uppercase tracking-[0.22em] text-slate-500 font-semibold">
                    Nội dung
                </p>

                <div class="space-y-2">
                    <!-- Category -->
                    <details class="group" <?= isOpenMenu('category') ? 'open' : '' ?>>
                        <summary
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer transition list-none <?= adminMenuClass('category') ?>">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="text-lg shrink-0">🗂️</span>
                                <span class="font-semibold truncate">Danh mục</span>
                            </span>

                            <span class="text-xs transition group-open:rotate-180 shrink-0">⌄</span>
                        </summary>

                        <div class="mt-2 ml-5 pl-4 border-l border-white/10 space-y-2">
                            <a href="index.php?area=admin&controller=category&action=index"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('category', 'index') ?>">
                                Danh sách danh mục
                            </a>

                            <a href="index.php?area=admin&controller=category&action=create"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('category', 'create') ?>">
                                Thêm danh mục
                            </a>
                        </div>
                    </details>

                    <!-- Product -->
                    <details class="group" <?= isOpenMenu('product') ? 'open' : '' ?>>
                        <summary
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer transition list-none <?= adminMenuClass('product') ?>">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="text-lg shrink-0">🍎</span>
                                <span class="font-semibold truncate">Sản phẩm</span>
                            </span>

                            <span class="text-xs transition group-open:rotate-180 shrink-0">⌄</span>
                        </summary>

                        <div class="mt-2 ml-5 pl-4 border-l border-white/10 space-y-2">
                            <a href="index.php?area=admin&controller=product&action=index"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('product', 'index') ?>">
                                Danh sách sản phẩm
                            </a>

                            <a href="index.php?area=admin&controller=product&action=create"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('product', 'create') ?>">
                                Thêm sản phẩm
                            </a>
                        </div>
                    </details>

                    <!-- Post -->
                    <details class="group" <?= isOpenMenu('post') ? 'open' : '' ?>>
                        <summary
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer transition list-none <?= adminMenuClass('post') ?>">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="text-lg shrink-0">📝</span>
                                <span class="font-semibold truncate">Bài viết</span>
                            </span>

                            <span class="text-xs transition group-open:rotate-180 shrink-0">⌄</span>
                        </summary>

                        <div class="mt-2 ml-5 pl-4 border-l border-white/10 space-y-2">
                            <a href="index.php?area=admin&controller=post&action=index"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('post', 'index') ?>">
                                Danh sách bài viết
                            </a>

                            <a href="index.php?area=admin&controller=post&action=create"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('post', 'create') ?>">
                                Thêm bài viết
                            </a>
                        </div>
                    </details>

                    <!-- Video -->
                    <details class="group" <?= isOpenMenu('video') ? 'open' : '' ?>>
                        <summary
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer transition list-none <?= adminMenuClass('video') ?>">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="text-lg shrink-0">🎬</span>
                                <span class="font-semibold truncate">Video</span>
                            </span>

                            <span class="text-xs transition group-open:rotate-180 shrink-0">⌄</span>
                        </summary>

                        <div class="mt-2 ml-5 pl-4 border-l border-white/10 space-y-2">
                            <a href="index.php?area=admin&controller=video&action=index"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('video', 'index') ?>">
                                Danh sách video
                            </a>

                            <a href="index.php?area=admin&controller=video&action=create"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('video', 'create') ?>">
                                Thêm video
                            </a>
                        </div>
                    </details>
                </div>
            </div>

            <!-- Sales -->
            <div>
                <p class="px-3 mb-3 text-xs uppercase tracking-[0.22em] text-slate-500 font-semibold">
                    Bán hàng
                </p>

                <div class="space-y-2">
                    <details class="group" <?= isOpenMenu('order') ? 'open' : '' ?>>
                        <summary
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer transition list-none <?= adminMenuClass('order') ?>">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="text-lg shrink-0">🧾</span>
                                <span class="font-semibold truncate">Đơn hàng</span>
                            </span>

                            <span class="text-xs transition group-open:rotate-180 shrink-0">⌄</span>
                        </summary>

                        <div class="mt-2 ml-5 pl-4 border-l border-white/10 space-y-2">
                            <a href="index.php?area=admin&controller=order&action=index"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('order', 'index') ?>">
                                Danh sách đơn hàng
                            </a>

                        </div>
                    </details>
                </div>
            </div>

            <!-- System -->
            <div>
                <p class="px-3 mb-3 text-xs uppercase tracking-[0.22em] text-slate-500 font-semibold">
                    Hệ thống
                </p>

                <div class="space-y-2">
                    <details class="group" <?= isOpenMenu('user') ? 'open' : '' ?>>
                        <summary
                            class="flex items-center justify-between gap-3 px-4 py-3 rounded-2xl cursor-pointer transition list-none <?= adminMenuClass('user') ?>">
                            <span class="flex items-center gap-3 min-w-0">
                                <span class="text-lg shrink-0">👥</span>
                                <span class="font-semibold truncate">Người dùng</span>
                            </span>

                            <span class="text-xs transition group-open:rotate-180 shrink-0">⌄</span>
                        </summary>

                        <div class="mt-2 ml-5 pl-4 border-l border-white/10 space-y-2">
                            <a href="index.php?area=admin&controller=user&action=index"
                                class="block px-4 py-2.5 rounded-xl text-sm font-semibold transition <?= adminSubMenuClass('user', 'index') ?>">
                                Danh sách người dùng
                            </a>
                        </div>
                    </details>

                    <a href="index.php?area=admin&controller=setting&action=index"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminSubMenuClass('setting', 'index') ?>">
                        <span class="text-lg shrink-0">⚙️</span>
                        <span class="font-semibold truncate">Cài đặt website</span>
                    </a>

                    <a href="index.php?area=admin&controller=log&action=index"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminSubMenuClass('log', 'index') ?>">
                        <span class="text-lg shrink-0">📜</span>
                        <span class="font-semibold truncate">Logs</span>
                    </a>

                    <a href="index.php?area=admin&controller=contact&action=index"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminSubMenuClass('contact', 'index') ?>">
                        <span class="text-lg shrink-0">📩</span>
                        <span class="font-semibold truncate">Liên hệ</span>
                    </a>

                    <a href="index.php?area=admin&controller=payment&action=index"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminSubMenuClass('payment', 'index') ?>">
                        <span class="text-lg shrink-0">💳</span>
                        <span class="font-semibold truncate">Thanh toán</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom client shortcut -->
    <div class="p-4 border-t border-white/10">
        <div class="rounded-3xl bg-white/5 p-4 border border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-green-500/20 flex items-center justify-center shrink-0">
                    🌐
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-bold truncate">Về trang chủ</p>
                    <p class="text-xs text-slate-400 truncate">Kiểm tra giao diện client</p>
                </div>
            </div>

            <a href="index.php?area=client&controller=pages&action=home"
                class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white w-full mt-4 rounded-2xl">
                Mở website
            </a>
        </div>
    </div>
</aside>