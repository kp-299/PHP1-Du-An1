<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Thêm video') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Tạo video ngắn hoặc video dài để hiển thị trên website.
            </p>
        </div>

        <a href="index.php?area=admin&controller=video&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=video&action=store" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="2xl:col-span-2 space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thông tin video</h3>
                        <p class="text-sm text-slate-500 mt-1">Nhập tiêu đề, loại video và mô tả.</p>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Tiêu đề</span>
                        </label>

                        <input type="text" name="title"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['title']) ? 'input-error' : '' ?>"
                            placeholder="Ví dụ: Video giới thiệu trái cây tươi"
                            value="<?= htmlspecialchars($old['title'] ?? '') ?>">

                        <?php if (!empty($errors['title'])): ?>
                        <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['title']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="w-full">
                            <label class="block mb-2">
                                <span class="text-sm font-semibold text-slate-700">Loại video</span>
                            </label>

                            <select name="video_type" class="select select-bordered rounded-2xl w-full">
                                <option value="short" <?= ($old['video_type'] ?? '') === 'short' ? 'selected' : '' ?>>
                                    Video ngắn
                                </option>
                                <option value="long" <?= ($old['video_type'] ?? '') === 'long' ? 'selected' : '' ?>>
                                    Video dài
                                </option>
                            </select>
                        </div>

                        <div class="w-full">
                            <label class="block mb-2">
                                <span class="text-sm font-semibold text-slate-700">Thời lượng</span>
                            </label>

                            <input type="number" name="duration" class="input input-bordered rounded-2xl w-full"
                                placeholder="Ví dụ: 120 giây" value="<?= htmlspecialchars($old['duration'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">URL video ngoài</span>
                        </label>

                        <input type="text" name="video_url" class="input input-bordered rounded-2xl w-full"
                            placeholder="YouTube/TikTok/Facebook URL nếu không upload file"
                            value="<?= htmlspecialchars($old['video_url'] ?? '') ?>">
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Mô tả</span>
                        </label>

                        <textarea name="description" class="textarea textarea-bordered rounded-2xl min-h-56 w-full"
                            placeholder="Nhập mô tả video..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">File video</h3>
                        <p class="text-sm text-slate-500 mt-1">Upload file mp4, webm, ogg hoặc mov.</p>
                    </div>

                    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-8 text-center">
                        <div class="text-5xl mb-3">🎬</div>
                        <p class="font-bold">Chọn file video</p>
                        <p class="text-sm text-slate-500 mt-1">Tối đa theo cấu hình upload server.</p>
                    </div>

                    <label class="block mb-2">
                        <span class="text-sm font-semibold text-slate-700">Link YouTube</span>
                    </label>

                    <input type="text" name="video_url"
                        class="input input-bordered rounded-2xl w-full <?= !empty($errors['video_url']) ? 'input-error' : '' ?>"
                        placeholder="https://www.youtube.com/watch?v=... hoặc https://youtube.com/shorts/..."
                        value="<?= htmlspecialchars($old['video_url'] ?? '') ?>">

                    <?php if (!empty($errors['video_url'])): ?>
                    <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['video_url']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thumbnail</h3>
                        <p class="text-sm text-slate-500 mt-1">Ảnh đại diện video.</p>
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
                    <p class="text-sm text-white/80">
                        Có thể upload file hoặc nhập URL video ngoài.
                    </p>

                    <div class="flex flex-col gap-3 mt-4">
                        <button type="submit"
                            class="btn bg-white text-green-700 border-white hover:bg-slate-100 rounded-2xl">
                            Thêm video
                        </button>

                        <a href="index.php?area=admin&controller=video&action=index"
                            class="btn btn-outline border-white text-white hover:bg-white hover:text-green-700 rounded-2xl">
                            Hủy
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>