<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Quản lý video') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Quản lý video ngắn, video dài và nội dung truyền thông trên website.
            </p>
        </div>

        <a href="index.php?area=admin&controller=video&action=create"
            class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
            + Thêm video
        </a>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="video">
                <input type="hidden" name="action" value="index">

                <div class="xl:col-span-5">
                    <input type="text" name="keyword" placeholder="Tìm theo tiêu đề, mô tả..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                </div>

                <div class="xl:col-span-3">
                    <select name="video_type" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả loại video</option>
                        <option value="short" <?= ($filters['video_type'] ?? '') === 'short' ? 'selected' : '' ?>>
                            Video ngắn
                        </option>
                        <option value="long" <?= ($filters['video_type'] ?? '') === 'long' ? 'selected' : '' ?>>
                            Video dài
                        </option>
                    </select>
                </div>

                <div class="xl:col-span-2">
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
                    <a href="index.php?area=admin&controller=video&action=index"
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
                        Danh sách video
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Các video đã được tạo trong hệ thống.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($videos) ? count($videos) : 0 ?> video
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Video</th>
                            <th>Loại</th>
                            <th>Nguồn</th>
                            <th>View</th>
                            <th>Trạng thái</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($videos)): ?>
                        <?php foreach ($videos as $video): ?>
                        <tr class="hover">
                            <td class="font-bold">#<?= htmlspecialchars($video['id']) ?></td>

                            <td>
                                <?php if (!empty($video['thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($video['title']) ?>"
                                    class="w-20 h-14 rounded-2xl object-cover border border-slate-200">
                                <?php else: ?>
                                <div class="w-20 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-3xl">
                                    🎬
                                </div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="font-bold text-slate-900">
                                    <?= htmlspecialchars($video['title']) ?>
                                </div>

                                <div class="text-xs text-slate-500 mt-1 max-w-md truncate">
                                    <?= htmlspecialchars($video['description'] ?? $video['slug']) ?>
                                </div>
                            </td>

                            <td>
                                <?php if (($video['video_type'] ?? '') === 'short'): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-pink-100 text-pink-700">
                                    short
                                </span>
                                <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-violet-100 text-violet-700">
                                    long
                                </span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($video['video_file'])): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-700">
                                    upload
                                </span>
                                <?php elseif (!empty($video['video_url'])): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                    url
                                </span>
                                <?php else: ?>
                                <span class="text-slate-400">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="font-bold">
                                <?= htmlspecialchars($video['view_count'] ?? 0) ?>
                            </td>

                            <td>
                                <?php if ($video['status'] === 'published'): ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">published</span>
                                <?php elseif ($video['status'] === 'draft'): ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">draft</span>
                                <?php else: ?>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">hidden</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="index.php?area=admin&controller=video&action=detail&slug=<?= urlencode($video['slug']) ?>"
                                        class="btn btn-sm bg-sky-500 hover:bg-sky-600 border-0 text-white rounded-xl">
                                        Xem
                                    </a>

                                    <a href="index.php?area=admin&controller=video&action=edit&id=<?= $video['id'] ?>"
                                        class="btn btn-sm btn-outline rounded-xl">
                                        Sửa
                                    </a>

                                    <?php if ($video['status'] !== 'published'): ?>
                                    <a href="index.php?area=admin&controller=video&action=publish&id=<?= $video['id'] ?>"
                                        class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white rounded-xl">
                                        Publish
                                    </a>
                                    <?php else: ?>
                                    <a href="index.php?area=admin&controller=video&action=hide&id=<?= $video['id'] ?>"
                                        class="btn btn-sm bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-xl">
                                        Ẩn
                                    </a>
                                    <?php endif; ?>

                                    <a href="index.php?area=admin&controller=video&action=delete&id=<?= $video['id'] ?>"
                                        class="btn btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-xl"
                                        onclick="return confirm('Bạn chắc chắn muốn xóa video này?')">
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
                                        class="w-16 h-16 rounded-3xl bg-pink-50 flex items-center justify-center text-3xl mx-auto">
                                        🎬
                                    </div>

                                    <p class="font-bold mt-4">Chưa có video nào</p>
                                    <p class="text-sm text-slate-500 mt-1">
                                        Hãy thêm video đầu tiên cho website.
                                    </p>

                                    <a href="index.php?area=admin&controller=video&action=create"
                                        class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl mt-4">
                                        + Thêm video
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