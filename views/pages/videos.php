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

<!-- Hero -->
<section class="bg-slate-950 text-white">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
                <span class="inline-flex px-4 py-2 rounded-full bg-white/10 text-sm font-bold mb-5">
                    Fruit Video
                </span>

                <h1 class="text-3xl sm:text-5xl font-extrabold leading-tight">
                    <?= htmlspecialchars($videoHeroTitle) ?>
                </h1>

                <p class="text-slate-300 mt-5 leading-8 max-w-xl">
                    <?= htmlspecialchars($videoHeroSubtitle) ?>
                </p>
            </div>

            <div class="rounded-[2rem] overflow-hidden min-h-64 relative">
                <?php if (clientImageExists($videoHeaderBanner)): ?>
                <img src="<?= htmlspecialchars($videoHeaderBanner) ?>" alt="Video header"
                    class="w-full h-64 lg:h-80 object-cover">

                <div class="absolute inset-0 bg-black/35"></div>


                <?php else: ?>
                <div
                    class="bg-gradient-to-br from-pink-500 to-violet-600 min-h-64 flex items-center justify-center text-center p-8">
                    <div>
                        <div class="text-8xl mb-4">🎬</div>
                        <h2 class="text-3xl font-extrabold">Watch Fresh</h2>
                        <p class="text-white/80 mt-3">Video sản phẩm, mẹo chọn trái cây và quảng cáo.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Filter -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-8">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 bg-white border border-slate-200 rounded-3xl p-4">
        <input type="hidden" name="area" value="client">
        <input type="hidden" name="controller" value="video">
        <input type="hidden" name="action" value="index">

        <input type="text" name="keyword" class="input input-bordered rounded-2xl w-full sm:col-span-2"
            placeholder="Tìm video..." value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">

        <select name="sort" class="select select-bordered rounded-2xl w-full">
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

        <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
            Lọc
        </button>
    </form>
</section>

<!-- Short videos -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
                <?= htmlspecialchars($videoShortTitle) ?>
            </h2>

            <p class="text-slate-500 mt-2">
                Layout dạng vertical giống short video.
            </p>
        </div>
    </div>

    <?php if (!empty($shortVideos)): ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
        <?php foreach ($shortVideos as $video): ?>
        <?php $embedUrl = getYoutubeEmbedUrl($video['video_url'] ?? ''); ?>

        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden">
            <div class="aspect-[9/14] bg-slate-950">
                <?php if (!empty($embedUrl)): ?>
                <iframe src="<?= htmlspecialchars($embedUrl) ?>" class="w-full h-full" allowfullscreen
                    loading="lazy"></iframe>
                <?php elseif (clientImageExists($video['thumbnail'] ?? '')): ?>
                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" alt="<?= htmlspecialchars($video['title']) ?>"
                    class="w-full h-full object-cover">
                <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-5xl text-white">🎬</div>
                <?php endif; ?>
            </div>

            <div class="p-3">
                <span class="px-2 py-1 rounded-full bg-pink-100 text-pink-700 text-[10px] font-bold">
                    SHORT
                </span>

                <h3 class="font-bold text-sm leading-5 h-10 overflow-hidden mt-2">
                    <?= htmlspecialchars($video['title']) ?>
                </h3>

                <p class="text-xs text-slate-400 mt-1">
                    👁 <?= htmlspecialchars($video['view_count'] ?? 0) ?>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
        Chưa có video short.
    </div>
    <?php endif; ?>
</section>

<!-- Long videos -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
            <?= htmlspecialchars($videoLongTitle) ?>
        </h2>

        <p class="text-slate-500 mt-2">
            Video dài hiển thị rộng hơn, dễ xem trên desktop.
        </p>
    </div>

    <?php if (!empty($longVideos)): ?>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <?php foreach ($longVideos as $video): ?>
        <?php $embedUrl = getYoutubeEmbedUrl($video['video_url'] ?? ''); ?>

        <article class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden">
            <div class="aspect-video bg-slate-950">
                <?php if (!empty($embedUrl)): ?>
                <iframe src="<?= htmlspecialchars($embedUrl) ?>" class="w-full h-full" allowfullscreen
                    loading="lazy"></iframe>
                <?php elseif (clientImageExists($video['thumbnail'] ?? '')): ?>
                <img src="<?= htmlspecialchars($video['thumbnail']) ?>" alt="<?= htmlspecialchars($video['title']) ?>"
                    class="w-full h-full object-cover">
                <?php else: ?>
                <div class="w-full h-full flex items-center justify-center text-7xl text-white">🎥</div>
                <?php endif; ?>
            </div>

            <div class="p-5">
                <span class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold">
                    LONG VIDEO
                </span>

                <h3 class="text-xl font-extrabold mt-3">
                    <?= htmlspecialchars($video['title']) ?>
                </h3>

                <p class="text-slate-500 mt-3 leading-7">
                    <?= htmlspecialchars($video['description'] ?? '') ?>
                </p>

                <p class="text-xs text-slate-400 mt-4">
                    👁 <?= htmlspecialchars($video['view_count'] ?? 0) ?>
                </p>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
        Chưa có video long.
    </div>
    <?php endif; ?>

    <?php if (($totalPages ?? 1) > 1): ?>
    <div class="flex justify-center mt-10 overflow-x-auto">
        <div class="join">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= videoPageUrl($filters ?? [], $i) ?>"
                class="join-item btn <?= (int)($page ?? 1) === $i ? 'site-primary-bg text-white border-0' : '' ?>">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
</section>