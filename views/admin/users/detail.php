<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Chi tiết người dùng') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Xem và cập nhật role, trạng thái tài khoản.
            </p>
        </div>

        <a href="index.php?area=admin&controller=user&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl 2xl:col-span-2">
            <div class="card-body space-y-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-20 h-20 rounded-3xl bg-gradient-to-br from-green-500 to-lime-500 text-white flex items-center justify-center text-3xl font-extrabold shadow-lg shadow-green-500/20">
                        <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                    </div>

                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">
                            <?= htmlspecialchars($user['name']) ?>
                        </h2>
                        <p class="text-slate-500">
                            <?= htmlspecialchars($user['email']) ?>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">ID</p>
                        <p class="font-bold mt-1">#<?= htmlspecialchars($user['id']) ?></p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">Email</p>
                        <p class="font-bold mt-1"><?= htmlspecialchars($user['email']) ?></p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">Số điện thoại</p>
                        <p class="font-bold mt-1"><?= htmlspecialchars($user['phone'] ?? '-') ?></p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">Role</p>
                        <p class="mt-2">
                            <?php if (($user['role'] ?? '') === 'admin'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">
                                    admin
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                    user
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">Trạng thái</p>
                        <p class="mt-2">
                            <?php if (($user['status'] ?? '') === 'active'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    active
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                    blocked
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">Ngày tạo</p>
                        <p class="font-bold mt-1"><?= htmlspecialchars($user['created_at'] ?? '') ?></p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5 md:col-span-2">
                        <p class="text-sm text-slate-500">Địa chỉ</p>
                        <p class="font-bold mt-1"><?= htmlspecialchars($user['address'] ?? '-') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Cập nhật trạng thái
                    </h3>

                    <form action="index.php?area=admin&controller=user&action=updateStatus" method="POST"
                        class="space-y-4">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                        <select name="status" class="select select-bordered rounded-2xl w-full">
                            <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="blocked" <?= $user['status'] === 'blocked' ? 'selected' : '' ?>>Blocked
                            </option>
                        </select>

                        <button type="submit"
                            class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Cập nhật role
                    </h3>

                    <form action="index.php?area=admin&controller=user&action=updateRole" method="POST"
                        class="space-y-4">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                        <select name="role" class="select select-bordered rounded-2xl w-full">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>

                        <button type="submit"
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl w-full">
                            Cập nhật role
                        </button>
                    </form>
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-violet-500 to-indigo-500 text-white shadow-lg shadow-violet-500/20 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-white/80">Tài khoản</p>
                    <h3 class="text-2xl font-extrabold">
                        <?= htmlspecialchars($user['role']) ?>
                    </h3>
                    <p class="text-sm text-white/80 mt-1">
                        <?= htmlspecialchars($user['status']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>