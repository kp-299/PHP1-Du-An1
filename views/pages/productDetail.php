<?php
$settings = $settings ?? [];

if (!function_exists('clientImageExists')) {
    function clientImageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return true;
        }

        $cleanPath = ltrim($path, '/');

        return file_exists(__DIR__ . '/../../' . $cleanPath);
    }
}

$images = [];

if (!empty($product['image']) && clientImageExists($product['image'])) {
    $images[] = $product['image'];
}

if (!empty($productImages)) {
    foreach ($productImages as $img) {
        if (!empty($img['image']) && clientImageExists($img['image'])) {
            $images[] = $img['image'];
        }

        if (!empty($img['image_path']) && clientImageExists($img['image_path'])) {
            $images[] = $img['image_path'];
        }
    }
}

$images = array_values(array_unique($images));

if (empty($images)) {
    $images = ['', '', ''];
}

$hasSalePrice = !empty($product['sale_price']) && $product['sale_price'] > 0;
$currentPrice = $hasSalePrice ? $product['sale_price'] : $product['price'];
$isOutOfStock = isset($product['stock']) && (int)$product['stock'] <= 0;
?>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <a href="index.php?area=client&controller=product&action=index" class="client-btn-outline h-11 px-5 w-fit">
                ← Quay lại sản phẩm
            </a>

            <div class="text-sm breadcrumbs text-slate-500">
                <ul>
                    <li>
                        <a href="index.php?area=client&controller=pages&action=home">Trang chủ</a>
                    </li>
                    <li>
                        <a href="index.php?area=client&controller=product&action=index">Sản phẩm</a>
                    </li>
                    <li><?= htmlspecialchars($product['name'] ?? 'Chi tiết') ?></li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
            <div>
                <div class="carousel w-full rounded-3xl overflow-hidden bg-white border border-slate-200 shadow-sm">
                    <?php foreach ($images as $index => $image): ?>
                        <?php
                        $slideId = 'product-img-' . ($index + 1);
                        $prevId = 'product-img-' . ($index === 0 ? count($images) : $index);
                        $nextId = 'product-img-' . ($index + 2 > count($images) ? 1 : $index + 2);
                        ?>

                        <div id="<?= $slideId ?>" class="carousel-item relative w-full">
                            <div class="w-full h-80 sm:h-[520px] bg-green-50">
                                <?php if (!empty($image)): ?>
                                    <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                        class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-8xl">
                                        🍏
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="absolute flex justify-between left-4 right-4 top-1/2 -translate-y-1/2">
                                <a href="#<?= $prevId ?>"
                                    class="btn btn-sm sm:btn-md btn-circle bg-white/90 border-0 text-slate-900">❮</a>
                                <a href="#<?= $nextId ?>"
                                    class="btn btn-sm sm:btn-md btn-circle bg-white/90 border-0 text-slate-900">❯</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="grid grid-cols-4 gap-3 mt-4">
                    <?php foreach ($images as $index => $image): ?>
                        <a href="#product-img-<?= $index + 1 ?>"
                            class="h-16 sm:h-20 rounded-2xl overflow-hidden bg-green-50 border border-slate-200 hover:ring-2 hover:ring-green-500 transition">
                            <?php if (!empty($image)): ?>
                                <img src="<?= htmlspecialchars($image) ?>" class="w-full h-full object-cover" alt="">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-3xl">🍏</div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="client-card p-5 sm:p-8 h-fit">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="badge bg-green-100 text-green-700 border-0">
                        <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                    </span>

                    <?php if (!$isOutOfStock): ?>
                        <span class="badge bg-sky-100 text-sky-700 border-0">
                            Còn hàng
                        </span>
                    <?php else: ?>
                        <span class="badge bg-rose-100 text-rose-700 border-0">
                            Hết hàng
                        </span>
                    <?php endif; ?>

                    <?php if ($hasSalePrice): ?>
                        <span class="badge bg-amber-100 text-amber-700 border-0">
                            Đang giảm giá
                        </span>
                    <?php endif; ?>
                </div>

                <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>

                <p class="text-slate-500 mt-4">
                    Mã sản phẩm: #<?= htmlspecialchars($product['id']) ?>
                </p>

                <div class="mt-6">
                    <?php if ($hasSalePrice): ?>
                        <p class="text-4xl font-extrabold text-rose-500">
                            <?= number_format($product['sale_price']) ?>đ
                        </p>

                        <p class="text-xl text-slate-400 line-through mt-1">
                            <?= number_format($product['price']) ?>đ
                        </p>
                    <?php else: ?>
                        <p class="text-4xl font-extrabold text-green-700">
                            <?= number_format($product['price']) ?>đ
                        </p>
                    <?php endif; ?>

                    <p class="text-sm text-slate-500 mt-2">
                        Đơn vị: <?= htmlspecialchars($product['unit'] ?? 'kg') ?>
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-6">
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Tồn kho</p>
                        <p class="text-2xl font-extrabold text-slate-950">
                            <?= htmlspecialchars($product['stock'] ?? 0) ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                        <p class="text-sm text-slate-500">Trạng thái</p>
                        <p class="text-lg font-extrabold text-slate-950">
                            <?= !$isOutOfStock ? 'Có thể mua' : 'Tạm hết' ?>
                        </p>
                    </div>
                </div>

                <form action="index.php?area=client&controller=cart&action=add" method="POST" class="space-y-4 mt-6">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Số lượng
                        </label>

                        <input type="number" name="quantity" min="1"
                            max="<?= htmlspecialchars($product['stock'] ?? 999) ?>" value="1"
                            class="input input-bordered rounded-full w-full" <?= $isOutOfStock ? 'disabled' : '' ?>>
                    </div>

                    <button type="submit"
                        class="client-btn-accent h-12 px-5 w-full disabled:bg-slate-200 disabled:text-slate-500"
                        <?= $isOutOfStock ? 'disabled' : '' ?>>
                        <?= $isOutOfStock ? 'Sản phẩm tạm hết hàng' : 'Thêm vào giỏ hàng' ?>
                    </button>
                </form>

                <div class="divider"></div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-center">
                    <div class="rounded-2xl bg-green-50 p-4">
                        <div class="text-2xl">🚚</div>
                        <p class="text-sm font-bold mt-2">Giao nhanh</p>
                    </div>

                    <div class="rounded-2xl bg-green-50 p-4">
                        <div class="text-2xl">✅</div>
                        <p class="text-sm font-bold mt-2">Tươi sạch</p>
                    </div>

                    <div class="rounded-2xl bg-green-50 p-4">
                        <div class="text-2xl">💬</div>
                        <p class="text-sm font-bold mt-2">Hỗ trợ tốt</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-slate-50">
    <div class="client-shell py-8 sm:py-10">
        <div class="client-card p-5 sm:p-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 mb-5">
                Mô tả sản phẩm
            </h2>

            <div class="prose max-w-none text-slate-600 leading-8">
                <?php if (!empty($product['description'])): ?>
                    <?= nl2br(htmlspecialchars($product['description'])) ?>
                <?php else: ?>
                    <p>
                        Sản phẩm hiện chưa có mô tả chi tiết. Bạn có thể cập nhật phần mô tả trong admin dashboard.
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <span class="client-badge mb-3">
                    Related
                </span>

                <h2 class="client-section-title">
                    Sản phẩm liên quan
                </h2>

                <p class="client-section-subtitle">
                    Các sản phẩm cùng danh mục.
                </p>
            </div>
        </div>

        <?php if (!empty($relatedProducts)): ?>
            <div class="carousel carousel-center w-full space-x-4 rounded-box">
                <?php foreach ($relatedProducts as $related): ?>
                    <?php
                    $relatedDetailUrl = 'index.php?area=client&controller=product&action=detail&id=' . urlencode($related['id']);
                    $relatedHasSalePrice = !empty($related['sale_price']) && $related['sale_price'] > 0;
                    ?>

                    <div class="carousel-item w-44 sm:w-56">
                        <div class="client-card client-card-hover overflow-hidden w-full">
                            <a href="<?= $relatedDetailUrl ?>">
                                <div class="h-32 bg-green-50">
                                    <?php if (clientImageExists($related['image'] ?? '')): ?>
                                        <img src="<?= htmlspecialchars($related['image']) ?>"
                                            alt="<?= htmlspecialchars($related['name']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-5xl">🍏</div>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <div class="p-3">
                                <a href="<?= $relatedDetailUrl ?>">
                                    <h3
                                        class="font-bold text-sm leading-5 h-10 overflow-hidden hover:text-green-700 transition text-slate-950">
                                        <?= htmlspecialchars($related['name']) ?>
                                    </h3>
                                </a>

                                <?php if ($relatedHasSalePrice): ?>
                                    <p class="font-extrabold text-rose-500 text-sm mt-2">
                                        <?= number_format($related['sale_price']) ?>đ
                                    </p>

                                    <p class="text-xs text-slate-400 line-through">
                                        <?= number_format($related['price']) ?>đ
                                    </p>
                                <?php else: ?>
                                    <p class="font-extrabold text-green-700 text-sm mt-2">
                                        <?= number_format($related['price']) ?>đ
                                    </p>
                                <?php endif; ?>

                                <a href="<?= $relatedDetailUrl ?>"
                                    class="h-8 rounded-full border border-slate-200 hover:bg-green-50 text-slate-800 inline-flex items-center justify-center text-xs font-bold transition w-full mt-3">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="client-card p-10 text-center text-slate-500">
                Chưa có sản phẩm liên quan.
            </div>
        <?php endif; ?>
    </div>
</section>