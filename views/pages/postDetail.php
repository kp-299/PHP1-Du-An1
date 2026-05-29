<?php
$settings = $settings ?? [];

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
?>

<section class="max-w-5xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <a href="index.php?area=client&controller=post&action=index"
            class="btn btn-sm sm:btn-md btn-outline rounded-2xl w-fit">
            ← Quay lại bài viết
        </a>

        <div class="text-sm breadcrumbs text-slate-500">
            <ul>
                <li>
                    <a href="index.php?area=client&controller=pages&action=home">Trang chủ</a>
                </li>
                <li>
                    <a href="index.php?area=client&controller=post&action=index">Bài viết</a>
                </li>
                <li>Chi tiết</li>
            </ul>
        </div>
    </div>

    <article class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div class="p-5 sm:p-8 lg:p-10">
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                    BLOG
                </span>

                <span class="text-sm text-slate-400">
                    👁 <?= htmlspecialchars($post['view_count'] ?? 0) ?>
                </span>

                <?php if (!empty($post['author_name'])): ?>
                    <span class="text-sm text-slate-400">
                        ✍ <?= htmlspecialchars($post['author_name']) ?>
                    </span>
                <?php endif; ?>

                <?php if (!empty($post['created_at'])): ?>
                    <span class="text-sm text-slate-400">
                        <?= htmlspecialchars($post['created_at']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                <?= htmlspecialchars($post['title'] ?? 'Chi tiết bài viết') ?>
            </h1>

            <?php if (!empty($post['summary'])): ?>
                <p class="text-lg text-slate-500 leading-8 mt-5">
                    <?= htmlspecialchars($post['summary']) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="h-72 sm:h-[460px] bg-orange-50">
            <?php if (clientImageExists($post['thumbnail'] ?? '')): ?>
                <img src="<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                    class="w-full h-full object-cover">
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-8xl">📝</div>
            <?php endif; ?>
        </div>

        <div class="p-5 sm:p-8 lg:p-10">
            <div class="prose max-w-none text-slate-700 leading-8">
                <?php if (!empty($post['content'])): ?>
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                <?php else: ?>
                    <p>Bài viết hiện chưa có nội dung chi tiết.</p>
                <?php endif; ?>
            </div>
        </div>
    </article>
</section>

<!-- Related posts -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">Bài viết liên quan</h2>
            <p class="text-slate-500 mt-2">Một số bài viết khác bạn có thể đọc.</p>
        </div>

        <a href="index.php?area=client&controller=post&action=index"
            class="btn btn-sm sm:btn-md btn-outline rounded-2xl w-fit">
            Xem tất cả
        </a>
    </div>

    <?php if (!empty($relatedPosts)): ?>
        <div class="carousel carousel-center w-full space-x-4 rounded-box">
            <?php foreach ($relatedPosts as $item): ?>
                <?php
                $relatedPostUrl = 'index.php?area=client&controller=post&action=detail&slug=' . urlencode($item['slug']);
                ?>

                <div class="carousel-item w-72 sm:w-80">
                    <article class="bg-white border border-slate-200 rounded-3xl overflow-hidden w-full">
                        <a href="<?= $relatedPostUrl ?>">
                            <div class="h-44 bg-orange-50">
                                <?php if (clientImageExists($item['thumbnail'] ?? '')): ?>
                                    <img src="<?= htmlspecialchars($item['thumbnail']) ?>" class="w-full h-full object-cover"
                                        alt="<?= htmlspecialchars($item['title']) ?>">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-5xl">📝</div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div class="p-5">
                            <a href="<?= $relatedPostUrl ?>">
                                <h3 class="font-extrabold leading-6 h-12 overflow-hidden hover:text-green-600 transition">
                                    <?= htmlspecialchars($item['title']) ?>
                                </h3>
                            </a>

                            <a href="<?= $relatedPostUrl ?>" class="btn btn-sm btn-outline rounded-xl mt-4">
                                Đọc thêm
                            </a>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có bài viết liên quan.
        </div>
    <?php endif; ?>
</section>

<!-- Latest videos slider -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">Video mới</h2>
        <p class="text-slate-500 mt-2">Video gợi ý sau khi đọc bài viết.</p>
    </div>

    <?php if (!empty($latestVideos)): ?>
        <div class="carousel carousel-center w-full space-x-4 rounded-box">
            <?php foreach ($latestVideos as $video): ?>
                <div class="carousel-item w-64 sm:w-72">
                    <a href="index.php?area=client&controller=video&action=index"
                        class="block bg-slate-950 text-white rounded-3xl overflow-hidden w-full">
                        <div class="aspect-video bg-slate-900">
                            <?php if (clientImageExists($video['thumbnail'] ?? '')): ?>
                                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" class="w-full h-full object-cover"
                                    alt="<?= htmlspecialchars($video['title']) ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-5xl">🎬</div>
                            <?php endif; ?>
                        </div>

                        <div class="p-4">
                            <span class="px-2 py-1 rounded-full bg-white/10 text-white text-[10px] font-bold">
                                <?= strtoupper(htmlspecialchars($video['video_type'] ?? 'video')) ?>
                            </span>

                            <h3 class="font-bold leading-5 h-10 overflow-hidden mt-2">
                                <?= htmlspecialchars($video['title']) ?>
                            </h3>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có video gợi ý.
        </div>
    <?php endif; ?>
</section>