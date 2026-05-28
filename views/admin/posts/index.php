<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Quản lý bài viết') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Quản lý bài viết, tin tức và nội dung hiển thị trên website.
            </p>
        </div>

        <a href="index.php?area=admin&controller=post&action=create"
            class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
            + Thêm bài viết
        </a>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="post">
                <input type="hidden" name="action" value="index">

                <div class="xl:col-span-7">
                    <input type="text" name="keyword" placeholder="Tìm theo tiêu đề, tóm tắt..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                </div>

                <div class="xl:col-span-3">
                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả trạng thái</option>
                        <option value="draft" <?= ($filters['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft
                        </option>
                        <option value="published" <?= ($filters['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                            Published</option>
                        <option value="hidden" <?= ($filters['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Hidden
                        </option>
                    </select>
                </div>

                <div class="xl:col-span-1">
                    <button type="submit"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                        Lọc
                    </button>
                </div>

                <div class="xl:col-span-1">
                    <a href="index.php?area=admin&controller=post&action=index"
                        class="btn btn-outline rounded-2xl w-full">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Danh sách bài viết
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Các bài viết đã tạo trong hệ thống.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($posts) ? count($posts) : 0 ?> bài viết
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Bài viết</th>
                            <th>Tác giả</th>
                            <th>View</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                        <tr class="hover">
                            <td class="font-bold">#<?= htmlspecialchars($post['id']) ?></td>

                            <td>
                                <?php if (!empty($post['thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($post['thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($post['title']) ?>"
                                    class="w-16 h-16 rounded-2xl object-cover border border-slate-200">
                                <?php else: ?>
                                <div
                                    class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-3xl">
                                    📝
                                </div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="font-bold text-slate-900">
                                    <?= htmlspecialchars($post['title']) ?>
                                </div>
                                <div class="text-xs text-slate-500 mt-1 max-w-md truncate">
                                    <?= htmlspecialchars($post['summary'] ?? $post['slug']) ?>
                                </div>
                            </td>

                            <td class="text-slate-600">
                                <?= htmlspecialchars($post['author_name'] ?? 'Không rõ') ?>
                            </td>

                            <td class="font-bold">
                                <?= htmlspecialchars($post['view_count'] ?? 0) ?>
                            </td>

                            <td>
                                <?php if ($post['status'] === 'published'): ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">published</span>
                                <?php elseif ($post['status'] === 'draft'): ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">draft</span>
                                <?php else: ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">hidden</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-slate-500">
                                <?= htmlspecialchars($post['created_at'] ?? '') ?>
                            </td>

                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="index.php?area=admin&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>"
                                        class="btn btn-sm bg-sky-500 hover:bg-sky-600 border-0 text-white rounded-xl">
                                        Xem
                                    </a>

                                    <a href="index.php?area=admin&controller=post&action=edit&id=<?= $post['id'] ?>"
                                        class="btn btn-sm btn-outline rounded-xl">
                                        Sửa
                                    </a>

                                    <?php if ($post['status'] !== 'published'): ?>
                                    <a href="index.php?area=admin&controller=post&action=publish&id=<?= $post['id'] ?>"
                                        class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white rounded-xl">
                                        Publish
                                    </a>
                                    <?php else: ?>
                                    <a href="index.php?area=admin&controller=post&action=hide&id=<?= $post['id'] ?>"
                                        class="btn btn-sm bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-xl">
                                        Ẩn
                                    </a>
                                    <?php endif; ?>

                                    <a href="index.php?area=admin&controller=post&action=delete&id=<?= $post['id'] ?>"
                                        class="btn btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-xl"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa bài viết này?')">
                                        Xóa
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8">
                                <div class="py-16 text-center">
                                    <div
                                        class="w-16 h-16 rounded-3xl bg-orange-50 flex items-center justify-center text-3xl mx-auto">
                                        📝
                                    </div>

                                    <p class="font-bold mt-4">Chưa có bài viết nào</p>
                                    <p class="text-sm text-slate-500 mt-1">
                                        Hãy tạo bài viết đầu tiên cho website.
                                    </p>

                                    <a href="index.php?area=admin&controller=post&action=create"
                                        class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl mt-4">
                                        + Thêm bài viết
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>