<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Sửa sản phẩm') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Cập nhật thông tin, giá bán, tồn kho và trạng thái sản phẩm.
            </p>
        </div>

        <a href="index.php?area=admin&controller=product&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=product&action=update" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

        <div class="2xl:col-span-2 space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Thông tin cơ bản
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Cập nhật tên, danh mục và mô tả.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                        <div class="form-control xl:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold">Tên sản phẩm</span>
                            </label>

                            <input type="text" name="name"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                                value="<?= htmlspecialchars($product['name'] ?? '') ?>">

                            <?php if (!empty($errors['name'])): ?>
                                <label class="label">
                                    <span class="label-text-alt text-error">
                                        <?= htmlspecialchars($errors['name']) ?>
                                    </span>
                                </label>
                            <?php endif; ?>
                        </div>

                        <div class="form-control xl:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold">Danh mục</span>
                            </label>

                            <select name="category_id" class="select select-bordered rounded-2xl w-full">
                                <option value="">Chọn danh mục</option>

                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"
                                            <?= ($product['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-control xl:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold">Mô tả</span>
                            </label>

                            <textarea name="description"
                                class="textarea textarea-bordered rounded-2xl min-h-40"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Giá và tồn kho
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Điều chỉnh giá bán, giá sale và số lượng kho.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Giá bán</span>
                            </label>
                            <input type="number" name="price"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['price']) ? 'input-error' : '' ?>"
                                value="<?= htmlspecialchars($product['price'] ?? '') ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Giá sale</span>
                            </label>
                            <input type="number" name="sale_price" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($product['sale_price'] ?? '') ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Tồn kho</span>
                            </label>
                            <input type="number" name="stock" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($product['stock'] ?? 0) ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Đơn vị</span>
                            </label>
                            <input type="text" name="unit" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($product['unit'] ?? 'kg') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <div class="flex justify-end gap-3">
                        <a href="index.php?area=admin&controller=product&action=index"
                            class="btn btn-ghost rounded-2xl">
                            Hủy
                        </a>

                        <button type="submit"
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
                            Cập nhật sản phẩm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Ảnh hiện tại
                    </h3>

                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="rounded-3xl border border-slate-200 w-full max-h-72 object-cover">
                    <?php else: ?>
                        <div
                            class="rounded-3xl bg-green-50 border border-slate-200 h-56 flex flex-col items-center justify-center text-slate-400">
                            <div class="text-5xl">🍎</div>
                            <p class="text-sm mt-2">Chưa có ảnh</p>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label class="label">
                            <span class="label-text font-semibold">Đổi ảnh</span>
                        </label>

                        <input type="file" name="image" class="file-input file-input-bordered rounded-2xl w-full"
                            accept="image/*">

                        <p class="text-xs text-slate-500 mt-2">
                            Bỏ trống nếu không muốn đổi ảnh.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Thông tin hiện tại
                    </h3>

                    <div>
                        <p class="text-sm text-slate-500">ID</p>
                        <p class="font-bold">#<?= htmlspecialchars($product['id']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Slug</p>
                        <p class="font-semibold break-all">
                            <?= htmlspecialchars($product['slug'] ?? '') ?>
                        </p>
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

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Trạng thái
                    </h3>

                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="active" <?= ($product['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active
                        </option>
                        <option value="hidden" <?= ($product['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                        </option>
                        <option value="out_of_stock"
                            <?= ($product['status'] ?? '') === 'out_of_stock' ? 'selected' : '' ?>>Hết hàng</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>