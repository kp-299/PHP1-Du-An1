<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
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
                        <p class="text-sm text-slate-500">Tạo tài khoản mới</p>
                    </div>
                </a>
            </div>

            <div class="card bg-white border border-slate-200 shadow-sm rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h1 class="text-3xl font-extrabold text-slate-950">Đăng ký</h1>
                        <p class="text-slate-500 mt-2">
                            Tạo tài khoản để mua hàng và theo dõi đơn hàng.
                        </p>
                    </div>

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
                                <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['name']) ?></p>
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
                                <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['email']) ?></p>
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
                                <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['password']) ?></p>
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
                                <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['confirm_password']) ?></p>
                            <?php endif; ?>
                        </div>

                        <button type="submit"
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl w-full">
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
                <a href="index.php?area=client&controller=pages&action=home" class="font-bold text-green-600">
                    ← Về trang chủ
                </a>
            </p>
        </div>
    </div>

    <div
        class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-green-500 via-lime-500 to-yellow-400 p-12 items-center">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-20 right-16 text-8xl">🍓</div>
            <div class="absolute bottom-24 left-20 text-8xl">🥭</div>
            <div class="absolute top-1/2 left-1/3 text-7xl">🍍</div>
        </div>

        <div class="relative text-white max-w-xl">
            <div class="w-16 h-16 rounded-3xl bg-white/20 flex items-center justify-center text-4xl mb-8">
                🍏
            </div>

            <h1 class="text-5xl font-extrabold leading-tight">
                Tạo tài khoản và mua trái cây tươi ngay hôm nay
            </h1>

            <p class="text-white/90 text-lg leading-8 mt-6">
                Tài khoản thường chỉ dùng cho client. Muốn vào admin dashboard thì bạn set role = admin trực tiếp trong
                database.
            </p>
        </div>
    </div>
</div>