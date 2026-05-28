<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Quản lý sản phẩm') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Quản lý danh sách sản phẩm, giá bán, tồn kho và trạng thái hiển thị.
            </p>
        </div>

        <a href="index.php?area=admin&controller=product&action=create"
            class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
            + Thêm sản phẩm
        </a>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="product">
                <input type="hidden" name="action" value="index">

                <div class="xl:col-span-4">
                    <input type="text" name="keyword" placeholder="Tìm theo tên sản phẩm..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                </div>

                <div class="xl:col-span-3">
                    <select name="category_id" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả danh mục</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"
                                    <?= ($filters['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="xl:col-span-3">
                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active
                        </option>
                        <option value="hidden" <?= ($filters['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                        </option>
                        <option value="out_of_stock"
                            <?= ($filters['status'] ?? '') === 'out_of_stock' ? 'selected' : '' ?>>Hết hàng</option>
                    </select>
                </div>

                <div class="xl:col-span-1">
                    <button type="submit"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                        Lọc
                    </button>
                </div>

                <div class="xl:col-span-1">
                    <a href="index.php?area=admin&controller=product&action=index"
                        class="btn btn-outline rounded-2xl w-full">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Danh sách sản phẩm
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Theo dõi sản phẩm đang bán trên website.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($products) ? count($products) : 0 ?> sản phẩm
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Sale</th>
                            <th>Kho</th>
                            <th>Trạng thái</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr class="hover">
                                    <td class="font-bold">#<?= $product['id'] ?></td>

                                    <td>
                                        <?php if (!empty($product['image'])): ?>
                                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                                alt="<?= htmlspecialchars($product['name']) ?>"
                                                class="w-16 h-16 rounded-2xl object-cover border border-slate-200">
                                        <?php else: ?>
                                            <div
                                                class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center text-3xl">
                                                🍎
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="font-bold text-slate-900">
                                            <?= htmlspecialchars($product['name']) ?>
                                        </div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            <?= htmlspecialchars($product['slug']) ?>
                                        </div>
                                    </td>

                                    <td class="text-slate-600">
                                        <?= htmlspecialchars($product['category_name'] ?? 'Không có') ?>
                                    </td>

                                    <td class="font-bold">
                                        <?= number_format($product['price']) ?>đ
                                    </td>

                                    <td>
                                        <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
                                            <span class="font-bold text-rose-500">
                                                <?= number_format($product['sale_price']) ?>đ
                                            </span>
                                        <?php else: ?>
                                            <span class="text-slate-400">-</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <span class="font-bold"><?= $product['stock'] ?></span>
                                        <span class="text-xs text-slate-500"><?= htmlspecialchars($product['unit']) ?></span>
                                    </td>

                                    <td>
                                        <?php if ($product['status'] === 'active'): ?>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">active</span>
                                        <?php elseif ($product['status'] === 'hidden'): ?>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">hidden</span>
                                        <?php else: ?>
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">out_of_stock</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <a href="index.php?area=admin&controller=product&action=detail&slug=<?= urlencode($product['slug']) ?>"
                                                class="btn btn-sm bg-sky-500 hover:bg-sky-600 border-0 text-white rounded-xl">
                                                Xem
                                            </a>

                                            <a href="index.php?area=admin&controller=product&action=edit&id=<?= $product['id'] ?>"
                                                class="btn btn-sm btn-outline rounded-xl">
                                                Sửa
                                            </a>

                                            <?php if ($product['status'] === 'active'): ?>
                                                <a href="index.php?area=admin&controller=product&action=hide&id=<?= $product['id'] ?>"
                                                    class="btn btn-sm bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-xl">
                                                    Ẩn
                                                </a>
                                            <?php else: ?>
                                                <a href="index.php?area=admin&controller=product&action=active&id=<?= $product['id'] ?>"
                                                    class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white rounded-xl">
                                                    Hiện
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9">
                                    <div class="py-16 text-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-green-50 flex items-center justify-center text-3xl mx-auto">
                                            🍏
                                        </div>

                                        <p class="font-bold mt-4">Chưa có sản phẩm nào</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Hãy thêm sản phẩm đầu tiên cho website.
                                        </p>

                                        <a href="index.php?area=admin&controller=product&action=create"
                                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl mt-4">
                                            + Thêm sản phẩm
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>