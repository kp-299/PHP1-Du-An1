<?php
$message = $message ?? [];

function contactDetailStatusLabel($status)
{
    return match ($status) {
        'new' => 'Mới',
        'read' => 'Đã đọc',
        'replied' => 'Đã phản hồi',
        'archived' => 'Lưu trữ',
        default => 'Không rõ',
    };
}
?>

<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Admin Dashboard</p>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
                Chi tiết liên hệ #<?= htmlspecialchars($message['id'] ?? '') ?>
            </h1>

            <p class="text-slate-500 mt-2">
                Xem nội dung khách hàng gửi và ghi chú xử lý.
            </p>
        </div>

        <a href="index.php?area=admin&controller=contact&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> rounded-3xl">
            <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <h2 class="text-2xl font-extrabold text-slate-950">
                    <?= htmlspecialchars($message['subject'] ?? '-') ?>
                </h2>

                <p class="text-slate-500 mt-2">
                    Gửi lúc: <?= htmlspecialchars($message['created_at'] ?? '-') ?>
                </p>

                <div class="divider"></div>

                <div class="prose max-w-none">
                    <p class="whitespace-pre-line leading-8">
                        <?= nl2br(htmlspecialchars($message['message'] ?? '')) ?>
                    </p>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <h2 class="text-2xl font-extrabold text-slate-950">
                    Ghi chú admin
                </h2>

                <form action="index.php?area=admin&controller=contact&action=updateNote" method="POST" class="mt-5">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($message['id']) ?>">

                    <textarea name="admin_note" class="textarea textarea-bordered rounded-2xl w-full min-h-36"
                        placeholder="Ghi chú nội bộ..."><?= htmlspecialchars($message['admin_note'] ?? '') ?></textarea>

                    <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl mt-4">
                        Lưu ghi chú
                    </button>
                </form>
            </div>
        </div>

        <aside class="lg:col-span-4 space-y-6">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <h2 class="text-2xl font-extrabold text-slate-950">
                    Khách hàng
                </h2>

                <div class="space-y-4 mt-5">
                    <div>
                        <p class="text-sm text-slate-500">Họ tên</p>
                        <p class="font-bold"><?= htmlspecialchars($message['name'] ?? '-') ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Email</p>
                        <p class="font-bold break-all"><?= htmlspecialchars($message['email'] ?? '-') ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Số điện thoại</p>
                        <p class="font-bold"><?= htmlspecialchars($message['phone'] ?? '-') ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">IP</p>
                        <p class="font-bold"><?= htmlspecialchars($message['ip_address'] ?? '-') ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <h2 class="text-2xl font-extrabold text-slate-950">
                    Trạng thái
                </h2>

                <p class="text-slate-500 mt-2">
                    Hiện tại: <b><?= contactDetailStatusLabel($message['status'] ?? '') ?></b>
                </p>

                <form action="index.php?area=admin&controller=contact&action=updateStatus" method="POST"
                    class="mt-5 space-y-4">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($message['id']) ?>">

                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="new" <?= ($message['status'] ?? '') === 'new' ? 'selected' : '' ?>>Mới</option>
                        <option value="read" <?= ($message['status'] ?? '') === 'read' ? 'selected' : '' ?>>Đã đọc
                        </option>
                        <option value="replied" <?= ($message['status'] ?? '') === 'replied' ? 'selected' : '' ?>>Đã
                            phản hồi</option>
                        <option value="archived" <?= ($message['status'] ?? '') === 'archived' ? 'selected' : '' ?>>Lưu
                            trữ</option>
                    </select>

                    <button class="btn site-gradient-bg border-0 text-white rounded-2xl w-full">
                        Cập nhật trạng thái
                    </button>
                </form>

                <a href="mailto:<?= htmlspecialchars($message['email'] ?? '') ?>?subject=RE: <?= htmlspecialchars($message['subject'] ?? '') ?>"
                    class="btn btn-outline rounded-2xl w-full mt-3">
                    Phản hồi qua email
                </a>
            </div>
        </aside>
    </div>
</div>