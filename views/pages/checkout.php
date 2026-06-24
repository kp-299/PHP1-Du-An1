<?php
$settings = $settings ?? [];
$paymentSettings = $paymentSettings ?? [];
$currentUser = $currentUser ?? null;
$old = $old ?? [];
$errors = $errors ?? [];

$cartItems = $cartItems ?? [];
$totalAmount = $totalAmount ?? 0;

$codEnabled = ($paymentSettings['cod_enabled'] ?? '1') === '1';
$qrEnabled = ($paymentSettings['qr_enabled'] ?? '1') === '1';

$selectedPayment = $old['payment_method'] ?? ($codEnabled ? 'cod' : 'bank_qr');

$bankName = $paymentSettings['bank_name'] ?? '';
$bankAccountName = $paymentSettings['bank_account_name'] ?? '';
$bankAccountNumber = $paymentSettings['bank_account_number'] ?? '';
$bankQrImage = $paymentSettings['bank_qr_image'] ?? '';
$bankTransferContent = $paymentSettings['bank_transfer_content'] ?? 'THANHTOAN DONHANG {order_id}';

$userName = $currentUser['name'] ?? '';
$userEmail = $currentUser['email'] ?? '';
$userPhone = $currentUser['phone'] ?? '';
$userAddress = $currentUser['address'] ?? '';

function checkoutOld($old, $key, $default = '')
{
    return htmlspecialchars($old[$key] ?? $default);
}

function checkoutError($errors, $key)
{
    if (empty($errors[$key])) {
        return '';
    }

    return '<p class="text-error text-sm mt-2">' . htmlspecialchars($errors[$key]) . '</p>';
}

