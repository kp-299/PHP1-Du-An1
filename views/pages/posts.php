<?php
$settings = $settings ?? [];

if (!function_exists('postPageUrl')) {
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
}

if (!function_exists('clientImageExists')) {
    function clientImageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return true;
        }

        return file_exists(__DIR__ . '/../../' . ltrim($path, '/'));
    }
}

$postHeaderBanner = $settings['post_header_banner'] ?? '';

$postHeroTitle = $settings['post_hero_title'] ?? 'Bài viết, mẹo chọn trái cây và dinh dưỡng';
$postHeroSubtitle = $settings['post_hero_subtitle'] ?? 'Tất cả bài viết được quản lý từ admin dashboard. Bạn có thể tìm kiếm, sắp xếp và đọc chi tiết từng bài viết.';
$postSectionTitle = $settings['post_section_title'] ?? 'Tất cả bài viết';
?>

<section class="bg-slate-50">
    <div class="client-shell py-8 sm:py-12">
        <div class="client-card overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-6 sm:p-10 lg:p-14 flex flex-col justify-center">
                    <span class="client-badge w-fit mb-5">
                        Blog trái cây
                    </span>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                        <?= htmlspecialchars($postHeroTitle) ?>
                    </h1>

                    <p class="text-slate-500 mt-5 leading-8">
                        <?= htmlspecialchars($postHeroSubtitle) ?>
                    </p>

                    <div class="mt-7">
                        <a href="#post-list" class="client-btn-accent h-11 px-6">
                            Xem bài viết
                        </a>
                    </div>
                </div>

                <div class="min-h-64 lg:min-h-full relative overflow-hidden">
                    <?php if (clientImageExists($postHeaderBanner)): ?>
                        <img src="<?= htmlspecialchars($postHeaderBanner) ?>" alt="Post header"
                            class="w-full h-full min-h-64 object-cover">
                        <div class="absolute inset-0 bg-slate-950/25"></div>
                    <?php else: ?>
                        <div
                            class="w-full h-full min-h-64 bg-gradient-to-br from-orange-400 via-amber-300 to-green-400 flex items-center justify-center text-white">
                            <div class="text-center px-6">
                                <div class="text-7xl sm:text-8xl mb-4">📝🍊</div>
                                <h2 class="text-3xl sm:text-4xl font-extrabold">Fruit Blog</h2>
                                <p class="text-white/90 mt-3">Kiến thức nhỏ, lợi ích lớn.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="post-list" class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-8 xl:col-span-9">
                <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4 mb-6">
                    <div>
                        <span class="client-badge mb-3">
                            Journal
                        </span>

                        <h2 class="client-section-title">
                            <?= htmlspecialchars($postSectionTitle) ?>
                        </h2>

                        <p class="client-section-subtitle">
                            Tìm thấy <?= htmlspecialchars($totalPosts ?? count($posts ?? [])) ?> bài viết.
                        </p>
                    </div>

                    <form method="GET"
                        class="client-card p-3 grid grid-cols-1 sm:grid-cols-4 gap-3 w-full xl:max-w-2xl">
                        <input type="hidden" name="area" value="client">
                        <input type="hidden" name="controller" value="post">
                        <input type="hidden" name="action" value="index">

                        <input type="text" name="keyword"
                            class="input input-bordered rounded-full w-full sm:col-span-2 bg-white"
                            placeholder="Tìm bài viết..." value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">

                        <select name="sort" class="select select-bordered rounded-full w-full bg-white">
                            <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>
                                Mới nhất
                            </option>
                            <option value="oldest" <?= ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>
                                Cũ nhất
                            </option>
                            <option value="view_desc" <?= ($filters['sort'] ?? '') === 'view_desc' ? 'selected' : '' ?>>
                                Xem nhiều
                            </option>
                        </select>

                        <button class="client-btn-primary h-12 px-5">
                            Lọc
                        </button>
                    </form>
                </div>

                <?php if (!empty($posts)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        <?php foreach ($posts as $post): ?>
                            <?php
                            $postDetailUrl = 'index.php?area=client&controller=post&action=detail&slug=' . urlencode($post['slug']);
                            ?>

                            <article class="client-card client-card-hover overflow-hidden group">
                                <a href="<?= $postDetailUrl ?>" class="block">
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
                                    <a href="<?= $postDetailUrl ?>">
                                        <h3
                                            class="text-lg font-extrabold leading-6 min-h-12 max-h-12 overflow-hidden hover:text-green-700 transition text-slate-950">
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

                                        <a href="<?= $postDetailUrl ?>"
                                            class="h-9 px-4 rounded-full border border-slate-200 hover:bg-green-50 text-slate-800 inline-flex items-center justify-center text-sm font-bold transition">
                                            Đọc thêm
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <?php if (($totalPages ?? 1) > 1): ?>
                        <div class="flex justify-center mt-10 overflow-x-auto">
                            <div class="join">
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a href="<?= postPageUrl($filters ?? [], $i) ?>"
                                        class="join-item btn <?= (int)($page ?? 1) === $i ? 'bg-green-700 text-white border-green-700' : 'bg-white' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="client-card p-12 text-center">
                        <div class="text-6xl mb-4">🍃</div>
                        <h3 class="text-2xl font-extrabold text-slate-950">Không tìm thấy bài viết</h3>
                        <p class="text-slate-500 mt-2">Thử đổi từ khóa hoặc bộ lọc.</p>
                    </div>
                <?php endif; ?>
            </div>

            <aside class="hidden lg:block lg:col-span-4 xl:col-span-3">
                <div class="sticky top-24 space-y-5">
                    <div class="client-card p-5">
                        <h3 class="text-xl font-extrabold text-slate-950 mb-4">
                            Bài viết ngẫu nhiên
                        </h3>

                        <?php if (!empty($randomPosts)): ?>
                            <div class="space-y-4">
                                <?php foreach ($randomPosts as $randomPost): ?>
                                    <?php
                                    $randomPostUrl = 'index.php?area=client&controller=post&action=detail&slug=' . urlencode($randomPost['slug']);
                                    ?>

                                    <a href="<?= $randomPostUrl ?>" class="flex gap-3 group">
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
                                                class="font-bold text-sm leading-5 max-h-10 overflow-hidden group-hover:text-green-700 transition text-slate-950">
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

                    <div class="rounded-3xl bg-slate-950 text-white p-6">
                        <div class="text-5xl mb-4">🍊</div>

                        <h3 class="text-2xl font-extrabold">
                            <?= htmlspecialchars($settings['post_sidebar_title'] ?? 'Mẹo nhỏ mỗi ngày') ?>
                        </h3>

                        <p class="text-white/75 mt-3 leading-7">
                            <?= htmlspecialchars($settings['post_sidebar_content'] ?? 'Chọn trái cây theo mùa sẽ ngon hơn, rẻ hơn và giữ được độ tươi lâu hơn.') ?>
                        </p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>