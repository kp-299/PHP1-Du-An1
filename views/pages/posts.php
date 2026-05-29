<?php
function postPageUrl($filters, $page)
{
    $query = [
        'area' => 'client',
        'controller' => 'post',
        'action' => 'index',
        'keyword' => $filters['keyword'] ?? '',
        'sort' => $filters['sort'] ?? 'newest',
        'page' => $page,
    ];

    return 'index.php?' . http_build_query($query);
}

if (!function_exists('clientImageExists')) {
    function clientImageExists($path)
    {
        if (empty($path)) return false;

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return true;
        }

        return file_exists(__DIR__ . '/../../' . ltrim($path, '/'));
    }
}
?>

<!-- Hero -->
<section class="bg-gradient-to-br from-orange-50 via-yellow-50 to-green-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
        <div class="rounded-[2rem] bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-6 sm:p-10 lg:p-14 flex flex-col justify-center">
                    <span class="w-fit px-4 py-2 rounded-full bg-orange-100 text-orange-700 text-sm font-bold mb-5">
                        Blog trái cây
                    </span>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                        Bài viết, mẹo chọn trái cây và dinh dưỡng
                    </h1>

                    <p class="text-slate-500 mt-5 leading-7">
                        Tất cả bài viết được quản lý từ admin dashboard. Bạn có thể tìm kiếm, sắp xếp và đọc chi tiết
                        từng bài viết.
                    </p>
                </div>

                <div
                    class="min-h-64 bg-gradient-to-br from-orange-400 to-yellow-400 flex items-center justify-center text-white">
                    <div class="text-center px-6">
                        <div class="text-7xl sm:text-8xl mb-4">📝🍊</div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold">Fruit Blog</h2>
                        <p class="text-white/80 mt-3">Kiến thức nhỏ, lợi ích lớn.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Main -->
        <div class="lg:col-span-8 xl:col-span-9">
            <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
                        Tất cả bài viết
                    </h2>
                    <p class="text-slate-500 mt-2">
                        Tìm thấy <?= htmlspecialchars($totalPosts ?? count($posts ?? [])) ?> bài viết.
                    </p>
                </div>

                <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 w-full xl:max-w-2xl">
                    <input type="hidden" name="area" value="client">
                    <input type="hidden" name="controller" value="post">
                    <input type="hidden" name="action" value="index">

                    <input type="text" name="keyword" class="input input-bordered rounded-2xl w-full sm:col-span-2"
                        placeholder="Tìm bài viết..." value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">

                    <select name="sort" class="select select-bordered rounded-2xl w-full">
                        <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Mới nhất
                        </option>
                        <option value="oldest" <?= ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>Cũ nhất
                        </option>
                        <option value="view_desc" <?= ($filters['sort'] ?? '') === 'view_desc' ? 'selected' : '' ?>>Xem
                            nhiều</option>
                    </select>

                    <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                        Lọc
                    </button>
                </form>
            </div>

            <?php if (!empty($posts)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                    <?php foreach ($posts as $post): ?>
                        <article
                            class="group bg-white border border-slate-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md transition">
                            <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>"
                                class="block">
                                <div class="h-52 bg-orange-50 overflow-hidden">
                                    <?php if (clientImageExists($post['thumbnail'] ?? '')): ?>
                                        <img src="<?= htmlspecialchars($post['thumbnail']) ?>"
                                            alt="<?= htmlspecialchars($post['title']) ?>"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-6xl">
                                            📝
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <div class="p-5">
                                <a
                                    href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>">
                                    <h3
                                        class="text-lg font-extrabold leading-6 min-h-12 max-h-12 overflow-hidden hover:text-green-600 transition">
                                        <?= htmlspecialchars($post['title']) ?>
                                    </h3>
                                </a>

                                <p class="text-sm text-slate-500 mt-3 leading-6 min-h-18 max-h-18 overflow-hidden">
                                    <?= htmlspecialchars($post['summary'] ?? '') ?>
                                </p>

                                <div class="flex items-center justify-between mt-5">
                                    <span class="text-xs text-slate-400">
                                        👁 <?= htmlspecialchars($post['view_count'] ?? 0) ?>
                                    </span>

                                    <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>"
                                        class="btn btn-sm btn-outline rounded-xl">
                                        Đọc thêm
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if (($totalPages ?? 1) > 1): ?>
                    <div class="flex justify-center mt-10">
                        <div class="join">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="<?= postPageUrl($filters ?? [], $i) ?>"
                                    class="join-item btn <?= (int)($page ?? 1) === $i ? 'bg-green-500 text-white border-green-500' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center">
                    <div class="text-6xl mb-4">🍃</div>
                    <h3 class="text-2xl font-extrabold">Không tìm thấy bài viết</h3>
                    <p class="text-slate-500 mt-2">Thử đổi từ khóa hoặc bộ lọc.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right sidebar desktop only -->
        <aside class="hidden lg:block lg:col-span-4 xl:col-span-3">
            <div class="sticky top-24 space-y-5">
                <div class="bg-white border border-slate-200 rounded-3xl p-5">
                    <h3 class="text-xl font-extrabold text-slate-950 mb-4">
                        Bài viết ngẫu nhiên
                    </h3>

                    <?php if (!empty($randomPosts)): ?>
                        <div class="space-y-4">
                            <?php foreach ($randomPosts as $randomPost): ?>
                                <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($randomPost['slug']) ?>"
                                    class="flex gap-3 group">
                                    <div class="w-20 h-20 rounded-2xl bg-orange-50 overflow-hidden shrink-0">
                                        <?php if (clientImageExists($randomPost['thumbnail'] ?? '')): ?>
                                            <img src="<?= htmlspecialchars($randomPost['thumbnail']) ?>"
                                                alt="<?= htmlspecialchars($randomPost['title']) ?>"
                                                class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-3xl">📝</div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="min-w-0">
                                        <h4
                                            class="font-bold text-sm leading-5 max-h-10 overflow-hidden group-hover:text-green-600 transition">
                                            <?= htmlspecialchars($randomPost['title']) ?>
                                        </h4>
                                        <p class="text-xs text-slate-400 mt-1">
                                            👁 <?= htmlspecialchars($randomPost['view_count'] ?? 0) ?>
                                        </p>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-slate-500 text-sm">Chưa có bài viết ngẫu nhiên.</p>
                    <?php endif; ?>
                </div>

                <div class="rounded-3xl bg-gradient-to-br from-green-500 to-lime-500 text-white p-6">
                    <div class="text-5xl mb-4">🍊</div>
                    <h3 class="text-2xl font-extrabold">Mẹo nhỏ mỗi ngày</h3>
                    <p class="text-white/80 mt-3 leading-7">
                        Chọn trái cây theo mùa sẽ ngon hơn, rẻ hơn và giữ được độ tươi lâu hơn.
                    </p>
                </div>
            </div>
        </aside>
    </div>
</section>