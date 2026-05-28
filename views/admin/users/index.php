<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            <?= htmlspecialchars($title ?? 'Quản lý người dùng') ?>
        </h1>
        <p class="text-slate-500 mt-2">
            Quản lý tài khoản user và admin trong hệ thống.
        </p>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="user">
                <input type="hidden" name="action" value="index">

                <div class="xl:col-span-5">
                    <input type="text" name="keyword" placeholder="Tìm name, email, phone..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                </div>

                <div class="xl:col-span-3">
                    <select name="role" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả role</option>
                        <option value="user" <?= ($filters['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= ($filters['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin
                        </option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active
                        </option>
                        <option value="blocked" <?= ($filters['status'] ?? '') === 'blocked' ? 'selected' : '' ?>>
                            Blocked</option>
                    </select>
                </div>

                <div class="xl:col-span-1">
                    <button type="submit"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                        Lọc
                    </button>
                </div>

                <div class="xl:col-span-1">
                    <a href="index.php?area=admin&controller=user&action=index"
                        class="btn btn-outline rounded-2xl w-full">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Danh sách người dùng
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Tài khoản khách hàng và quản trị viên.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($users) ? count($users) : 0 ?> người dùng
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>Người dùng</th>
                            <th>Liên hệ</th>
                            <th>Role</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr class="hover">
                                    <td class="font-bold">#<?= $user['id'] ?></td>

                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 text-white flex items-center justify-center font-bold shadow-md">
                                                <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                                            </div>

                                            <div>
                                                <div class="font-bold text-slate-900">
                                                    <?= htmlspecialchars($user['name']) ?>
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    <?= htmlspecialchars($user['email']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div><?= htmlspecialchars($user['phone'] ?? '-') ?></div>
                                        <div class="text-xs text-slate-500 max-w-xs truncate">
                                            <?= htmlspecialchars($user['address'] ?? '') ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if (($user['role'] ?? '') === 'admin'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">
                                                admin
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                                user
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if (($user['status'] ?? '') === 'active'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                active
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                                blocked
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-slate-500">
                                        <?= htmlspecialchars($user['created_at'] ?? '') ?>
                                    </td>

                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <a href="index.php?area=admin&controller=user&action=detail&id=<?= $user['id'] ?>"
                                                class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-xl">
                                                Chi tiết
                                            </a>

                                            <?php if (($user['status'] ?? '') === 'active'): ?>
                                                <a href="index.php?area=admin&controller=user&action=lock&id=<?= $user['id'] ?>"
                                                    class="btn btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-xl"
                                                    onclick="return confirm('Bạn muốn khóa user này?')">
                                                    Khóa
                                                </a>
                                            <?php else: ?>
                                                <a href="index.php?area=admin&controller=user&action=unlock&id=<?= $user['id'] ?>"
                                                    class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white rounded-xl"
                                                    onclick="return confirm('Bạn muốn mở khóa user này?')">
                                                    Mở
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">
                                    <div class="py-16 text-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-violet-50 flex items-center justify-center text-3xl mx-auto">
                                            👥
                                        </div>

                                        <p class="font-bold mt-4">Chưa có người dùng nào</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Khi có user đăng ký, dữ liệu sẽ hiển thị tại đây.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>