function checkoutImageExists($path)
{
    if (empty($path)) {
        return false;
    }

    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return true;
    }

    return file_exists(__DIR__ . '/../../' . ltrim($path, '/'));
}
?>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <span class="client-badge mb-3">
                    Checkout
                </span>

                <h1 class="client-section-title">
                    Thanh toán
                </h1>

                <p class="client-section-subtitle">
                    Kiểm tra thông tin giao hàng và chọn hình thức thanh toán.
                </p>
            </div>

            <a href="index.php?area=client&controller=cart&action=index" class="client-btn-outline h-11 px-5 w-fit">
                ← Quay lại giỏ hàng
            </a>
        </div>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-error rounded-3xl mb-6">
                <span><?= htmlspecialchars($errors['general']) ?></span>
            </div>
        <?php endif; ?>

        <form action="index.php?area=client&controller=order&action=handleCheckout" method="POST"
            class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-8 space-y-6">
                <div class="client-card p-5 sm:p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Thông tin nhận hàng
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Nhập đúng số điện thoại và địa chỉ thật để giao hàng.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Họ tên
                            </label>

                            <input type="text" name="customer_name"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['customer_name']) ? 'input-error' : '' ?>"
                                value="<?= checkoutOld($old, 'customer_name', $userName) ?>" placeholder="Nguyễn Văn A">

                            <?= checkoutError($errors, 'customer_name') ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Số điện thoại
                            </label>

                            <input type="text" name="customer_phone"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['customer_phone']) ? 'input-error' : '' ?>"
                                value="<?= checkoutOld($old, 'customer_phone', $userPhone) ?>" placeholder="090...">

                            <?= checkoutError($errors, 'customer_phone') ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Email
                            </label>

                            <input type="email" name="customer_email"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['customer_email']) ? 'input-error' : '' ?>"
                                value="<?= checkoutOld($old, 'customer_email', $userEmail) ?>"
                                placeholder="email@gmail.com">

                            <?= checkoutError($errors, 'customer_email') ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Địa chỉ giao hàng
                            </label>

                            <textarea name="customer_address"
                                class="textarea textarea-bordered rounded-3xl w-full min-h-28 bg-white <?= !empty($errors['customer_address']) ? 'textarea-error' : '' ?>"
                                placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành..."><?= checkoutOld($old, 'customer_address', $userAddress) ?></textarea>

                            <?= checkoutError($errors, 'customer_address') ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Ghi chú
                            </label>

                            <textarea name="note"
                                class="textarea textarea-bordered rounded-3xl w-full min-h-24 bg-white"
                                placeholder="Ví dụ: Giao buổi chiều, gọi trước khi giao..."><?= checkoutOld($old, 'note') ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="client-card p-5 sm:p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Hình thức thanh toán
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Chọn COD hoặc chuyển khoản QR.
                        </p>
                    </div>

                    <?= checkoutError($errors, 'payment_method') ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if ($codEnabled): ?>
                            <label
                                class="cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 p-5 hover:bg-green-50 hover:border-green-500 transition">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="payment_method" value="cod" class="radio radio-success mt-1"
                                        <?= $selectedPayment === 'cod' ? 'checked' : '' ?>>

                                    <div>
                                        <p class="font-extrabold text-slate-950">
                                            Thanh toán khi nhận hàng
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1 leading-6">
                                            Trả tiền trực tiếp cho shipper khi nhận hàng.
                                        </p>
                                    </div>
                                </div>
                            </label>
                        <?php endif; ?>

                        <?php if ($qrEnabled): ?>
                            <label
                                class="cursor-pointer rounded-3xl border border-slate-200 bg-slate-50 p-5 hover:bg-green-50 hover:border-green-500 transition">
                                <div class="flex items-start gap-3">
                                    <input type="radio" name="payment_method" value="bank_qr"
                                        class="radio radio-success mt-1"
                                        <?= $selectedPayment === 'bank_qr' ? 'checked' : '' ?>>

                                    <div>
                                        <p class="font-extrabold text-slate-950">
                                            Chuyển khoản QR
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1 leading-6">
                                            Quét QR hoặc chuyển khoản theo thông tin ngân hàng.
                                        </p>
                                    </div>
                                </div>
                            </label>
                        <?php endif; ?>
                    </div>

                    <?php if ($qrEnabled): ?>
                        <div class="mt-6 rounded-3xl bg-slate-50 border border-slate-200 p-5">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div class="md:col-span-1">
                                    <div
                                        class="rounded-3xl bg-white border border-slate-200 min-h-64 flex items-center justify-center overflow-hidden">
                                        <?php if (checkoutImageExists($bankQrImage)): ?>
                                            <img src="<?= htmlspecialchars($bankQrImage) ?>" alt="QR thanh toán"
                                                class="w-full h-full object-contain">
                                        <?php else: ?>
                                            <div class="text-center text-slate-400 p-8">
                                                <div class="text-5xl mb-3">🏦</div>
                                                <p>Chưa có ảnh QR</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <h3 class="text-xl font-extrabold text-slate-950">
                                        Thông tin chuyển khoản
                                    </h3>

                                    <div class="mt-4 space-y-3">
                                        <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                            <span class="text-slate-500">Ngân hàng</span>
                                            <span
                                                class="font-bold text-right"><?= htmlspecialchars($bankName ?: '-') ?></span>
                                        </div>

                                        <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                            <span class="text-slate-500">Chủ tài khoản</span>
                                            <span
                                                class="font-bold text-right"><?= htmlspecialchars($bankAccountName ?: '-') ?></span>
                                        </div>

                                        <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                            <span class="text-slate-500">Số tài khoản</span>
                                            <span
                                                class="font-bold text-right"><?= htmlspecialchars($bankAccountNumber ?: '-') ?></span>
                                        </div>

                                        <div class="flex justify-between gap-4 border-b border-slate-200 pb-3">
                                            <span class="text-slate-500">Nội dung CK</span>
                                            <span class="font-bold text-right">
                                                <?= htmlspecialchars(str_replace('{order_id}', 'Mã đơn sau khi đặt', $bankTransferContent)) ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="alert alert-warning rounded-3xl mt-5">
                                        <span>
                                            Sau khi đặt hàng, admin sẽ kiểm tra chuyển khoản và cập nhật trạng thái thanh
                                            toán.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="lg:sticky lg:top-24 client-card p-5 sm:p-6">
                    <h2 class="text-2xl font-extrabold text-slate-950 mb-5">
                        Đơn hàng của bạn
                    </h2>

                    <div class="space-y-4 max-h-[420px] overflow-y-auto pr-1">
                        <?php foreach ($cartItems as $item): ?>
                            <?php
                            $price = $item['price'];

                            if (!empty($item['sale_price']) && $item['sale_price'] > 0) {
                                $price = $item['sale_price'];
                            }

                            $subtotal = $price * $item['quantity'];
                            ?>

                            <div class="flex gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-green-50 overflow-hidden shrink-0">
                                    <?php if (checkoutImageExists($item['image'] ?? '')): ?>
                                        <img src="<?= htmlspecialchars($item['image']) ?>"
                                            alt="<?= htmlspecialchars($item['name']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-3xl">🍏</div>
                                    <?php endif; ?>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-sm leading-5 truncate text-slate-950">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        <?= number_format($price) ?>đ x <?= htmlspecialchars($item['quantity']) ?>
                                    </p>
                                </div>

                                <div class="font-bold text-sm whitespace-nowrap text-slate-950">
                                    <?= number_format($subtotal) ?>đ
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="divider"></div>

                    <div class="space-y-3">
                        <div class="flex justify-between text-slate-500">
                            <span>Tạm tính</span>
                            <span><?= number_format($totalAmount) ?>đ</span>
                        </div>

                        <div class="flex justify-between text-slate-500">
                            <span>Phí giao hàng</span>
                            <span>0đ</span>
                        </div>

                        <div
                            class="flex justify-between text-xl font-extrabold text-slate-950 pt-3 border-t border-slate-200">
                            <span>Tổng cộng</span>
                            <span class="text-green-700"><?= number_format($totalAmount) ?>đ</span>
                        </div>
                    </div>

                    <button type="submit" class="client-btn-accent h-12 px-5 w-full mt-6">
                        Đặt hàng
                    </button>

                    <a href="index.php?area=client&controller=cart&action=index"
                        class="client-btn-outline h-12 px-5 w-full mt-3">
                        Quay lại giỏ hàng
                    </a>
                </div>
            </aside>
        </form>
    </div>
</section>