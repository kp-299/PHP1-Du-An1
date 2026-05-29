<?php
$user = $_SESSION['user'] ?? [
    'name' => 'Admin Test',
    'email' => 'admin@test.com',
    'role' => 'admin'
];

$currentController = $_GET['controller'] ?? 'dashboard';

$pageMap = [
    'dashboard' => 'Tổng quan',
    'category' => 'Danh mục',
    'product' => 'Sản phẩm',
    'order' => 'Đơn hàng',
    'payment' => 'Thanh toán',
    'user' => 'Người dùng',
    'post' => 'Bài viết',
    'video' => 'Video',
    'setting' => 'Cài đặt website',
    'log' => 'Logs',
];

$pageTitle = $pageMap[$currentController] ?? 'Dashboard';

$adminName = $user['name'] ?? 'Admin';
$adminInitial = strtoupper(mb_substr($adminName, 0, 1));
?>

<header class="shrink-0 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="h-16 sm:h-20 px-3 sm:px-5 lg:px-8 flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <!-- Mobile menu button -->
            <label for="admin-drawer" class="btn btn-square btn-sm sm:btn-md btn-ghost rounded-2xl lg:hidden shrink-0"
                aria-label="open sidebar">
                ☰
            </label>

            <div class="min-w-0">
                <p class="text-xs sm:text-sm text-slate-500 truncate">
                    Admin Dashboard
                </p>

                <h2 class="text-lg sm:text-2xl font-extrabold text-slate-800 tracking-tight truncate">
                    <?= htmlspecialchars($pageTitle) ?>
                </h2>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <div
                class="hidden sm:flex items-center gap-3 bg-slate-100 rounded-3xl px-3 sm:px-4 py-2 border border-slate-200">
                <div
                    class="w-9 h-9 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 text-white flex items-center justify-center font-bold shadow-md">
                    <?= htmlspecialchars($adminInitial) ?>
                </div>

                <div class="hidden md:block text-right leading-tight">
                    <p class="text-xs text-slate-500">Xin chào,</p>
                    <p class="font-bold text-slate-800 max-w-32 truncate">
                        <?= htmlspecialchars($adminName) ?>
                    </p>
                </div>
            </div>

            <a href="index.php?area=client&controller=auth&action=logout"
                class="btn btn-xs sm:btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-2xl">
                <span class="hidden sm:inline">Đăng xuất</span>
                <span class="sm:hidden">Thoát</span>
            </a>
        </div>
    </div>
</header>