<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Logs hệ thống') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Theo dõi hoạt động đăng nhập, đăng xuất, tạo/sửa dữ liệu trong hệ thống.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="index.php?area=admin&controller=log&action=clearOld&days=30"
                class="btn bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-2xl"
                onclick="return confirm('Bạn muốn xóa logs cũ hơn 30 ngày?')">
                Xóa logs cũ
            </a>

            <a href="index.php?area=admin&controller=log&action=clear"
                class="btn bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-2xl"
                onclick="return confirm('Bạn chắc chắn muốn xóa toàn bộ logs?')">
                Xóa tất cả
            </a>
        </div>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="log">
                <input type="hidden" name="action" value="index">

                <div class="xl:col-span-3">
                    <input type="text" name="action" placeholder="Action: login, create_product..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['action'] ?? '') ?>">
                </div>

                <div class="xl:col-span-2">
                    <input type="number" name="user_id" placeholder="User ID"
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['user_id'] ?? '') ?>">
                </div>

                <div class="xl:col-span-2">
                    <input type="date" name="date_from" class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
                </div>

                <div class="xl:col-span-2">
                    <input type="date" name="date_to" class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
                </div>

                <div class="xl:col-span-2">
                    <button type="submit"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                        Lọc
                    </button>
                </div>

                <div class="xl:col-span-1">
                    <a href="index.php?area=admin&controller=log&action=index"
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
                        Danh sách logs
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Các hoạt động được ghi nhận trong hệ thống.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($logs) ? count($logs) : 0 ?> logs
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>IP</th>
                            <th>Method</th>
                            <th>URL</th>
                            <th>Browser</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $log): ?>
                                <tr class="hover">
                                    <td class="font-bold">#<?= htmlspecialchars($log['id']) ?></td>

                                    <td>
                                        <?php if (!empty($log['user_name'])): ?>
                                            <div class="font-bold"><?= htmlspecialchars($log['user_name']) ?></div>
                                            <div class="text-xs text-slate-500"><?= htmlspecialchars($log['user_email'] ?? '') ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                                Guest/System
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">
                                            <?= htmlspecialchars($log['action']) ?>
                                        </span>
                                    </td>

                                    <td><?= htmlspecialchars($log['ip_address'] ?? '-') ?></td>

                                    <td>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                            <?= htmlspecialchars($log['method'] ?? '-') ?>
                                        </span>
                                    </td>

                                    <td class="max-w-xs">
                                        <p class="truncate text-slate-600">
                                            <?= htmlspecialchars($log['url'] ?? '-') ?>
                                        </p>
                                    </td>

                                    <td class="max-w-sm">
                                        <p class="truncate text-xs text-slate-500">
                                            <?= htmlspecialchars($log['browser'] ?? '-') ?>
                                        </p>
                                    </td>

                                    <td class="text-slate-500">
                                        <?= htmlspecialchars($log['created_at'] ?? '') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="py-16 text-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-amber-50 flex items-center justify-center text-3xl mx-auto">
                                            📜
                                        </div>

                                        <p class="font-bold mt-4">Chưa có log nào</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Các hoạt động hệ thống sẽ xuất hiện ở đây.
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