<?php
$paymentSettings = $paymentSettings ?? [];

function paymentValue($settings, $key, $default = '')
{
    return htmlspecialchars($settings[$key] ?? $default);
}

$qrEnabled = ($paymentSettings['qr_enabled'] ?? '1') === '1';
$codEnabled = ($paymentSettings['cod_enabled'] ?? '1') === '1';
$qrImage = $paymentSettings['bank_qr_image'] ?? '';
?>

<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Admin Dashboard</p>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
                Cài đặt thanh toán
            </h1>

            <p class="text-slate-500 mt-2 max-w-3xl">
                Quản lý hình thức thanh toán COD và chuyển khoản QR cho trang checkout.
            </p>
        </div>

        <a href="index.php?area=client&controller=order&action=checkout" class="btn btn-outline rounded-2xl w-fit">
            Xem trang checkout
        </a>
    </div>

    <form action="index.php?area=admin&controller=payment&action=update" method="POST" enctype="multipart/form-data"
        class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Trạng thái thanh toán
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Bật/tắt các phương thức thanh toán ngoài client.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Thanh toán COD
                        </label>

                        <select name="cod_enabled" class="select select-bordered rounded-2xl w-full bg-white">
                            <option value="1" <?= $codEnabled ? 'selected' : '' ?>>Bật COD</option>
                            <option value="0" <?= !$codEnabled ? 'selected' : '' ?>>Tắt COD</option>
                        </select>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Chuyển khoản QR
                        </label>

                        <select name="qr_enabled" class="select select-bordered rounded-2xl w-full bg-white">
                            <option value="1" <?= $qrEnabled ? 'selected' : '' ?>>Bật QR</option>
                            <option value="0" <?= !$qrEnabled ? 'selected' : '' ?>>Tắt QR</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                        Ảnh QR thanh toán
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Upload ảnh QR ngân hàng hoặc QR tạo sẵn.
                    </p>
                </div>

                <input type="file" name="bank_qr_image" class="file-input file-input-bordered rounded-2xl w-full">

                <div
                    class="mt-5 rounded-3xl bg-slate-50 border border-slate-200 min-h-64 flex items-center justify-center overflow-hidden">
                    <?php if (!empty($qrImage)): ?>
                        <img src="<?= htmlspecialchars($qrImage) ?>" alt="QR thanh toán" class="max-h-72 object-contain">
                    <?php else: ?>
                        <div class="text-center text-slate-400 p-8">
                            <div class="text-5xl mb-3">🏦</div>
                            <p>Chưa có ảnh QR</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
            <div class="mb-6">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-950">
                    Thông tin ngân hàng
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Thông tin này sẽ hiển thị khi user chọn chuyển khoản QR.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Tên ngân hàng
                    </label>

                    <input type="text" name="bank_name" class="input input-bordered rounded-2xl w-full"
                        placeholder="Ví dụ: Vietcombank" value="<?= paymentValue($paymentSettings, 'bank_name') ?>">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Số tài khoản
                    </label>

                    <input type="text" name="bank_account_number" class="input input-bordered rounded-2xl w-full"
                        placeholder="Ví dụ: 123456789"
                        value="<?= paymentValue($paymentSettings, 'bank_account_number') ?>">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Tên chủ tài khoản
                    </label>

                    <input type="text" name="bank_account_name" class="input input-bordered rounded-2xl w-full"
                        placeholder="Ví dụ: NGUYEN VAN A"
                        value="<?= paymentValue($paymentSettings, 'bank_account_name') ?>">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">
                        Nội dung chuyển khoản mẫu
                    </label>

                    <input type="text" name="bank_transfer_content" class="input input-bordered rounded-2xl w-full"
                        placeholder="THANHTOAN DONHANG {order_id}"
                        value="<?= paymentValue($paymentSettings, 'bank_transfer_content', 'THANHTOAN DONHANG {order_id}') ?>">

                    <p class="text-xs text-slate-500 mt-2">
                        Dùng <b>{order_id}</b> để tự thay bằng mã đơn hàng.
                    </p>
                </div>
            </div>
        </div>

        <div class="sticky bottom-4 flex justify-end">
            <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl shadow-lg">
                Lưu cài đặt thanh toán
            </button>
        </div>
    </form>
</div>