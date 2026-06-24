<?php
$settings = $settings ?? [];

if (!function_exists('videoPageUrl')) {
    function videoPageUrl($filters, $page)
    {
        $query = [
            'area' => 'client',
            'controller' => 'video',
            'action' => 'index',
            'keyword' => $filters['keyword'] ?? '',
            'sort' => $filters['sort'] ?? 'newest',
            'page' => $page,
        ];

        return 'index.php?' . http_build_query($query);
    }
}

if (!function_exists('getYoutubeEmbedUrl')) {
    function getYoutubeEmbedUrl($url)
    {
        if (empty($url)) {
            return '';
        }

        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }

        $videoId = '';

        if (preg_match('/youtu\.be\/([^?&]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if (preg_match('/youtube\.com\/watch\?v=([^?&]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if (preg_match('/youtube\.com\/shorts\/([^?&]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }

        return $videoId ? 'https://www.youtube.com/embed/' . $videoId : '';
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

$videoHeaderBanner = $settings['video_header_banner'] ?? '';

$videoHeroTitle = $settings['video_hero_title'] ?? 'Video ngắn và video dài';
$videoHeroSubtitle = $settings['video_hero_subtitle'] ?? 'Trang này ưu tiên dùng link YouTube để nhẹ hosting. Video short và long được chia layout riêng.';
$videoShortTitle = $settings['video_short_title'] ?? 'Video ngắn';
$videoLongTitle = $settings['video_long_title'] ?? 'Video dài';
?>

<section class="bg-slate-50">
    <div class="client-shell py-8 sm:py-12">
        <div class="client-card overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center">
                    <span class="client-badge mb-5 w-fit">
                        Video Library
                    </span>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                        <?= htmlspecialchars($videoHeroTitle) ?>
                    </h1>

                    <p class="text-slate-500 mt-5 leading-8 max-w-2xl">
                        <?= htmlspecialchars($videoHeroSubtitle) ?>
                    </p>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-8 max-w-xl">
                        <div class="rounded-3xl bg-green-50 p-4">
                            <p class="text-2xl font-extrabold text-slate-950">
                                <?= count($shortVideos ?? []) ?>
                            </p>
                            <p class="text-sm text-slate-500 mt-1">Video ngắn</p>
                        </div>

                        <div class="rounded-3xl bg-orange-50 p-4">
                            <p class="text-2xl font-extrabold text-slate-950">
                                <?= count($longVideos ?? []) ?>
                            </p>
                            <p class="text-sm text-slate-500 mt-1">Video dài</p>
                        </div>

                        <div class="rounded-3xl bg-slate-100 p-4 col-span-2 sm:col-span-1">
                            <p class="text-2xl font-extrabold text-slate-950">
                                <?= htmlspecialchars($totalVideos ?? 0) ?>
                            </p>
                            <p class="text-sm text-slate-500 mt-1">Tổng video</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 min-h-72 bg-slate-950 relative overflow-hidden">
                    <?php if (clientImageExists($videoHeaderBanner)): ?>
                        <img src="<?= htmlspecialchars($videoHeaderBanner) ?>" alt="Video header"
                            class="w-full h-full min-h-72 object-cover">

                        <div class="absolute inset-0 bg-slate-950/35"></div>
                    <?php else: ?>
                        <div
                            class="w-full h-full min-h-72 bg-gradient-to-br from-slate-950 via-slate-800 to-green-700 flex items-center justify-center text-white text-center p-8">
                            <div>
                                <div class="text-7xl mb-4">🎬</div>
                                <h2 class="text-3xl font-extrabold">Watch Fresh</h2>
                                <p class="text-white/80 mt-3">Video sản phẩm, mẹo chọn trái cây và quảng cáo.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <form method="GET" class="client-card p-4 grid grid-cols-1 sm:grid-cols-4 gap-3 mt-6">
            <input type="hidden" name="area" value="client">
            <input type="hidden" name="controller" value="video">
            <input type="hidden" name="action" value="index">

            <input type="text" name="keyword" class="input input-bordered rounded-full w-full sm:col-span-2 bg-white"
                placeholder="Tìm video..." value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">

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
</section>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
            <div>
                <span class="client-badge mb-3">
                    Short
                </span>

                <h2 class="client-section-title">
                    <?= htmlspecialchars($videoShortTitle) ?>
                </h2>

                <p class="client-section-subtitle">
                    Video ngắn dạng thẻ dọc, có thể lướt ngang để xem nhanh.
                </p>
            </div>
        </div>

        <?php if (!empty($shortVideos)): ?>
            <div class="flex gap-4 overflow-x-auto pb-4 snap-x">
                <?php foreach ($shortVideos as $video): ?>
                    <?php $embedUrl = getYoutubeEmbedUrl($video['video_url'] ?? ''); ?>

                    <div class="client-card client-card-hover overflow-hidden w-56 sm:w-64 shrink-0 snap-start">
                        <div class="aspect-[9/14] bg-slate-950 relative">
                            <?php if (!empty($embedUrl)): ?>
                                <iframe src="<?= htmlspecialchars($embedUrl) ?>" class="w-full h-full" allowfullscreen
                                    loading="lazy"></iframe>
                            <?php elseif (clientImageExists($video['thumbnail'] ?? '')): ?>
                                <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-5xl text-white">🎬</div>
                            <?php endif; ?>

                            <span
                                class="absolute top-3 left-3 px-3 py-1 rounded-full bg-rose-500 text-white text-[10px] font-bold">
                                SHORT
                            </span>
                        </div>

                        <div class="p-4">
                            <h3 class="font-extrabold text-sm leading-5 h-10 overflow-hidden text-slate-950">
                                <?= htmlspecialchars($video['title']) ?>
                            </h3>

                            <p class="text-xs text-slate-400 mt-2">
                                👁 <?= htmlspecialchars($video['view_count'] ?? 0) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="client-card p-10 text-center text-slate-500">
                Chưa có video short.
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="mb-6">
            <span class="client-badge mb-3">
                Long Video
            </span>

            <h2 class="client-section-title">
                <?= htmlspecialchars($videoLongTitle) ?>
            </h2>

            <p class="client-section-subtitle">
                Video dài hiển thị rộng hơn, dễ xem trên desktop.
            </p>
        </div>

        <?php if (!empty($longVideos)): ?>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <?php foreach ($longVideos as $video): ?>
                    <?php $embedUrl = getYoutubeEmbedUrl($video['video_url'] ?? ''); ?>

                    <article class="client-card client-card-hover overflow-hidden">
                        <div class="aspect-video bg-slate-950">
                            <?php if (!empty($embedUrl)): ?>
                                <iframe src="<?= htmlspecialchars($embedUrl) ?>" class="w-full h-full" allowfullscreen
                                    loading="lazy"></iframe>
                            <?php elseif (clientImageExists($video['thumbnail'] ?? '')): ?>
                                <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-7xl text-white">🎥</div>
                            <?php endif; ?>
                        </div>

                        <div class="p-5">
                            <div class="flex items-center justify-between gap-3 mb-3">
                                <span class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold">
                                    LONG VIDEO
                                </span>

                                <span class="text-xs text-slate-400">
                                    👁 <?= htmlspecialchars($video['view_count'] ?? 0) ?>
                                </span>
                            </div>

                            <h3 class="text-xl font-extrabold text-slate-950 leading-7">
                                <?= htmlspecialchars($video['title']) ?>
                            </h3>

                            <p class="text-slate-500 mt-3 leading-7">
                                <?= htmlspecialchars($video['description'] ?? '') ?>
                            </p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="client-card p-10 text-center text-slate-500">
                Chưa có video long.
            </div>
        <?php endif; ?>

        <?php if (($totalPages ?? 1) > 1): ?>
            <div class="flex justify-center mt-10 overflow-x-auto">
                <div class="join">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="<?= videoPageUrl($filters ?? [], $i) ?>"
                            class="join-item btn <?= (int)($page ?? 1) === $i ? 'bg-green-700 text-white border-green-700' : 'bg-white' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>