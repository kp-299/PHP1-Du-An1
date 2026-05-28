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
    'user' => 'Người dùng',
    'post' => 'Bài viết',
    'video' => 'Video',
    'setting' => 'Cài đặt website',
    'log' => 'Logs',
];

$pageTitle = $pageMap[$currentController] ?? 'Dashboard';
?>

<header
    class="h-20 shrink-0 bg-white/90 backdrop-blur border-b border-slate-200 px-5 lg:px-8 flex items-center justify-between">
    <div>
        <p class="text-sm text-slate-500">
            Admin Dashboard
        </p>

        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
            <?= htmlspecialchars($pageTitle) ?>
        </h2>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden md:flex items-center gap-3 bg-slate-100 rounded-3xl px-4 py-2 border border-slate-200">
            <div
                class="w-11 h-11 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 text-white flex items-center justify-center font-bold shadow-md">
                <?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?>
            </div>

            <div class="text-right leading-tight">
                <p class="text-xs text-slate-500">Xin chào,</p>
                <p class="font-bold text-slate-800">
                    <?= htmlspecialchars($user['name'] ?? 'Admin') ?>
                </p>
            </div>
        </div>

        <a href="index.php?area=client&controller=auth&action=logout"
            class="btn btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-2xl">
            Đăng xuất
        </a>
    </div>
</header>