<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Chi tiết sản phẩm') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Xem thông tin chi tiết sản phẩm.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="index.php?area=admin&controller=product&action=edit&id=<?= $product['id'] ?>"
                class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl">
                Sửa sản phẩm
            </a>

            <a href="index.php?area=admin&controller=product&action=index" class="btn btn-outline rounded-2xl">
                ← Quay lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl 2xl:col-span-2">
            <div class="card-body space-y-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900">
                            <?= htmlspecialchars($product['name']) ?>
                        </h2>
                        <p class="text-slate-500 mt-1">
                            <?= htmlspecialchars($product['slug']) ?>
                        </p>
                    </div>

                    <?php if ($product['status'] === 'active'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">active</span>
                    <?php elseif ($product['status'] === 'hidden'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">hidden</span>
                    <?php else: ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">out_of_stock</span>
                    <?php endif; ?>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500">Giá bán</p>
                        <p class="text-2xl font-extrabold mt-2">
                            <?= number_format($product['price']) ?>đ
                        </p>
                    </div>

                    <div class="rounded-3xl bg-rose-50 border border-rose-100 p-5">
                        <p class="text-sm text-rose-500">Giá sale</p>
                        <p class="text-2xl font-extrabold mt-2 text-rose-600">
                            <?= !empty($product['sale_price']) ? number_format($product['sale_price']) . 'đ' : '-' ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-green-50 border border-green-100 p-5">
                        <p class="text-sm text-green-600">Tồn kho</p>
                        <p class="text-2xl font-extrabold mt-2 text-green-700">
                            <?= $product['stock'] ?> <?= htmlspecialchars($product['unit']) ?>
                        </p>
                    </div>

                    <div class="rounded-3xl bg-sky-50 border border-sky-100 p-5">
                        <p class="text-sm text-sky-600">Danh mục</p>
                        <p class="font-extrabold mt-2 text-sky-700">
                            <?= htmlspecialchars($product['category_name'] ?? 'Không có') ?>
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-3">
                        Mô tả sản phẩm
                    </h3>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5 text-slate-600 leading-7">
                        <?= nl2br(htmlspecialchars($product['description'] ?? 'Chưa có mô tả.')) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Ảnh sản phẩm
                    </h3>

                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="rounded-3xl border border-slate-200 w-full object-cover">
                    <?php else: ?>
                        <div
                            class="rounded-3xl bg-green-50 border border-slate-200 h-72 flex flex-col items-center justify-center text-slate-400">
                            <div class="text-6xl">🍎</div>
                            <p class="text-sm mt-3">Chưa có ảnh</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Thao tác nhanh
                    </h3>

                    <?php if ($product['status'] === 'active'): ?>
                        <a href="index.php?area=admin&controller=product&action=hide&id=<?= $product['id'] ?>"
                            class="btn bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-2xl w-full">
                            Ẩn sản phẩm
                        </a>
                    <?php else: ?>
                        <a href="index.php?area=admin&controller=product&action=active&id=<?= $product['id'] ?>"
                            class="btn bg-green-500 hover:bg-green-600 border-0 text-white rounded-2xl w-full">
                            Hiện sản phẩm
                        </a>
                    <?php endif; ?>

                    <a href="index.php?area=admin&controller=product&action=outOfStock&id=<?= $product['id'] ?>"
                        class="btn bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-2xl w-full">
                        Đánh dấu hết hàng
                    </a>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-3">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Thông tin hệ thống
                    </h3>

                    <div>
                        <p class="text-sm text-slate-500">ID</p>
                        <p class="font-bold">#<?= htmlspecialchars($product['id']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Ngày tạo</p>
                        <p><?= htmlspecialchars($product['created_at'] ?? '') ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Cập nhật</p>
                        <p><?= htmlspecialchars($product['updated_at'] ?? '') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>