<?php
$settings = $settings ?? [];

$siteName = $settings['site_name'] ?? 'Fresh Fruit Store';
$siteSubtitle = $settings['site_subtitle'] ?? 'Fresh Fruit Store';
$logo = $settings['logo'] ?? '';

$registerTitle = $settings['auth_register_title'] ?? 'Tạo tài khoản mới';
$registerSubtitle = $settings['auth_register_subtitle'] ?? 'Tạo tài khoản để mua hàng, theo dõi đơn hàng và nhận ưu đãi mới nhất từ cửa hàng.';
$registerImage = $settings['auth_register_image'] ?? '';
?>

<div class="min-h-screen bg-slate-50 grid grid-cols-1 lg:grid-cols-2">
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
                            Đăng ký
                        </h1>

                        <p class="text-slate-500 mt-2">
                            Tạo tài khoản để mua hàng và theo dõi đơn hàng.
                        </p>
                    </div>

                    <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-error">
                        <span><?= htmlspecialchars($errors['general']) ?></span>
                    </div>
                    <?php endif; ?>

                    <form action="index.php?area=client&controller=auth&action=handleRegister" method="POST"
                        class="space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Họ tên
                            </label>

                            <input type="text" name="name" autocomplete="name"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                                placeholder="Nguyễn Văn A" value="<?= htmlspecialchars($old['name'] ?? '') ?>">

                            <?php if (!empty($errors['name'])): ?>
                            <p class="text-error text-sm mt-2">
                                <?= htmlspecialchars($errors['name']) ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Email
                            </label>

                            <input type="email" name="email" autocomplete="email"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['email']) ? 'input-error' : '' ?>"
                                placeholder="user@gmail.com" value="<?= htmlspecialchars($old['email'] ?? '') ?>">

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

                            <input type="password" name="password" autocomplete="new-password"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['password']) ? 'input-error' : '' ?>"
                                placeholder="Tối thiểu 6 ký tự">

                            <?php if (!empty($errors['password'])): ?>
                            <p class="text-error text-sm mt-2">
                                <?= htmlspecialchars($errors['password']) ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Nhập lại mật khẩu
                            </label>

                            <input type="password" name="confirm_password" autocomplete="new-password"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['confirm_password']) ? 'input-error' : '' ?>"
                                placeholder="Nhập lại mật khẩu">

                            <?php if (!empty($errors['confirm_password'])): ?>
                            <p class="text-error text-sm mt-2">
                                <?= htmlspecialchars($errors['confirm_password']) ?>
                            </p>
                            <?php endif; ?>
                        </div>

                        <button type="submit"
                            class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                            Đăng ký
                        </button>
                    </form>

                    <div class="divider">đã có tài khoản?</div>

                    <a href="index.php?area=client&controller=auth&action=login"
                        class="btn btn-outline rounded-2xl w-full">
                        Đăng nhập
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

    <div class="hidden lg:flex relative overflow-hidden bg-slate-900 items-center justify-center p-10">
        <?php if (!empty($registerImage)): ?>
        <img src="<?= htmlspecialchars($registerImage) ?>" alt="Register image"
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
                <?= htmlspecialchars($registerTitle) ?>
            </h1>

            <p class="text-white/85 text-lg leading-8 mt-6">
                <?= htmlspecialchars($registerSubtitle) ?>
            </p>

            <div class="grid grid-cols-2 gap-4 mt-10">
                <div class="rounded-3xl bg-white/10 backdrop-blur p-5 border border-white/10">
                    <p class="text-2xl font-extrabold">Easy</p>
                    <p class="text-sm text-white/70 mt-1">Đăng ký nhanh</p>
                </div>

                <div class="rounded-3xl bg-white/10 backdrop-blur p-5 border border-white/10">
                    <p class="text-2xl font-extrabold">Order</p>
                    <p class="text-sm text-white/70 mt-1">Theo dõi đơn</p>
                </div>
            </div>
        </div>
    </div>
</div>