<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Thêm bài viết') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Tạo bài viết mới để hiển thị trên website.
            </p>
        </div>

        <a href="index.php?area=admin&controller=post&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=post&action=store" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="2xl:col-span-2 space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thông tin bài viết</h3>
                        <p class="text-sm text-slate-500 mt-1">Nhập tiêu đề, tóm tắt và nội dung chính.</p>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Tiêu đề</span>
                        </label>

                        <input type="text" name="title"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['title']) ? 'input-error' : '' ?>"
                            placeholder="Ví dụ: Cách chọn trái cây tươi ngon"
                            value="<?= htmlspecialchars($old['title'] ?? '') ?>">

                        <?php if (!empty($errors['title'])): ?>
                        <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['title']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Tóm tắt</span>
                        </label>

                        <textarea name="summary" class="textarea textarea-bordered rounded-2xl min-h-28 w-full"
                            placeholder="Nhập tóm tắt ngắn..."><?= htmlspecialchars($old['summary'] ?? '') ?></textarea>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Nội dung</span>
                        </label>

                        <textarea name="content"
                            class="textarea textarea-bordered rounded-2xl min-h-72 w-full <?= !empty($errors['content']) ? 'textarea-error' : '' ?>"
                            placeholder="Nhập nội dung chi tiết bài viết..."><?= htmlspecialchars($old['content'] ?? '') ?></textarea>

                        <?php if (!empty($errors['content'])): ?>
                        <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['content']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Ảnh đại diện</h3>
                        <p class="text-sm text-slate-500 mt-1">Upload thumbnail bài viết.</p>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <div class="text-5xl mb-3">🖼️</div>
                        <p class="font-bold">Chọn ảnh bài viết</p>
                        <p class="text-sm text-slate-500 mt-1">jpg, png, webp</p>
                    </div>

                    <input type="file" name="thumbnail" class="file-input file-input-bordered rounded-2xl w-full"
                        accept="image/*">
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Trạng thái</h3>

                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="draft" <?= ($old['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= ($old['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                            Published</option>
                        <option value="hidden" <?= ($old['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                        </option>
                    </select>
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold">Hành động</h3>
                    <p class="text-sm text-white/80">Kiểm tra nội dung trước khi lưu.</p>

                    <div class="flex flex-col gap-3 mt-4">
                        <button type="submit"
                            class="btn bg-white text-green-700 border-white hover:bg-slate-100 rounded-2xl">
                            Thêm bài viết
                        </button>

                        <a href="index.php?area=admin&controller=post&action=index"
                            class="btn btn-outline border-white text-white hover:bg-white hover:text-green-700 rounded-2xl">
                            Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>