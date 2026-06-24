<?php
$cartItems = $cartItems ?? [];
$totalAmount = $totalAmount ?? 0;

function cartItemPrice($item)
{
    if (!empty($item['sale_price']) && $item['sale_price'] > 0) {
        return $item['sale_price'];
    }

    return $item['price'] ?? 0;
}

function cartImageExists($path)
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
                    Shopping Cart
                </span>

                <h1 class="client-section-title">
                    Giỏ hàng
                </h1>

                <p class="client-section-subtitle">
                    Kiểm tra sản phẩm trước khi tiến hành thanh toán.
                </p>
            </div>

            <a href="index.php?area=client&controller=product&action=index" class="client-btn-outline h-11 px-5 w-fit">
                ← Tiếp tục mua hàng
            </a>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div
                class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> rounded-3xl mb-6">
                <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if (!empty($cartItems)): ?>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8">
                    <div class="client-card overflow-hidden">
                        <div class="p-5 sm:p-6 border-b border-slate-100">
                            <h2 class="text-2xl font-extrabold text-slate-950">
                                Sản phẩm trong giỏ
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Có <?= count($cartItems) ?> sản phẩm trong giỏ hàng.
                            </p>
                        </div>

                        <div class="divide-y divide-slate-100">
                            <?php foreach ($cartItems as $item): ?>
                                <?php
                                $price = cartItemPrice($item);
                                $quantity = (int)($item['quantity'] ?? 1);
                                $subtotal = $price * $quantity;
                                ?>

                                <div class="p-4 sm:p-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-4 sm:items-center">
                                        <div class="sm:col-span-5 flex gap-4">
                                            <div class="w-24 h-24 rounded-3xl bg-green-50 overflow-hidden shrink-0">
                                                <?php if (cartImageExists($item['image'] ?? '')): ?>
                                                    <img src="<?= htmlspecialchars($item['image']) ?>"
                                                        alt="<?= htmlspecialchars($item['name'] ?? '') ?>"
                                                        class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <div class="w-full h-full flex items-center justify-center text-5xl">
                                                        🍏
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="min-w-0">
                                                <h3 class="font-extrabold text-slate-950 leading-6">
                                                    <?= htmlspecialchars($item['name'] ?? 'Sản phẩm') ?>
                                                </h3>

                                                <p class="text-sm text-slate-500 mt-1">
                                                    Đơn vị: <?= htmlspecialchars($item['unit'] ?? '-') ?>
                                                </p>

                                                <?php if (!empty($item['sale_price']) && $item['sale_price'] > 0): ?>
                                                    <p class="text-sm text-slate-400 line-through mt-2">
                                                        <?= number_format($item['price'] ?? 0) ?>đ
                                                    </p>
                                                <?php endif; ?>

                                                <p class="font-bold text-green-700 mt-1">
                                                    <?= number_format($price) ?>đ
                                                </p>
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <form action="index.php?area=client&controller=cart&action=update" method="POST"
                                                class="flex items-center gap-2">
                                                <input type="hidden" name="product_id"
                                                    value="<?= htmlspecialchars($item['id']) ?>">

                                                <input type="number" name="quantity" min="1"
                                                    value="<?= htmlspecialchars($quantity) ?>"
                                                    class="input input-bordered rounded-full w-24">

                                                <button class="client-btn-primary h-10 px-4 text-sm">
                                                    Cập nhật
                                                </button>
                                            </form>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <p class="text-sm text-slate-500">Thành tiền</p>

                                            <p class="font-extrabold text-slate-950">
                                                <?= number_format($subtotal) ?>đ
                                            </p>
                                        </div>

                                        <div class="sm:col-span-2 sm:text-right">
                                            <a href="index.php?area=client&controller=cart&action=remove&id=<?= urlencode($item['id']) ?>"
                                                class="h-10 px-4 rounded-full border border-rose-200 hover:bg-rose-50 text-rose-600 inline-flex items-center justify-center text-sm font-bold transition"
                                                onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                Xóa
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <aside class="lg:col-span-4">
                    <div class="lg:sticky lg:top-24 client-card p-5 sm:p-6">
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Tóm tắt đơn hàng
                        </h2>

                        <div class="space-y-3 mt-5">
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
                                <span class="text-green-700">
                                    <?= number_format($totalAmount) ?>đ
                                </span>
                            </div>
                        </div>

                        <a href="index.php?area=client&controller=order&action=checkout"
                            class="client-btn-accent h-12 px-5 w-full mt-6">
                            Tiến hành thanh toán
                        </a>

                        <a href="index.php?area=client&controller=cart&action=clear"
                            class="h-12 px-5 rounded-full border border-rose-200 hover:bg-rose-50 text-rose-600 inline-flex items-center justify-center font-bold transition w-full mt-3"
                            onclick="return confirm('Bạn muốn xóa toàn bộ giỏ hàng?')">
                            Xóa giỏ hàng
                        </a>
                    </div>
                </aside>
            </div>
        <?php else: ?>
            <div class="client-card p-10 sm:p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-green-50 flex items-center justify-center text-5xl mx-auto">
                    🛒
                </div>

                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 mt-6">
                    Giỏ hàng đang trống
                </h2>

                <p class="text-slate-500 mt-3">
                    Bạn chưa thêm sản phẩm nào vào giỏ hàng.
                </p>

                <a href="index.php?area=client&controller=product&action=index" class="client-btn-accent h-11 px-6 mt-6">
                    Mua sắm ngay
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>