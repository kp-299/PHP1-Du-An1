<?php
$currentController = $_GET['controller'] ?? 'dashboard';

function adminMenuClass($controllerName)
{
    global $currentController;

    if ($currentController === $controllerName) {
        return 'bg-gradient-to-r from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20';
    }

    return 'text-slate-300 hover:bg-white/10 hover:text-white';
}
?>

<aside class="w-72 h-screen bg-slate-950 text-white flex flex-col shrink-0 border-r border-slate-900">
    <div class="px-6 py-6 border-b border-white/10">
        <a href="index.php?area=admin&controller=dashboard&action=index" class="flex items-center gap-3">
            <div
                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-400 to-lime-500 flex items-center justify-center text-2xl shadow-lg">
                🍊
            </div>

            <div>
                <h1 class="text-2xl font-extrabold tracking-tight leading-tight">
                    Fruit Admin
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Quản trị bán trái cây
                </p>
            </div>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto px-4 py-5">
        <div class="space-y-6">
            <div>
                <p class="px-3 mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-semibold">
                    Quản lý chính
                </p>

                <ul class="space-y-2">
                    <li>
                        <a href="index.php?area=admin&controller=dashboard&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('dashboard') ?>">
                            <span class="text-lg">📊</span>
                            <span class="font-semibold">Tổng quan</span>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=admin&controller=category&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('category') ?>">
                            <span class="text-lg">🗂️</span>
                            <span class="font-semibold">Danh mục</span>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=admin&controller=product&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('product') ?>">
                            <span class="text-lg">🍎</span>
                            <span class="font-semibold">Sản phẩm</span>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=admin&controller=order&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('order') ?>">
                            <span class="text-lg">🧾</span>
                            <span class="font-semibold">Đơn hàng</span>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=admin&controller=user&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('user') ?>">
                            <span class="text-lg">👥</span>
                            <span class="font-semibold">Người dùng</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="px-3 mb-3 text-xs uppercase tracking-[0.2em] text-slate-500 font-semibold">
                    Hệ thống
                </p>

                <ul class="space-y-2">
                    <li>
                        <a href="index.php?area=admin&controller=setting&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('setting') ?>">
                            <span class="text-lg">⚙️</span>
                            <span class="font-semibold">Cài đặt website</span>
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=admin&controller=log&action=index"
                            class="flex items-center gap-3 px-4 py-3 rounded-2xl transition <?= adminMenuClass('log') ?>">
                            <span class="text-lg">📜</span>
                            <span class="font-semibold">Logs</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="p-4 border-t border-white/10">
        <div class="rounded-3xl bg-white/5 p-4 border border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-green-500/20 flex items-center justify-center">
                    🌐
                </div>

                <div>
                    <p class="text-sm font-bold">Về trang chủ</p>
                    <p class="text-xs text-slate-400">Kiểm tra giao diện client</p>
                </div>
            </div>

            <a href="index.php?area=client&controller=pages&action=home"
                class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white w-full mt-4 rounded-2xl">
                Mở website
            </a>
        </div>
    </div>
</aside>