<?php
require_once __DIR__ . '/../../helpers/auth.php';

$siteName = $settings['site_name'] ?? 'Fresh Fruit Store';
$logo = $settings['logo'] ?? '';
$cartTotalQuantity = $cartTotalQuantity ?? 0;
$user = currentUser();

$currentController = $_GET['controller'] ?? 'pages';
$currentAction = $_GET['action'] ?? 'home';

function clientNavClass($controller, $action = null)
{
    global $currentController, $currentAction;

    $active = $currentController === $controller;

    if ($action !== null) {
        $active = $active && $currentAction === $action;
    }

    return $active
        ? 'text-green-600'
        : 'hover:text-green-600 transition';
}
?>

<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-3 flex items-center justify-between gap-3">
        <a href="index.php?area=client&controller=pages&action=home" class="flex items-center gap-2 sm:gap-3 min-w-0">
            <?php if (!empty($logo)): ?>
                <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($siteName) ?>"
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl object-cover border border-slate-200 shrink-0">
            <?php else: ?>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 flex items-center justify-center text-xl sm:text-2xl shadow-lg shadow-green-500/20 shrink-0">
                    🍊
                </div>
            <?php endif; ?>

            <div class="min-w-0">
                <h1 class="text-sm sm:text-xl font-extrabold tracking-tight truncate max-w-[150px] sm:max-w-none">
                    <?= htmlspecialchars($siteName) ?>
                </h1>
                <p class="hidden sm:block text-sm text-slate-500">Fresh Fruit Store</p>
            </div>
        </a>

        <nav class="hidden lg:flex items-center gap-7 text-sm font-bold">
            <a href="index.php?area=client&controller=pages&action=home" class="<?= clientNavClass('pages', 'home') ?>">
                Trang chủ
            </a>

            <a href="index.php?area=client&controller=product&action=index" class="<?= clientNavClass('product') ?>">
                Sản phẩm
            </a>

            <a href="index.php?area=client&controller=post&action=index" class="<?= clientNavClass('post') ?>">
                Bài viết
            </a>

            <a href="index.php?area=client&controller=video&action=index" class="<?= clientNavClass('video') ?>">
                Video
            </a>

            <a href="index.php?area=client&controller=pages&action=contact"
                class="<?= clientNavClass('pages', 'contact') ?>">
                Liên hệ
            </a>
        </nav>

        <div class="flex items-center gap-2">
            <a href="index.php?area=client&controller=cart&action=index"
                class="btn btn-sm sm:btn-md btn-outline rounded-2xl min-h-0 h-10 sm:h-12">
                🛒
                <span class="hidden sm:inline">Giỏ hàng</span>
                <span class="badge bg-green-500 border-0 text-white">
                    <?= htmlspecialchars($cartTotalQuantity) ?>
                </span>
            </a>

            <div class="dropdown dropdown-end lg:hidden">
                <div tabindex="0" role="button" class="btn btn-sm btn-ghost rounded-2xl h-10">
                    ☰
                </div>

                <ul tabindex="0"
                    class="dropdown-content menu bg-white rounded-3xl z-[1] w-56 p-3 shadow-xl border border-slate-200 mt-3">
                    <li><a href="index.php?area=client&controller=pages&action=home">Trang chủ</a></li>
                    <li><a href="index.php?area=client&controller=product&action=index">Sản phẩm</a></li>
                    <li><a href="index.php?area=client&controller=post&action=index">Bài viết</a></li>
                    <li><a href="index.php?area=client&controller=video&action=index">Video</a></li>
                    <li><a href="index.php?area=client&controller=pages&action=contact">Liên hệ</a></li>

                    <div class="divider my-1"></div>

                    <?php if ($user): ?>
                        <?php if (isAdmin()): ?>
                            <li><a href="index.php?area=admin&controller=dashboard&action=index">Admin Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="index.php?area=client&controller=auth&action=logout">Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a href="index.php?area=client&controller=auth&action=login">Đăng nhập</a></li>
                        <li><a href="index.php?area=client&controller=auth&action=register">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="hidden lg:flex items-center gap-2">
                <?php if ($user): ?>
                    <?php if (isAdmin()): ?>
                        <a href="index.php?area=admin&controller=dashboard&action=index"
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl">
                            Admin Dashboard
                        </a>
                    <?php endif; ?>

                    <a href="index.php?area=client&controller=auth&action=logout"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                        Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="index.php?area=client&controller=auth&action=login"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                        Đăng nhập
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>