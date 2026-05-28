<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Sửa danh mục') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Cập nhật thông tin danh mục.
            </p>
        </div>

        <a href="index.php?area=admin&controller=category&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=category&action=update" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

        <div class="xl:col-span-2">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thông tin danh mục</h3>
                        <p class="text-sm text-slate-500 mt-1">Cập nhật tên, mô tả và trạng thái.</p>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Tên danh mục</span>
                        </label>
                        <input type="text" name="name"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                            value="<?= htmlspecialchars($category['name'] ?? '') ?>">
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
                        <textarea name="description"
                            class="textarea textarea-bordered rounded-2xl min-h-36"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Trạng thái</span>
                        </label>
                        <select name="status" class="select select-bordered rounded-2xl w-full">
                            <option value="active" <?= ($category['status'] ?? '') === 'active' ? 'selected' : '' ?>>
                                Active</option>
                            <option value="hidden" <?= ($category['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>
                                Hidden</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="index.php?area=admin&controller=category&action=index"
                            class="btn btn-ghost rounded-2xl">
                            Hủy
                        </a>

                        <button type="submit"
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl">
                            Cập nhật danh mục
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
            <div class="card-body space-y-4">
                <h3 class="text-xl font-extrabold text-slate-900">Thông tin hiện tại</h3>

                <div>
                    <p class="text-sm text-slate-500">ID</p>
                    <p class="font-bold">#<?= htmlspecialchars($category['id']) ?></p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Slug</p>
                    <p class="font-semibold break-all"><?= htmlspecialchars($category['slug'] ?? '') ?></p>
                </div>

                <div>
                    <p class="text-sm text-slate-500">Ảnh hiện tại</p>
                    <?php if (!empty($category['image'])): ?>
                        <img src="<?= htmlspecialchars($category['image']) ?>"
                            alt="<?= htmlspecialchars($category['name']) ?>"
                            class="rounded-3xl border border-slate-200 mt-2 w-full max-h-64 object-cover">
                    <?php else: ?>
                        <div
                            class="rounded-3xl bg-slate-50 border border-slate-200 h-48 flex flex-col items-center justify-center text-slate-400 mt-2">
                            <div class="text-3xl">🖼️</div>
                            <p class="text-sm mt-2">Chưa có ảnh</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="label">
                        <span class="label-text font-semibold">Đổi ảnh</span>
                    </label>
                    <input type="file" name="image" class="file-input file-input-bordered rounded-2xl w-full"
                        accept="image/*">
                </div>
            </div>
        </div>
    </form>
</div>