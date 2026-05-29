<?php
$user = currentUser();
?>

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
    <div
        class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-green-500 via-lime-500 to-yellow-400 p-12 items-center">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 left-16 text-8xl">🍊</div>
            <div class="absolute bottom-24 right-20 text-8xl">🍎</div>
            <div class="absolute top-1/2 right-1/3 text-7xl">🍇</div>
        </div>

        <div class="relative text-white max-w-xl">
            <div class="w-16 h-16 rounded-3xl bg-white/20 flex items-center justify-center text-4xl mb-8">
                🍍
            </div>

            <h1 class="text-5xl font-extrabold leading-tight">
                Chào mừng quay lại Fruit Store
            </h1>

            <p class="text-white/90 text-lg leading-8 mt-6">
                Đăng nhập để mua hàng, theo dõi đơn hàng hoặc truy cập admin dashboard nếu tài khoản của bạn có quyền
                quản trị.
            </p>

            <div class="grid grid-cols-3 gap-4 mt-10">
                <div class="rounded-3xl bg-white/20 p-5">
                    <p class="text-3xl font-extrabold">Fresh</p>
                    <p class="text-sm text-white/80 mt-1">Sản phẩm tươi</p>
                </div>

                <div class="rounded-3xl bg-white/20 p-5">
                    <p class="text-3xl font-extrabold">Fast</p>
                    <p class="text-sm text-white/80 mt-1">Giao nhanh</p>
                </div>

                <div class="rounded-3xl bg-white/20 p-5">
                    <p class="text-3xl font-extrabold">Safe</p>
                    <p class="text-sm text-white/80 mt-1">An toàn</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-slate-50 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <div class="mb-8">
                <a href="index.php?area=client&controller=pages&action=home" class="inline-flex items-center gap-3">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 flex items-center justify-center text-2xl shadow-lg shadow-green-500/20">
                        🍊
                    </div>

                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-950">Fruit Store</h2>
                        <p class="text-sm text-slate-500">Đăng nhập tài khoản</p>
                    </div>
                </a>
            </div>

            <div class="card bg-white border border-slate-200 shadow-sm rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-950">Đăng nhập</h1>
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
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl w-full">
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
                <a href="index.php?area=client&controller=pages&action=home" class="font-bold text-green-600">
                    ← Về trang chủ
                </a>
            </p>
        </div>
    </div>
</div>