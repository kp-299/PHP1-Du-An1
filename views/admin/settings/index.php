<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            <?= htmlspecialchars($title ?? 'Cài đặt website') ?>
        </h1>
        <p class="text-slate-500 mt-2">
            Quản lý logo, banner, màu chủ đạo và nội dung hiển thị trên website.
        </p>
    </div>

    <form action="index.php?area=admin&controller=setting&action=update" method="POST" enctype="multipart/form-data"
        class="space-y-6">
        <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl 2xl:col-span-2">
                <div class="card-body space-y-6">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thông tin website</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Các nội dung cơ bản được dùng ở client.
                        </p>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Tên website</span>
                        </label>
                        <input type="text" name="site_name" class="input input-bordered rounded-2xl w-full"
                            value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" placeholder="Trái Cây Tươi">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Thông báo trang chủ</span>
                        </label>
                        <input type="text" name="homepage_notice" class="input input-bordered rounded-2xl w-full"
                            value="<?= htmlspecialchars($settings['homepage_notice'] ?? '') ?>"
                            placeholder="Giảm giá 20% hôm nay...">
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Footer content</span>
                        </label>

                        <textarea name="footer_content"
                            class="textarea textarea-bordered rounded-2xl min-h-32 w-full block"
                            placeholder="© 2026 Trái Cây Tươi"><?= htmlspecialchars($settings['footer_content'] ?? '') ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Màu chủ đạo</span>
                            </label>
                            <input type="color" name="primary_color"
                                class="input input-bordered rounded-2xl w-full h-14"
                                value="<?= htmlspecialchars($settings['primary_color'] ?? '#16a34a') ?>">
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Font family</span>
                            </label>
                            <input type="text" name="font_family" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($settings['font_family'] ?? 'Inter, sans-serif') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                    <div class="card-body space-y-4">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">Logo</h3>
                            <p class="text-sm text-slate-500 mt-1">Ảnh logo website.</p>
                        </div>

                        <?php if (!empty($settings['logo'])): ?>
                        <div
                            class="rounded-3xl bg-slate-50 border border-slate-200 p-5 flex items-center justify-center">
                            <img src="<?= htmlspecialchars($settings['logo']) ?>" alt="Logo"
                                class="max-h-36 object-contain">
                        </div>
                        <?php else: ?>
                        <div
                            class="rounded-3xl bg-slate-50 border border-slate-200 h-36 flex flex-col items-center justify-center text-slate-400">
                            <div class="text-3xl">🖼️</div>
                            <p class="text-sm mt-2">Chưa có logo</p>
                        </div>
                        <?php endif; ?>

                        <input type="file" name="logo" class="file-input file-input-bordered rounded-2xl w-full"
                            accept="image/*">
                    </div>
                </div>

                <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                    <div class="card-body space-y-4">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">Banner</h3>
                            <p class="text-sm text-slate-500 mt-1">Ảnh banner trang chủ.</p>
                        </div>

                        <?php if (!empty($settings['banner'])): ?>
                        <div class="rounded-3xl bg-slate-50 border border-slate-200 overflow-hidden">
                            <img src="<?= htmlspecialchars($settings['banner']) ?>" alt="Banner"
                                class="w-full max-h-44 object-cover">
                        </div>
                        <?php else: ?>
                        <div
                            class="rounded-3xl bg-slate-50 border border-slate-200 h-44 flex flex-col items-center justify-center text-slate-400">
                            <div class="text-3xl">🌄</div>
                            <p class="text-sm mt-2">Chưa có banner</p>
                        </div>
                        <?php endif; ?>

                        <input type="file" name="banner" class="file-input file-input-bordered rounded-2xl w-full"
                            accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
            <div class="card-body">
                <div class="flex justify-end gap-3">
                    <a href="index.php?area=admin&controller=dashboard&action=index" class="btn btn-ghost rounded-2xl">
                        Hủy
                    </a>

                    <button type="submit"
                        class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
                        Lưu cài đặt
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>