<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Thêm danh mục') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Tạo danh mục mới để phân loại sản phẩm.
            </p>
        </div>

        <a href="index.php?area=admin&controller=category&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=category&action=store" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thông tin danh mục</h3>
                        <p class="text-sm text-slate-500 mt-1">Nhập tên, mô tả và trạng thái.</p>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Tên danh mục</span>
                        </label>
                        <input type="text" name="name" placeholder="Ví dụ: Trái cây nhập khẩu"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                            value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                        <?php if (!empty($errors['name'])): ?>
                            <label class="label">
                                <span class="label-text-alt text-error"><?= htmlspecialchars($errors['name']) ?></span>
                            </label>
                        <?php endif; ?>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Mô tả</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered rounded-2xl min-h-36"
                            placeholder="Nhập mô tả ngắn cho danh mục..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Trạng thái</span>
                        </label>
                        <select name="status" class="select select-bordered rounded-2xl w-full">
                            <option value="active" <?= ($old['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active
                            </option>
                            <option value="hidden" <?= ($old['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Ảnh danh mục</h3>
                        <p class="text-sm text-slate-500 mt-1">Upload ảnh đại diện danh mục.</p>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <div class="text-4xl mb-2">🖼️</div>
                        <p class="font-bold">Chọn ảnh danh mục</p>
                        <p class="text-sm text-slate-500 mt-1">jpg, png, webp</p>
                    </div>

                    <input type="file" name="image" class="file-input file-input-bordered rounded-2xl w-full"
                        accept="image/*">
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold">Hành động</h3>
                    <p class="text-sm text-white/80">Kiểm tra thông tin trước khi lưu.</p>

                    <div class="flex flex-col gap-3 mt-4">
                        <button type="submit"
                            class="btn bg-white text-green-700 border-white hover:bg-slate-100 rounded-2xl">
                            Thêm danh mục
                        </button>

                        <a href="index.php?area=admin&controller=category&action=index"
                            class="btn btn-outline border-white text-white hover:bg-white hover:text-green-700 rounded-2xl">
                            Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>