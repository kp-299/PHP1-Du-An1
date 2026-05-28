<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Chi tiết video') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Xem thông tin chi tiết video.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="index.php?area=admin&controller=video&action=edit&id=<?= $video['id'] ?>"
                class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl">
                Sửa video
            </a>

            <a href="index.php?area=admin&controller=video&action=index" class="btn btn-outline rounded-2xl">
                ← Quay lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl 2xl:col-span-2">
            <div class="card-body space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">
                        <?= htmlspecialchars($video['title']) ?>
                    </h2>
                    <p class="text-slate-500 mt-1">
                        <?= htmlspecialchars($video['slug']) ?>
                    </p>
                </div>

                <?php if (!empty($video['video_file'])): ?>
                <video controls class="w-full rounded-3xl border border-slate-200 bg-black">
                    <source src="<?= htmlspecialchars($video['video_file']) ?>">
                    Trình duyệt không hỗ trợ video.
                </video>
                <?php elseif (!empty($video['video_url'])): ?>
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6">
                    <p class="text-sm text-slate-500 mb-2">URL video ngoài</p>
                    <a href="<?= htmlspecialchars($video['video_url']) ?>" target="_blank"
                        class="text-sky-600 font-bold break-all">
                        <?= htmlspecialchars($video['video_url']) ?>
                    </a>
                </div>
                <?php else: ?>
                <div
                    class="rounded-3xl bg-pink-50 border border-slate-200 h-80 flex flex-col items-center justify-center text-slate-400">
                    <div class="text-6xl">🎬</div>
                    <p class="text-sm mt-3">Chưa có video</p>
                </div>
                <?php endif; ?>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                    <h3 class="font-bold text-slate-900 mb-2">Mô tả</h3>
                    <div class="text-slate-600 leading-7">
                        <?= nl2br(htmlspecialchars($video['description'] ?? 'Chưa có mô tả.')) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Thumbnail</h3>

                    <?php if (!empty($video['thumbnail'])): ?>
                    <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                        alt="<?= htmlspecialchars($video['title']) ?>"
                        class="rounded-3xl border border-slate-200 w-full object-cover">
                    <?php else: ?>
                    <div
                        class="rounded-3xl bg-slate-50 border border-slate-200 h-56 flex flex-col items-center justify-center text-slate-400">
                        <div class="text-5xl">🖼️</div>
                        <p class="text-sm mt-2">Chưa có thumbnail</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Thông tin</h3>

                    <div>
                        <p class="text-sm text-slate-500">ID</p>
                        <p class="font-bold">#<?= htmlspecialchars($video['id']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tác giả</p>
                        <p class="font-bold"><?= htmlspecialchars($video['author_name'] ?? 'Không rõ') ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Loại video</p>
                        <?php if (($video['video_type'] ?? '') === 'short'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-pink-100 text-pink-700">short</span>
                        <?php else: ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">long</span>
                        <?php endif; ?>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Thời lượng</p>
                        <p class="font-bold">
                            <?= !empty($video['duration']) ? htmlspecialchars($video['duration']) . ' giây' : '-' ?>
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">View</p>
                        <p class="font-bold"><?= htmlspecialchars($video['view_count'] ?? 0) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Trạng thái</p>
                        <?php if ($video['status'] === 'published'): ?>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">published</span>
                        <?php elseif ($video['status'] === 'draft'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">draft</span>
                        <?php else: ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">hidden</span>
                        <?php endif; ?>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Ngày tạo</p>
                        <p><?= htmlspecialchars($video['created_at'] ?? '') ?></p>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-3">
                    <h3 class="text-xl font-extrabold text-slate-900">Thao tác nhanh</h3>

                    <?php if ($video['status'] !== 'published'): ?>
                    <a href="index.php?area=admin&controller=video&action=publish&id=<?= $video['id'] ?>"
                        class="btn bg-green-500 hover:bg-green-600 border-0 text-white rounded-2xl w-full">
                        Publish video
                    </a>
                    <?php else: ?>
                    <a href="index.php?area=admin&controller=video&action=hide&id=<?= $video['id'] ?>"
                        class="btn bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-2xl w-full">
                        Ẩn video
                    </a>
                    <?php endif; ?>

                    <a href="index.php?area=admin&controller=video&action=draft&id=<?= $video['id'] ?>"
                        class="btn btn-outline rounded-2xl w-full">
                        Chuyển về draft
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>