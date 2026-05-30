<?php
$messages = $messages ?? [];
$filters = $filters ?? [];

function contactStatusLabel($status)
{
    return match ($status) {
        'new' => 'Mới',
        'read' => 'Đã đọc',
        'replied' => 'Đã phản hồi',
        'archived' => 'Lưu trữ',
        default => 'Không rõ',
    };
}

function contactStatusClass($status)
{
    return match ($status) {
        'new' => 'bg-rose-100 text-rose-700',
        'read' => 'bg-sky-100 text-sky-700',
        'replied' => 'bg-emerald-100 text-emerald-700',
        'archived' => 'bg-slate-100 text-slate-700',
        default => 'bg-slate-100 text-slate-700',
    };
}

function contactPageUrl($filters, $page)
{
    return 'index.php?' . http_build_query([
        'area' => 'admin',
        'controller' => 'contact',
        'action' => 'index',
        'keyword' => $filters['keyword'] ?? '',
        'status' => $filters['status'] ?? '',
        'date_from' => $filters['date_from'] ?? '',
        'date_to' => $filters['date_to'] ?? '',
        'page' => $page,
    ]);
}
?>

<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Admin Dashboard</p>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
                Liên hệ từ khách hàng
            </h1>

            <p class="text-slate-500 mt-2">
                Quản lý các nội dung liên hệ được gửi từ trang client.
            </p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2rem] p-4 sm:p-5 shadow-sm">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-3">
            <input type="hidden" name="area" value="admin">
            <input type="hidden" name="controller" value="contact">
            <input type="hidden" name="action" value="index">

            <div class="xl:col-span-4">
                <input type="text" name="keyword" class="input input-bordered rounded-2xl w-full"
                    placeholder="Tìm tên, email, SĐT, nội dung..."
                    value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
            </div>

            <div class="xl:col-span-2">
                <select name="status" class="select select-bordered rounded-2xl w-full">
                    <option value="">Tất cả trạng thái</option>
                    <option value="new" <?= ($filters['status'] ?? '') === 'new' ? 'selected' : '' ?>>Mới</option>
                    <option value="read" <?= ($filters['status'] ?? '') === 'read' ? 'selected' : '' ?>>Đã đọc</option>
                    <option value="replied" <?= ($filters['status'] ?? '') === 'replied' ? 'selected' : '' ?>>Đã phản
                        hồi</option>
                    <option value="archived" <?= ($filters['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Lưu trữ
                    </option>
                </select>
            </div>

            <div class="xl:col-span-2">
                <input type="date" name="date_from" class="input input-bordered rounded-2xl w-full"
                    value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
            </div>

            <div class="xl:col-span-2">
                <input type="date" name="date_to" class="input input-bordered rounded-2xl w-full"
                    value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
            </div>

            <div class="xl:col-span-1">
                <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                    Lọc
                </button>
            </div>

            <div class="xl:col-span-1">
                <a href="index.php?area=admin&controller=contact&action=index"
                    class="btn btn-outline rounded-2xl w-full">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-950">
                    Danh sách liên hệ
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Các liên hệ mới nhất từ website.
                </p>
            </div>

            <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                <?= htmlspecialchars($totalMessages ?? count($messages)) ?> liên hệ
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table min-w-[1000px]">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Chủ đề</th>
                        <th>Trạng thái</th>
                        <th>Ngày gửi</th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $item): ?>
                            <tr>
                                <td class="font-bold">
                                    #<?= htmlspecialchars($item['id']) ?>
                                </td>

                                <td>
                                    <div class="font-bold">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="font-semibold">
                                        <?= htmlspecialchars($item['email']) ?>
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        <?= htmlspecialchars($item['phone'] ?? '-') ?>
                                    </div>
                                </td>

                                <td class="max-w-xs">
                                    <p class="font-semibold truncate">
                                        <?= htmlspecialchars($item['subject']) ?>
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        <?= htmlspecialchars($item['message']) ?>
                                    </p>
                                </td>

                                <td>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold <?= contactStatusClass($item['status']) ?>">
                                        <?= contactStatusLabel($item['status']) ?>
                                    </span>
                                </td>

                                <td class="text-sm text-slate-500 whitespace-nowrap">
                                    <?= htmlspecialchars($item['created_at']) ?>
                                </td>

                                <td class="text-right whitespace-nowrap">
                                    <a href="index.php?area=admin&controller=contact&action=detail&id=<?= urlencode($item['id']) ?>"
                                        class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                                        Chi tiết
                                    </a>

                                    <a href="index.php?area=admin&controller=contact&action=delete&id=<?= urlencode($item['id']) ?>"
                                        class="btn btn-sm btn-error rounded-2xl" onclick="return confirm('Xóa liên hệ này?')">
                                        Xóa
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="py-16 text-center text-slate-500">
                                    Chưa có liên hệ nào.
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (($totalPages ?? 1) > 1): ?>
            <div class="p-5 border-t border-slate-100 flex justify-center">
                <div class="join">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?= contactPageUrl($filters, $i) ?>"
                            class="join-item btn <?= (int)($page ?? 1) === $i ? 'bg-slate-900 text-white border-slate-900' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>