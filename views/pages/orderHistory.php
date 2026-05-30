<?php
$orders = $orders ?? [];

function orderHistoryStatusLabel($status)
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

function orderHistoryStatusClass($status)
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

function orderHistoryPaymentLabel($status)
{
    return match ($status) {
        'paid' => 'Đã thanh toán',
        'unpaid' => 'Chưa thanh toán',
        'refunded' => 'Đã hoàn tiền',
        default => 'Không rõ',
    };
}

function orderHistoryPaymentClass($status)
{
    return match ($status) {
        'paid' => 'bg-emerald-100 text-emerald-700',
        'unpaid' => 'bg-rose-100 text-rose-700',
        'refunded' => 'bg-sky-100 text-sky-700',
        default => 'bg-slate-100 text-slate-700',
    };
}

function orderHistoryPaymentMethodLabel($method)
{
    return match ($method) {
        'cod' => 'COD',
        'bank_qr' => 'QR',
        default => 'Khác',
    };
}
?>

<section class="max-w-7xl mx-auto px-3 sm:px-4 py-8 sm:py-12">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500">Fresh Fruit Store</p>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-950">
                Lịch sử đơn hàng
            </h1>

            <p class="text-slate-500 mt-2">
                Theo dõi toàn bộ đơn hàng đã đặt, trạng thái xử lý và thanh toán.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="index.php?area=client&controller=user&action=profile&tab=current_orders"
                class="btn btn-outline rounded-2xl">
                Đơn hiện tại
            </a>

            <a href="index.php?area=client&controller=user&action=profile&tab=overview"
                class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                User Dashboard
            </a>
        </div>
    </div>

    <?php if (!empty($_SESSION['flash'])): ?>
        <div
            class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> rounded-3xl mb-6">
            <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-5 shadow-sm">
            <p class="text-slate-500">Tổng đơn</p>
            <p class="text-3xl font-extrabold mt-3">
                <?= count($orders) ?>
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-5 shadow-sm">
            <p class="text-slate-500">Đang xử lý</p>
            <p class="text-3xl font-extrabold mt-3 text-amber-600">
                <?= count(array_filter($orders, fn($order) => in_array($order['status'] ?? '', ['pending', 'processing', 'shipping'], true))) ?>
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-5 shadow-sm">
            <p class="text-slate-500">Đã hoàn thành</p>
            <p class="text-3xl font-extrabold mt-3 text-green-600">
                <?= count(array_filter($orders, fn($order) => ($order['status'] ?? '') === 'completed')) ?>
            </p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div
            class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-950">
                    Danh sách đơn hàng
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Các đơn hàng được tạo từ tài khoản của bạn.
                </p>
            </div>

            <span class="w-fit px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                <?= count($orders) ?> đơn hàng
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="table min-w-[980px]">
                <thead>
                    <tr class="text-slate-500">
                        <th>Mã đơn</th>
                        <th>Người nhận</th>
                        <th>Liên hệ</th>
                        <th>Tổng tiền</th>
                        <th>Hình thức</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-right">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="font-extrabold">
                                    #<?= htmlspecialchars($order['id'] ?? '') ?>
                                </td>

                                <td>
                                    <div class="font-bold text-slate-950">
                                        <?= htmlspecialchars($order['customer_name'] ?? '-') ?>
                                    </div>

                                    <div class="text-xs text-slate-500 max-w-48 truncate">
                                        <?= htmlspecialchars($order['customer_address'] ?? '-') ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="text-sm font-semibold">
                                        <?= htmlspecialchars($order['customer_phone'] ?? '-') ?>
                                    </div>

                                    <div class="text-xs text-slate-500 max-w-48 truncate">
                                        <?= htmlspecialchars($order['customer_email'] ?? '-') ?>
                                    </div>
                                </td>

                                <td class="font-extrabold text-green-600 whitespace-nowrap">
                                    <?= number_format($order['total_amount'] ?? 0) ?>đ
                                </td>

                                <td>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                        <?= orderHistoryPaymentMethodLabel($order['payment_method'] ?? '') ?>
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold <?= orderHistoryPaymentClass($order['payment_status'] ?? '') ?>">
                                        <?= orderHistoryPaymentLabel($order['payment_status'] ?? '') ?>
                                    </span>
                                </td>

                                <td>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold <?= orderHistoryStatusClass($order['status'] ?? '') ?>">
                                        <?= orderHistoryStatusLabel($order['status'] ?? '') ?>
                                    </span>
                                </td>

                                <td class="text-sm text-slate-500 whitespace-nowrap">
                                    <?= htmlspecialchars($order['created_at'] ?? '-') ?>
                                </td>

                                <td class="text-right whitespace-nowrap">
                                    <a href="index.php?area=client&controller=order&action=detail&id=<?= urlencode($order['id']) ?>"
                                        class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                                        Chi tiết
                                    </a>

                                    <?php if (($order['status'] ?? '') === 'pending'): ?>
                                        <a href="index.php?area=client&controller=order&action=cancel&id=<?= urlencode($order['id']) ?>"
                                            class="btn btn-sm btn-error rounded-2xl"
                                            onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                                            Hủy
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="py-16 text-center">
                                    <div
                                        class="w-20 h-20 rounded-[2rem] bg-green-50 flex items-center justify-center text-5xl mx-auto">
                                        📦
                                    </div>

                                    <h3 class="text-2xl font-extrabold text-slate-950 mt-5">
                                        Chưa có đơn hàng nào
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Sau khi đặt hàng, đơn hàng của bạn sẽ xuất hiện ở đây.
                                    </p>

                                    <a href="index.php?area=client&controller=product&action=index"
                                        class="btn site-gradient-bg border-0 text-white rounded-2xl mt-6">
                                        Mua sắm ngay
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>