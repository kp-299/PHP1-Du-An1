<?php
require_once __DIR__ . '/../../helpers/auth.php';

$settings = $settings ?? [];

$siteName = $settings['site_name'] ?? 'Fresh Fruit Store';
$logo = $settings['logo'] ?? '';

$cartTotalQuantity = $cartTotalQuantity ?? 0;
$user = currentUser();

$currentController = $_GET['controller'] ?? 'pages';
$currentAction = $_GET['action'] ?? 'home';

if (!function_exists('clientNavClass')) {
    function clientNavClass($controller, $action = null)
    {
        global $currentController, $currentAction;

        $active = $currentController === $controller;

        if ($action !== null) {
            $active = $active && $currentAction === $action;
        }

        return $active
            ? 'bg-green-700 text-white'
            : 'text-slate-700 hover:bg-green-50 hover:text-green-700';
    }
}

$userName = $user['name'] ?? 'User';
$userInitial = strtoupper(mb_substr($userName, 0, 1));
?>

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200">
    <div class="client-shell">
        <div class="h-20 flex items-center justify-between gap-4">
            <!-- Logo -->
            <a href="index.php?area=client&controller=pages&action=home" class="flex items-center gap-3 shrink-0"
                title="<?= htmlspecialchars($siteName) ?>">
                <?php if (!empty($logo)): ?>
                    <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($siteName) ?>"
                        class="w-12 h-12 rounded-2xl object-cover border border-slate-200 bg-white shadow-sm">
                <?php else: ?>
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-600 to-lime-400 flex items-center justify-center text-2xl shadow-sm">
                        🍊
                    </div>
                <?php endif; ?>

                <span class="hidden xl:block font-extrabold text-slate-950 tracking-tight">
                    <?= htmlspecialchars($siteName) ?>
                </span>
            </a>

            <!-- Desktop nav -->
            <nav
                class="hidden lg:flex items-center justify-center gap-1 bg-slate-100/80 rounded-full p-1 border border-slate-200">
                <a href="index.php?area=client&controller=pages&action=home"
                    class="px-4 py-2 rounded-full text-sm font-extrabold transition <?= clientNavClass('pages', 'home') ?>">
                    Trang chủ
                </a>

                <a href="index.php?area=client&controller=product&action=index"
                    class="px-4 py-2 rounded-full text-sm font-extrabold transition <?= clientNavClass('product') ?>">
                    Sản phẩm
                </a>

                <a href="index.php?area=client&controller=post&action=index"
                    class="px-4 py-2 rounded-full text-sm font-extrabold transition <?= clientNavClass('post') ?>">
                    Bài viết
                </a>

                <a href="index.php?area=client&controller=video&action=index"
                    class="px-4 py-2 rounded-full text-sm font-extrabold transition <?= clientNavClass('video') ?>">
                    Video
                </a>

                <a href="index.php?area=client&controller=pages&action=contact"
                    class="px-4 py-2 rounded-full text-sm font-extrabold transition <?= clientNavClass('pages', 'contact') ?>">
                    Liên hệ
                </a>
            </nav>

            <!-- Desktop actions -->
            <div class="hidden lg:flex items-center gap-2 shrink-0">
                <?php if ($user): ?>
                    <a href="index.php?area=client&controller=cart&action=index"
                        class="h-11 px-4 rounded-full bg-white border border-slate-300 hover:border-green-600 hover:bg-green-50 text-slate-900 inline-flex items-center gap-2 font-extrabold transition">
                        <span>🛒</span>
                        <span>Giỏ hàng</span>
                        <span
                            class="min-w-6 h-6 px-2 rounded-full bg-green-600 text-white text-xs flex items-center justify-center">
                            <?= htmlspecialchars($cartTotalQuantity) ?>
                        </span>
                    </a>

                    <a href="index.php?area=client&controller=user&action=profile&tab=overview"
                        class="h-11 px-4 rounded-full bg-slate-100 hover:bg-green-50 text-slate-900 inline-flex items-center gap-2 font-extrabold transition">
                        <span class="w-7 h-7 rounded-full bg-green-600 text-white flex items-center justify-center text-xs">
                            <?= htmlspecialchars($userInitial) ?>
                        </span>
                        <span>Tài khoản</span>
                    </a>

                    <?php if (isAdmin()): ?>
                        <a href="index.php?area=admin&controller=dashboard&action=index"
                            class="h-11 px-4 rounded-full bg-amber-400 hover:bg-amber-500 text-slate-950 inline-flex items-center justify-center font-extrabold transition">
                            Admin
                        </a>
                    <?php endif; ?>

                    <a href="index.php?area=client&controller=auth&action=logout"
                        class="h-11 px-4 rounded-full bg-slate-950 hover:bg-slate-800 text-white inline-flex items-center justify-center font-extrabold transition">
                        Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="index.php?area=client&controller=auth&action=login"
                        class="h-11 px-5 rounded-full bg-slate-950 hover:bg-slate-800 text-white inline-flex items-center justify-center font-extrabold transition">
                        Đăng nhập
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu -->
            <div class="dropdown dropdown-end lg:hidden">
                <div tabindex="0" role="button"
                    class="w-11 h-11 rounded-full bg-slate-100 border border-slate-200 text-slate-900 flex items-center justify-center font-extrabold">
                    ☰
                </div>

                <ul tabindex="0"
                    class="dropdown-content menu bg-white rounded-3xl z-[60] w-72 p-3 shadow-xl border border-slate-200 mt-3">
                    <li>
                        <a href="index.php?area=client&controller=pages&action=home"
                            class="rounded-2xl <?= ($currentController === 'pages' && $currentAction === 'home') ? 'bg-green-50 text-green-700 font-bold' : '' ?>">
                            Trang chủ
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=client&controller=product&action=index"
                            class="rounded-2xl <?= $currentController === 'product' ? 'bg-green-50 text-green-700 font-bold' : '' ?>">
                            Sản phẩm
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=client&controller=post&action=index"
                            class="rounded-2xl <?= $currentController === 'post' ? 'bg-green-50 text-green-700 font-bold' : '' ?>">
                            Bài viết
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=client&controller=video&action=index"
                            class="rounded-2xl <?= $currentController === 'video' ? 'bg-green-50 text-green-700 font-bold' : '' ?>">
                            Video
                        </a>
                    </li>

                    <li>
                        <a href="index.php?area=client&controller=pages&action=contact"
                            class="rounded-2xl <?= ($currentController === 'pages' && $currentAction === 'contact') ? 'bg-green-50 text-green-700 font-bold' : '' ?>">
                            Liên hệ
                        </a>
                    </li>

                    <div class="divider my-1"></div>

                    <?php if ($user): ?>
                        <li class="menu-title">
                            <span>
                                Xin chào, <?= htmlspecialchars($userName) ?>
                            </span>
                        </li>

                        <li>
                            <a class="rounded-2xl" href="index.php?area=client&controller=cart&action=index">
                                🛒 Giỏ hàng
                                <span class="badge bg-green-600 text-white border-0">
                                    <?= htmlspecialchars($cartTotalQuantity) ?>
                                </span>
                            </a>
                        </li>

                        <li>
                            <a class="rounded-2xl" href="index.php?area=client&controller=user&action=profile&tab=overview">
                                👤 User Dashboard
                            </a>
                        </li>

                        <li>
                            <a class="rounded-2xl"
                                href="index.php?area=client&controller=user&action=profile&tab=current_orders">
                                📦 Đơn hiện tại
                            </a>
                        </li>

                        <li>
                            <a class="rounded-2xl" href="index.php?area=client&controller=user&action=profile&tab=orders">
                                🧾 Lịch sử đơn hàng
                            </a>
                        </li>

                        <?php if (isAdmin()): ?>
                            <li>
                                <a class="rounded-2xl" href="index.php?area=admin&controller=dashboard&action=index">
                                    ⚙️ Admin Dashboard
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a class="rounded-2xl text-rose-600" href="index.php?area=client&controller=auth&action=logout">
                                🚪 Đăng xuất
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="rounded-2xl" href="index.php?area=client&controller=auth&action=login">
                                Đăng nhập
                            </a>
                        </li>

                        <li>
                            <a class="rounded-2xl" href="index.php?area=client&controller=auth&action=register">
                                Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</header>