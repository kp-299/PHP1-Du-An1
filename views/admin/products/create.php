<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Thêm sản phẩm') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Tạo sản phẩm mới để hiển thị trên website bán trái cây.
            </p>
        </div>

        <a href="index.php?area=admin&controller=product&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=product&action=store" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="2xl:col-span-2 space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Thông tin cơ bản
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Nhập tên, danh mục và mô tả sản phẩm.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                        <div class="form-control xl:col-span-2">
                            <label class="label">
                                <span class="label-text font-semibold">Tên sản phẩm</span>
                            </label>

                            <input type="text" name="name" placeholder="Ví dụ: Cam sành"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                                value="<?= htmlspecialchars($old['name'] ?? '') ?>">

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
                                            <?= ($old['category_id'] ?? '') == $category['id'] ? 'selected' : '' ?>>
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

                            <textarea name="description" class="textarea textarea-bordered rounded-2xl min-h-40"
                                placeholder="Nhập mô tả sản phẩm..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
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
                            Thiết lập giá bán, giá khuyến mãi và số lượng tồn.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Giá bán</span>
                            </label>

                            <input type="number" name="price"
                                class="input input-bordered rounded-2xl w-full <?= !empty($errors['price']) ? 'input-error' : '' ?>"
                                value="<?= htmlspecialchars($old['price'] ?? '') ?>">

                            <?php if (!empty($errors['price'])): ?>
                                <label class="label">
                                    <span class="label-text-alt text-error">
                                        <?= htmlspecialchars($errors['price']) ?>
                                    </span>
                                </label>
                            <?php endif; ?>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Giá sale</span>
                            </label>

                            <input type="number" name="sale_price" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($old['sale_price'] ?? '') ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Tồn kho</span>
                            </label>

                            <input type="number" name="stock" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($old['stock'] ?? 0) ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Đơn vị</span>
                            </label>

                            <input type="text" name="unit" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($old['unit'] ?? 'kg') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Ảnh sản phẩm
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Upload ảnh đại diện sản phẩm.
                        </p>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <div class="text-5xl mb-3">🖼️</div>
                        <p class="font-bold">Chọn ảnh sản phẩm</p>
                        <p class="text-sm text-slate-500 mt-1">
                            Hỗ trợ jpg, png, webp.
                        </p>
                    </div>

                    <input type="file" name="image" class="file-input file-input-bordered rounded-2xl w-full"
                        accept="image/*">
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Trạng thái
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Chọn trạng thái hiển thị.
                        </p>
                    </div>

                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="active" <?= ($old['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active
                        </option>
                        <option value="hidden" <?= ($old['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                        </option>
                        <option value="out_of_stock" <?= ($old['status'] ?? '') === 'out_of_stock' ? 'selected' : '' ?>>
                            Hết hàng</option>
                    </select>
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold">Hành động</h3>
                    <p class="text-sm text-white/80">
                        Kiểm tra lại thông tin trước khi tạo sản phẩm.
                    </p>

                    <div class="flex flex-col gap-3 mt-4">
                        <button type="submit"
                            class="btn bg-white text-green-700 border-white hover:bg-slate-100 rounded-2xl">
                            Thêm sản phẩm
                        </button>

                        <a href="index.php?area=admin&controller=product&action=index"
                            class="btn btn-outline border-white text-white hover:bg-white hover:text-green-700 rounded-2xl">
                            Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>