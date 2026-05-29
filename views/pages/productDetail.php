<?php
$images = [];

if (!empty($product['image'])) {
    $images[] = $product['image'];
}

if (!empty($productImages)) {
    foreach ($productImages as $img) {
        if (!empty($img['image'])) {
            $images[] = $img['image'];
        }

        if (!empty($img['image_path'])) {
            $images[] = $img['image_path'];
        }
    }
}

$images = array_values(array_unique($images));

if (empty($images)) {
    $images = [
        '',
        '',
        '',
    ];
}

$currentPrice = (!empty($product['sale_price']) && $product['sale_price'] > 0)
    ? $product['sale_price']
    : $product['price'];
?>

<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
    <div class="mb-6">
        <a href="index.php?area=client&controller=product&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại sản phẩm
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
        <!-- Images carousel -->
        <div>
            <div class="carousel w-full rounded-[2rem] overflow-hidden bg-white border border-slate-200 shadow-sm">
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
                            <a href="#<?= $prevId ?>" class="btn btn-circle">❮</a>
                            <a href="#<?= $nextId ?>" class="btn btn-circle">❯</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-4 gap-3 mt-4">
                <?php foreach ($images as $index => $image): ?>
                    <a href="#product-img-<?= $index + 1 ?>"
                        class="h-20 rounded-2xl overflow-hidden bg-green-50 border border-slate-200">
                        <?php if (!empty($image)): ?>
                            <img src="<?= htmlspecialchars($image) ?>" class="w-full h-full object-cover" alt="">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-3xl">🍏</div>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Product info -->
        <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-8 h-fit">
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="badge bg-green-100 text-green-700 border-0">
                    <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                </span>

                <?php if (($product['stock'] ?? 0) > 0): ?>
                    <span class="badge bg-sky-100 text-sky-700 border-0">Còn hàng</span>
                <?php else: ?>
                    <span class="badge bg-rose-100 text-rose-700 border-0">Hết hàng</span>
                <?php endif; ?>
            </div>

            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                <?= htmlspecialchars($product['name']) ?>
            </h1>

            <p class="text-slate-500 mt-4">
                Mã sản phẩm: #<?= htmlspecialchars($product['id']) ?>
            </p>

            <div class="mt-6">
                <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
                    <p class="text-4xl font-extrabold text-rose-500">
                        <?= number_format($product['sale_price']) ?>đ
                    </p>

                    <p class="text-xl text-slate-400 line-through mt-1">
                        <?= number_format($product['price']) ?>đ
                    </p>
                <?php else: ?>
                    <p class="text-4xl font-extrabold text-green-600">
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
                    <p class="text-2xl font-extrabold"><?= htmlspecialchars($product['stock'] ?? 0) ?></p>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-4">
                    <p class="text-sm text-slate-500">Trạng thái</p>
                    <p class="text-lg font-extrabold">
                        <?= (($product['stock'] ?? 0) > 0) ? 'Có thể mua' : 'Tạm hết' ?>
                    </p>
                </div>
            </div>

            <form action="index.php?area=client&controller=cart&action=add" method="POST" class="mt-8 space-y-4">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                <div>
                    <label class="block mb-2 text-sm font-semibold text-slate-700">Số lượng</label>
                    <input type="number" name="quantity" min="1" value="1"
                        class="input input-bordered rounded-2xl w-full"
                        <?= (($product['stock'] ?? 0) <= 0) ? 'disabled' : '' ?>>
                </div>

                <button
                    class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl w-full"
                    <?= (($product['stock'] ?? 0) <= 0) ? 'disabled' : '' ?>>
                    Thêm vào giỏ hàng
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
</section>

<!-- Description -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
    <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-8">
        <h2 class="text-3xl font-extrabold text-slate-950 mb-5">
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
</section>

<!-- Related products -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-12">
    <div class="flex items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-950">
                Sản phẩm liên quan
            </h2>
            <p class="text-slate-500 mt-2">
                Các sản phẩm cùng danh mục.
            </p>
        </div>
    </div>

    <?php if (!empty($relatedProducts)): ?>
        <div class="carousel carousel-center w-full space-x-4 rounded-box">
            <?php foreach ($relatedProducts as $related): ?>
                <div class="carousel-item w-44 sm:w-56">
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden w-full">
                        <a href="index.php?area=client&controller=product&action=detail&id=<?= urlencode($related['id']) ?>">
                            <div class="h-32 bg-green-50">
                                <?php if (!empty($related['image'])): ?>
                                    <img src="<?= htmlspecialchars($related['image']) ?>"
                                        alt="<?= htmlspecialchars($related['name']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-5xl">🍏</div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="p-3">
                            <h3 class="font-bold text-sm leading-5 h-10 overflow-hidden">
                                <?= htmlspecialchars($related['name']) ?>
                            </h3>

                            <?php if (!empty($related['sale_price']) && $related['sale_price'] > 0): ?>
                                <p class="font-extrabold text-rose-500 text-sm mt-2">
                                    <?= number_format($related['sale_price']) ?>đ
                                </p>
                            <?php else: ?>
                                <p class="font-extrabold text-green-600 text-sm mt-2">
                                    <?= number_format($related['price']) ?>đ
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có sản phẩm liên quan.
        </div>
    <?php endif; ?>
</section>