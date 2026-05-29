<?php
$order = $order ?? [];
$orderItems = $orderItems ?? [];
$paymentSettings = $paymentSettings ?? [];

$bankTransferContent = $paymentSettings['bank_transfer_content'] ?? 'THANHTOAN DONHANG {order_id}';
$transferContent = str_replace('{order_id}', $order['id'] ?? '', $bankTransferContent);

function orderStatusLabel($status)
{
    return match ($status) {
        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'shipping' => 'Đang giao',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
        default => 'Không rõ',
    };
}

function orderStatusClass($status)
{
    return match ($status) {
        'pending' => 'bg-amber-100 text-amber-700',
        'processing' => 'bg-sky-100 text-sky-700',
        'shipping' => 'bg-violet-100 text-violet-700',
        'completed' => 'bg-emerald-100 text-emerald-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };
}

function paymentStatusLabel($status)
{
    return match ($status) {
        'paid' => 'Đã thanh toán',
        'unpaid' => 'Chưa thanh toán',
        'refunded' => 'Đã hoàn tiền',
        default => 'Không rõ',
    };
}

function paymentStatusClass($status)
{
    return match ($status) {
        'paid' => 'bg-emerald-100 text-emerald-700',
        'unpaid' => 'bg-amber-100 text-amber-700',
        'refunded' => 'bg-sky-100 text-sky-700',
        default => 'bg-slate-100 text-slate-700',
    };
}

function paymentMethodLabel($method)
{
    return match ($method) {
        'cod' => 'Thanh toán khi nhận hàng',
        'bank_qr' => 'Chuyển khoản QR',
        default => 'Không rõ',
    };
}
?>

<section class="max-w-7xl mx-auto px-3 sm:px-4 py-8 sm:py-12">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Fresh Fruit Store</p>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-950">
                Chi tiết đơn hàng #<?= htmlspecialchars($order['id'] ?? '') ?>
            </h1>

            <p class="text-slate-500 mt-2">
                Theo dõi thông tin đơn hàng và trạng thái thanh toán.
            </p>
        </div>

        <a href="index.php?area=client&controller=order&action=history" class="btn btn-outline rounded-2xl w-fit">
            ← Lịch sử đơn hàng
        </a>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div
            class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> rounded-3xl mb-6">
            <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Thông tin đơn hàng
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Ngày tạo: <?= htmlspecialchars($order['created_at'] ?? '-') ?>
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold <?= orderStatusClass($order['status'] ?? '') ?>">
                            <?= orderStatusLabel($order['status'] ?? '') ?>
                        </span>

                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold <?= paymentStatusClass($order['payment_status'] ?? '') ?>">
                            <?= paymentStatusLabel($order['payment_status'] ?? '') ?>
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Người nhận</p>
                        <p class="font-bold text-slate-950 mt-1">
                            <?= htmlspecialchars($order['customer_name'] ?? '-') ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Số điện thoại</p>
                        <p class="font-bold text-slate-950 mt-1">
                            <?= htmlspecialchars($order['customer_phone'] ?? '-') ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Email</p>
                        <p class="font-bold text-slate-950 mt-1 break-all">
                            <?= htmlspecialchars($order['customer_email'] ?? '-') ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Hình thức thanh toán</p>
                        <p class="font-bold text-slate-950 mt-1">
                            <?= paymentMethodLabel($order['payment_method'] ?? '') ?>
                        </p>
                    </div>

                    <div class="md:col-span-2 rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Địa chỉ giao hàng</p>
                        <p class="font-bold text-slate-950 mt-1">
                            <?= htmlspecialchars($order['customer_address'] ?? '-') ?>
                        </p>
                    </div>

                    <?php if (!empty($order['note'])): ?>
                        <div class="md:col-span-2 rounded-3xl bg-slate-50 border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Ghi chú</p>
                            <p class="font-bold text-slate-950 mt-1">
                                <?= nl2br(htmlspecialchars($order['note'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (($order['payment_method'] ?? '') === 'bank_qr' && ($order['payment_status'] ?? '') === 'unpaid'): ?>
                <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                    <h2 class="text-2xl font-extrabold text-slate-950">
                        Thanh toán chuyển khoản
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Vui lòng chuyển khoản đúng nội dung để admin xác nhận nhanh hơn.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                        <div
                            class="rounded-3xl bg-slate-50 border border-slate-200 min-h-64 flex items-center justify-center overflow-hidden">
                            <?php if (!empty($paymentSettings['bank_qr_image'])): ?>
                                <img src="<?= htmlspecialchars($paymentSettings['bank_qr_image']) ?>"
                                    class="w-full h-full object-contain" alt="QR thanh toán">
                            <?php else: ?>
                                <span class="text-slate-400">Chưa có QR</span>
                            <?php endif; ?>
                        </div>

                        <div class="md:col-span-2 space-y-3">
                            <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                <span class="text-slate-500">Ngân hàng</span>
                                <span class="font-bold text-right">
                                    <?= htmlspecialchars($paymentSettings['bank_name'] ?? '-') ?>
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                <span class="text-slate-500">Chủ tài khoản</span>
                                <span class="font-bold text-right">
                                    <?= htmlspecialchars($paymentSettings['bank_account_name'] ?? '-') ?>
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                <span class="text-slate-500">Số tài khoản</span>
                                <span class="font-bold text-right">
                                    <?= htmlspecialchars($paymentSettings['bank_account_number'] ?? '-') ?>
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                <span class="text-slate-500">Số tiền</span>
                                <span class="font-bold text-right text-green-600">
                                    <?= number_format($order['total_amount'] ?? 0) ?>đ
                                </span>
                            </div>

                            <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                <span class="text-slate-500">Nội dung</span>
                                <span class="font-bold text-right">
                                    <?= htmlspecialchars($transferContent) ?>
                                </span>
                            </div>

                            <div class="alert alert-warning rounded-3xl mt-5">
                                <span>
                                    Sau khi chuyển khoản, admin sẽ kiểm tra và cập nhật trạng thái thanh toán.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
                <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Sản phẩm đã đặt
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Danh sách sản phẩm trong đơn hàng.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table min-w-[760px]">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Đơn vị</th>
                                <th class="text-right">Thành tiền</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="font-bold">
                                            <?= htmlspecialchars($item['product_name'] ?? '-') ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?= number_format($item['product_price'] ?? 0) ?>đ
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($item['quantity'] ?? 0) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($item['unit'] ?? '-') ?>
                                    </td>

                                    <td class="text-right font-bold">
                                        <?= number_format($item['subtotal'] ?? 0) ?>đ
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($orderItems)): ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="text-center py-10 text-slate-500">
                                            Không có sản phẩm trong đơn hàng.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <aside class="lg:col-span-4">
            <div class="lg:sticky lg:top-24 space-y-6">
                <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                    <h2 class="text-2xl font-extrabold text-slate-950">
                        Tổng thanh toán
                    </h2>

                    <div class="space-y-3 mt-5">
                        <div class="flex justify-between text-slate-500">
                            <span>Tạm tính</span>
                            <span><?= number_format($order['total_amount'] ?? 0) ?>đ</span>
                        </div>

                        <div class="flex justify-between text-slate-500">
                            <span>Phí giao hàng</span>
                            <span>0đ</span>
                        </div>

                        <div
                            class="flex justify-between text-xl font-extrabold text-slate-950 pt-3 border-t border-slate-200">
                            <span>Tổng cộng</span>
                            <span class="text-green-600">
                                <?= number_format($order['total_amount'] ?? 0) ?>đ
                            </span>
                        </div>
                    </div>

                    <?php if (($order['status'] ?? '') === 'pending'): ?>
                        <a href="index.php?area=client&controller=order&action=cancel&id=<?= urlencode($order['id']) ?>"
                            class="btn btn-outline btn-error rounded-2xl w-full mt-6"
                            onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                            Hủy đơn hàng
                        </a>
                    <?php endif; ?>

                    <a href="index.php?area=client&controller=product&action=index"
                        class="btn site-gradient-bg border-0 text-white rounded-2xl w-full mt-3">
                        Tiếp tục mua hàng
                    </a>
                </div>

                <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
                    <h3 class="text-xl font-extrabold text-slate-950">
                        Trạng thái đơn hàng
                    </h3>

                    <div class="mt-5 space-y-4">
                        <?php
                        $steps = [
                            'pending' => 'Chờ xử lý',
                            'processing' => 'Đang xử lý',
                            'shipping' => 'Đang giao',
                            'completed' => 'Hoàn thành',
                        ];

                        $currentStatus = $order['status'] ?? 'pending';
                        $passed = true;
                        ?>

                        <?php foreach ($steps as $key => $label): ?>
                            <?php
                            $isCurrent = $currentStatus === $key;
                            $isCancelled = $currentStatus === 'cancelled';

                            if ($isCurrent) {
                                $passed = false;
                            }
                            ?>

                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    <?= (!$isCancelled && ($isCurrent || $passed)) ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-400' ?>">
                                    ✓
                                </div>

                                <p class="font-semibold <?= $isCurrent ? 'text-slate-950' : 'text-slate-500' ?>">
                                    <?= htmlspecialchars($label) ?>
                                </p>
                            </div>
                        <?php endforeach; ?>

                        <?php if (($order['status'] ?? '') === 'cancelled'): ?>
                            <div class="alert alert-error rounded-3xl mt-4">
                                <span>Đơn hàng đã được hủy.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</section>