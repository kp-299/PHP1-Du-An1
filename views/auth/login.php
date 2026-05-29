<?php
$user = currentUser();

$settings = $settings ?? [];

$siteName = $settings['site_name'] ?? 'Fresh Fruit Store';
$siteSubtitle = $settings['site_subtitle'] ?? 'Fresh Fruit Store';
$logo = $settings['logo'] ?? '';

$loginTitle = $settings['auth_login_title'] ?? 'Chào mừng quay lại';
$loginSubtitle = $settings['auth_login_subtitle'] ?? 'Đăng nhập để mua hàng, theo dõi đơn hàng hoặc truy cập admin dashboard nếu tài khoản của bạn có quyền quản trị.';
$loginImage = $settings['auth_login_image'] ?? '';
?>

<div class="min-h-screen bg-slate-50 grid grid-cols-1 lg:grid-cols-2">
    <div class="hidden lg:flex relative overflow-hidden bg-slate-900 items-center justify-center p-10">
        <?php if (!empty($loginImage)): ?>
            <img src="<?= htmlspecialchars($loginImage) ?>" alt="Login image"
                class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-950/45"></div>
        <?php else: ?>
            <div class="absolute inset-0 site-gradient-bg"></div>
            <div class="absolute inset-0 bg-slate-950/10"></div>
        <?php endif; ?>

        <div class="relative z-10 max-w-xl text-white">
            <div
                class="w-16 h-16 rounded-3xl bg-white/15 backdrop-blur flex items-center justify-center overflow-hidden mb-8">
                <?php if (!empty($logo)): ?>
                    <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($siteName) ?>"
                        class="w-full h-full object-cover">
                <?php else: ?>
                    <span class="text-2xl font-black">
                        <?= htmlspecialchars(mb_substr($siteName, 0, 1)) ?>
                    </span>
                <?php endif; ?>
            </div>

            <h1 class="text-5xl font-extrabold leading-tight">
                <?= htmlspecialchars($loginTitle) ?>
            </h1>

            <p class="text-white/85 text-lg leading-8 mt-6">
                <?= htmlspecialchars($loginSubtitle) ?>
            </p>

            <div class="grid grid-cols-3 gap-4 mt-10">
                <div class="rounded-3xl bg-white/10 backdrop-blur p-5 border border-white/10">
                    <p class="text-2xl font-extrabold">Fresh</p>
                    <p class="text-sm text-white/70 mt-1">Sản phẩm tươi</p>
                </div>

                <div class="rounded-3xl bg-white/10 backdrop-blur p-5 border border-white/10">
                    <p class="text-2xl font-extrabold">Fast</p>
                    <p class="text-sm text-white/70 mt-1">Giao nhanh</p>
                </div>

                <div class="rounded-3xl bg-white/10 backdrop-blur p-5 border border-white/10">
                    <p class="text-2xl font-extrabold">Safe</p>
                    <p class="text-sm text-white/70 mt-1">An toàn</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center px-4 py-10 sm:py-12">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <a href="index.php?area=client&controller=pages&action=home" class="inline-flex items-center gap-3">
                    <?php if (!empty($logo)): ?>
                        <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($siteName) ?>"
                            class="w-12 h-12 rounded-2xl object-cover border border-slate-200 bg-white">
                    <?php else: ?>
                        <div
                            class="w-12 h-12 rounded-2xl site-gradient-bg flex items-center justify-center text-white font-black text-xl">
                            <?= htmlspecialchars(mb_substr($siteName, 0, 1)) ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            <?= htmlspecialchars($siteName) ?>
                        </h2>
                        <p class="text-sm text-slate-500">
                            <?= htmlspecialchars($siteSubtitle) ?>
                        </p>
                    </div>
                </a>
            </div>

            <div class="card bg-white border border-slate-200 shadow-sm rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-950">
                            Đăng nhập
                        </h1>

                        <p class="text-slate-500 mt-2">
                            Nhập email và mật khẩu để tiếp tục.
                        </p>
                    </div>

                    <?php if (!empty($_SESSION['flash'])): ?>
                        <div
                            class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?>">
                            <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
                        </div>
                        <?php unset($_SESSION['flash']); ?>
                    <?php endif; ?>

                    <?php if (!empty($errors['general'])): ?>
                        <div class="alert alert-error">
                            <span><?= htmlspecialchars($errors['general']) ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (isAdmin()): ?>
                        <a href="index.php?area=admin&controller=dashboard&action=index"
                            class="btn site-gradient-bg border-0 text-white rounded-2xl w-full">
                            Vào Admin Dashboard
                        </a>
                    <?php endif; ?>

                    <form action="index.php?area=client&controller=auth&action=handleLogin" method="POST"
                        class="space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Email
                            </label>

                            <input type="email" name="email" autocomplete="email"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['email']) ? 'input-error' : '' ?>"
                                placeholder="admin@gmail.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>">

                            <?php if (!empty($errors['email'])): ?>
                                <p class="text-error text-sm mt-2">
                                    <?= htmlspecialchars($errors['email']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Mật khẩu
                            </label>

                            <input type="password" name="password" autocomplete="current-password"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['password']) ? 'input-error' : '' ?>"
                                placeholder="••••••••">

                            <?php if (!empty($errors['password'])): ?>
                                <p class="text-error text-sm mt-2">
                                    <?= htmlspecialchars($errors['password']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <button type="submit"
                            class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                            Đăng nhập
                        </button>
                    </form>

                    <div class="divider">hoặc</div>

                    <a href="index.php?area=client&controller=auth&action=register"
                        class="btn btn-outline rounded-2xl w-full">
                        Tạo tài khoản mới
                    </a>
                </div>
            </div>

            <p class="text-center text-sm text-slate-500 mt-6">
                <a href="index.php?area=client&controller=pages&action=home" class="font-bold site-primary-text">
                    ← Về trang chủ
                </a>
            </p>
        </div>
    </div>
</div>