<?php
function logPageUrl($filters, $page)
{
    return 'index.php?' . http_build_query([
        'area' => 'admin',
        'controller' => 'log',
        'action' => 'index',
        'log_action' => $filters['log_action'] ?? '',
        'user_id' => $filters['user_id'] ?? '',
        'method' => $filters['method'] ?? '',
        'date_from' => $filters['date_from'] ?? '',
        'date_to' => $filters['date_to'] ?? '',
        'page' => $page,
    ]);
}

function logMethodBadge($method)
{
    $method = strtoupper($method ?? '-');

    if ($method === 'POST') {
        return 'bg-emerald-100 text-emerald-700';
    }

    if ($method === 'GET') {
        return 'bg-sky-100 text-sky-700';
    }

    return 'bg-slate-100 text-slate-700';
}
?>

<div class="space-y-6">
    <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Admin Dashboard</p>

            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Logs hệ thống') ?>
            </h1>

            <p class="text-slate-500 mt-2 max-w-3xl">
                Theo dõi hoạt động đăng nhập, đăng xuất, tạo/sửa dữ liệu trong hệ thống.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:flex gap-3">
            <a href="index.php?area=admin&controller=log&action=clearOld&days=30"
                class="btn btn-sm sm:btn-md bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-2xl"
                onclick="return confirm('Bạn muốn xóa logs cũ hơn 30 ngày?')">
                Xóa logs cũ
            </a>

            <a href="index.php?area=admin&controller=log&action=clear"
                class="btn btn-sm sm:btn-md bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-2xl"
                onclick="return confirm('Bạn chắc chắn muốn xóa toàn bộ logs?')">
                Xóa tất cả
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-slate-200 rounded-[2rem] p-4 sm:p-5">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-3">
            <input type="hidden" name="area" value="admin">
            <input type="hidden" name="controller" value="log">
            <input type="hidden" name="action" value="index">

            <div class="xl:col-span-3">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Action</label>
                <input type="text" name="log_action" placeholder="login, create_product..."
                    class="input input-bordered rounded-2xl w-full"
                    value="<?= htmlspecialchars($filters['log_action'] ?? '') ?>">
            </div>

            <div class="xl:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1">User ID</label>
                <input type="number" name="user_id" placeholder="User ID"
                    class="input input-bordered rounded-2xl w-full"
                    value="<?= htmlspecialchars($filters['user_id'] ?? '') ?>">
            </div>

            <div class="xl:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Method</label>
                <select name="method" class="select select-bordered rounded-2xl w-full">
                    <option value="">Tất cả method</option>
                    <option value="GET" <?= ($filters['method'] ?? '') === 'GET' ? 'selected' : '' ?>>GET</option>
                    <option value="POST" <?= ($filters['method'] ?? '') === 'POST' ? 'selected' : '' ?>>POST</option>
                </select>
            </div>

            <div class="xl:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Từ ngày</label>
                <input type="date" name="date_from" class="input input-bordered rounded-2xl w-full"
                    value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
            </div>

            <div class="xl:col-span-2">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Đến ngày</label>
                <input type="date" name="date_to" class="input input-bordered rounded-2xl w-full"
                    value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
            </div>

            <div class="xl:col-span-1 flex md:items-end">
                <button type="submit"
                    class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                    Lọc
                </button>
            </div>

            <div class="xl:col-span-12">
                <a href="index.php?area=admin&controller=log&action=index" class="btn btn-sm btn-outline rounded-2xl">
                    Reset bộ lọc
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-sm border border-slate-200 rounded-[2rem] overflow-hidden">
        <div
            class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">
                    Danh sách logs
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Các hoạt động được ghi nhận trong hệ thống.
                </p>
            </div>

            <span class="w-fit px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                <?= htmlspecialchars($totalLogs ?? count($logs ?? [])) ?> logs
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra min-w-[1100px]">
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
                            <tr>
                                <td class="font-bold">
                                    #<?= htmlspecialchars($log['id']) ?>
                                </td>

                                <td>
                                    <?php if (!empty($log['user_name'])): ?>
                                        <div class="font-bold">
                                            <?= htmlspecialchars($log['user_name']) ?>
                                        </div>

                                        <div class="text-xs text-slate-500 max-w-40 truncate">
                                            <?= htmlspecialchars($log['user_email'] ?? '') ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                            Guest/System
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">
                                        <?= htmlspecialchars($log['action'] ?? '-') ?>
                                    </span>
                                </td>

                                <td class="text-sm text-slate-600">
                                    <?= htmlspecialchars($log['ip_address'] ?? '-') ?>
                                </td>

                                <td>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold <?= logMethodBadge($log['method'] ?? '-') ?>">
                                        <?= htmlspecialchars($log['method'] ?? '-') ?>
                                    </span>
                                </td>

                                <td class="max-w-xs">
                                    <p class="truncate text-sm text-slate-600"
                                        title="<?= htmlspecialchars($log['url'] ?? '-') ?>">
                                        <?= htmlspecialchars($log['url'] ?? '-') ?>
                                    </p>
                                </td>

                                <td class="max-w-sm">
                                    <p class="truncate text-xs text-slate-500"
                                        title="<?= htmlspecialchars($log['browser'] ?? '-') ?>">
                                        <?= htmlspecialchars($log['browser'] ?? '-') ?>
                                    </p>
                                </td>

                                <td class="text-sm text-slate-500 whitespace-nowrap">
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

                                    <p class="font-bold mt-4">
                                        Chưa có log nào
                                    </p>

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

        <?php if (($totalPages ?? 1) > 1): ?>
            <div class="p-5 border-t border-slate-100 flex justify-center overflow-x-auto">
                <div class="join">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?= logPageUrl($filters ?? [], $i) ?>"
                            class="join-item btn <?= (int)($page ?? 1) === $i ? 'bg-slate-900 text-white border-slate-900' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>