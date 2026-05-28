<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Chi tiết bài viết') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Xem thông tin chi tiết bài viết.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="index.php?area=admin&controller=post&action=edit&id=<?= $post['id'] ?>"
                class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl">
                Sửa bài viết
            </a>

            <a href="index.php?area=admin&controller=post&action=index" class="btn btn-outline rounded-2xl">
                ← Quay lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl 2xl:col-span-2">
            <div class="card-body space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">
                        <?= htmlspecialchars($post['title']) ?>
                    </h2>
                    <p class="text-slate-500 mt-1">
                        <?= htmlspecialchars($post['slug']) ?>
                    </p>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                    <h3 class="font-bold text-slate-900 mb-2">Tóm tắt</h3>
                    <p class="text-slate-600 leading-7">
                        <?= nl2br(htmlspecialchars($post['summary'] ?? 'Chưa có tóm tắt.')) ?>
                    </p>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                    <h3 class="font-bold text-slate-900 mb-2">Nội dung</h3>
                    <div class="text-slate-600 leading-7">
                        <?= nl2br(htmlspecialchars($post['content'] ?? '')) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Ảnh đại diện</h3>

                    <?php if (!empty($post['thumbnail'])): ?>
                    <img src="<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                        class="rounded-3xl border border-slate-200 w-full object-cover">
                    <?php else: ?>
                    <div
                        class="rounded-3xl bg-orange-50 border border-slate-200 h-72 flex flex-col items-center justify-center text-slate-400">
                        <div class="text-6xl">📝</div>
                        <p class="text-sm mt-3">Chưa có ảnh</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">Thông tin</h3>

                    <div>
                        <p class="text-sm text-slate-500">ID</p>
                        <p class="font-bold">#<?= htmlspecialchars($post['id']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tác giả</p>
                        <p class="font-bold"><?= htmlspecialchars($post['author_name'] ?? 'Không rõ') ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">View</p>
                        <p class="font-bold"><?= htmlspecialchars($post['view_count'] ?? 0) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Trạng thái</p>
                        <?php if ($post['status'] === 'published'): ?>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">published</span>
                        <?php elseif ($post['status'] === 'draft'): ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">draft</span>
                        <?php else: ?>
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">hidden</span>
                        <?php endif; ?>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Ngày tạo</p>
                        <p><?= htmlspecialchars($post['created_at'] ?? '') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>