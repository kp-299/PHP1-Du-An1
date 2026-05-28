<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Sửa video') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Cập nhật thông tin, file, URL và trạng thái video.
            </p>
        </div>

        <a href="index.php?area=admin&controller=video&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <form action="index.php?area=admin&controller=video&action=update" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <input type="hidden" name="id" value="<?= htmlspecialchars($video['id']) ?>">

        <div class="2xl:col-span-2 space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">Thông tin video</h3>
                        <p class="text-sm text-slate-500 mt-1">Cập nhật tiêu đề, loại video và mô tả.</p>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Tiêu đề</span>
                        </label>

                        <input type="text" name="title"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['title']) ? 'input-error' : '' ?>"
                            value="<?= htmlspecialchars($video['title'] ?? '') ?>">

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
                                <option value="short" <?= ($video['video_type'] ?? '') === 'short' ? 'selected' : '' ?>>
                                    Video ngắn
                                </option>
                                <option value="long" <?= ($video['video_type'] ?? '') === 'long' ? 'selected' : '' ?>>
                                    Video dài
                                </option>
                            </select>
                        </div>

                        <div class="w-full">
                            <label class="block mb-2">
                                <span class="text-sm font-semibold text-slate-700">Thời lượng</span>
                            </label>

                            <input type="number" name="duration" class="input input-bordered rounded-2xl w-full"
                                value="<?= htmlspecialchars($video['duration'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">URL video ngoài</span>
                        </label>

                        <input type="text" name="video_url" class="input input-bordered rounded-2xl w-full"
                            value="<?= htmlspecialchars($video['video_url'] ?? '') ?>">
                    </div>

                    <div class="w-full">
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Mô tả</span>
                        </label>

                        <textarea name="description"
                            class="textarea textarea-bordered rounded-2xl min-h-56 w-full"><?= htmlspecialchars($video['description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Video hiện tại</h3>

                    <?php if (!empty($video['video_file'])): ?>
                    <video controls class="w-full rounded-3xl border border-slate-200">
                        <source src="<?= htmlspecialchars($video['video_file']) ?>">
                        Trình duyệt không hỗ trợ video.
                    </video>
                    <?php elseif (!empty($video['video_url'])): ?>
                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <p class="text-sm text-slate-500 mb-2">URL video</p>
                        <a href="<?= htmlspecialchars($video['video_url']) ?>" target="_blank"
                            class="text-sky-600 font-semibold break-all">
                            <?= htmlspecialchars($video['video_url']) ?>
                        </a>
                    </div>
                    <?php else: ?>
                    <div
                        class="rounded-3xl bg-pink-50 border border-slate-200 h-56 flex flex-col items-center justify-center text-slate-400">
                        <div class="text-5xl">🎬</div>
                        <p class="text-sm mt-2">Chưa có video</p>
                    </div>
                    <?php endif; ?>

                    <div>
                        <label class="block mb-2">
                            <span class="text-sm font-semibold text-slate-700">Đổi file video</span>
                        </label>

                        <input type="file" name="video_file"
                            class="file-input file-input-bordered rounded-2xl w-full <?= !empty($errors['video_file']) ? 'file-input-error' : '' ?>"
                            accept="video/*">

                        <?php if (!empty($errors['video_file'])): ?>
                        <p class="text-error text-sm mt-2"><?= htmlspecialchars($errors['video_file']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Thumbnail</h3>

                    <?php if (!empty($video['thumbnail'])): ?>
                    <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                        alt="<?= htmlspecialchars($video['title']) ?>"
                        class="rounded-3xl border border-slate-200 w-full max-h-56 object-cover">
                    <?php else: ?>
                    <div
                        class="rounded-3xl bg-slate-50 border border-slate-200 h-40 flex flex-col items-center justify-center text-slate-400">
                        <div class="text-4xl">🖼️</div>
                        <p class="text-sm mt-2">Chưa có thumbnail</p>
                    </div>
                    <?php endif; ?>

                    <input type="file" name="thumbnail" class="file-input file-input-bordered rounded-2xl w-full"
                        accept="image/*">
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Trạng thái</h3>

                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="draft" <?= ($video['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft
                        </option>
                        <option value="published" <?= ($video['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                            Published</option>
                        <option value="hidden" <?= ($video['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                        </option>
                    </select>
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold">Hành động</h3>

                    <div class="flex flex-col gap-3 mt-4">
                        <button type="submit"
                            class="btn bg-white text-green-700 border-white hover:bg-slate-100 rounded-2xl">
                            Cập nhật video
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