<?php
$settings = $settings ?? [];

$siteName = $settings['site_name'] ?? 'Trái Cây Tươi';

$homeHeroTitle = $settings['home_hero_title'] ?? 'Trái cây tươi ngon, giao nhanh mỗi ngày';
$homeHeroSubtitle = $settings['home_hero_subtitle'] ?? 'Cửa hàng chuyên cung cấp trái cây, rau củ tươi sạch. Sản phẩm được cập nhật từ admin dashboard và hiển thị trực tiếp ra ngoài client.';

$homeProductTitle = $settings['home_product_title'] ?? 'Sản phẩm nổi bật';
$homeVideoTitle = $settings['home_video_title'] ?? 'Video mới';
$homePostTitle = $settings['home_post_title'] ?? 'Bài viết mới';

$homepageNotice = $settings['homepage_notice'] ?? 'Giảm giá trái cây tươi mỗi ngày';

$productsForHome = array_slice($activeProducts ?? $latestProducts ?? [], 0, 18);
$shortVideosForHome = array_slice($shortVideos ?? [], 0, 12);
$longVideosForHome = array_slice($longVideos ?? [], 0, 6);
$postsForHome = array_slice($posts ?? [], 0, 6);

if (!function_exists('clientImageExists')) {
    function clientImageExists($path)
    {
        if (empty($path)) {
            return false;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return true;
        }

        $cleanPath = ltrim($path, '/');

        return file_exists(__DIR__ . '/../../' . $cleanPath);
    }
}

if (!function_exists('settingJsonArray')) {
    function settingJsonArray($settings, $key)
    {
        $value = $settings[$key] ?? '[]';
        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }
}

$homeHeroBanners = settingJsonArray($settings, 'home_hero_banners');
$homeBottomBanners = settingJsonArray($settings, 'home_bottom_banners');
?>

<section class="relative overflow-hidden bg-[#f8faf7]">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-32 -left-24 w-96 h-96 rounded-full bg-[#E8F5E9] blur-3xl"></div>
        <div class="absolute top-24 right-0 w-80 h-80 rounded-full bg-[#ffdcc1]/70 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/3 w-96 h-96 rounded-full bg-[#94d3c1]/25 blur-3xl"></div>
    </div>

    <div
        class="relative max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6 items-center">
        <div class="lg:col-span-5">
            <span
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/80 border border-white shadow-[0_12px_35px_rgba(0,45,38,0.08)] text-[#00342b] text-xs sm:text-sm font-extrabold mb-5 backdrop-blur-xl">
                <span class="w-2 h-2 rounded-full bg-[#FFC107]"></span>
                <?= htmlspecialchars($homepageNotice) ?>
            </span>

            <h2
                class="text-[2.45rem] sm:text-5xl lg:text-6xl font-extrabold leading-[1.02] tracking-tight text-[#191c1b]">
                <?= htmlspecialchars($homeHeroTitle) ?>
            </h2>

            <p class="text-[#3f4945] mt-5 text-base sm:text-lg leading-8 max-w-xl">
                <?= htmlspecialchars($homeHeroSubtitle) ?>
            </p>

            <div class="grid grid-cols-2 sm:flex gap-3 mt-8">
                <a href="index.php?area=client&controller=product&action=index"
                    class="h-12 px-6 rounded-full bg-[#FFC107] hover:bg-[#ffb300] text-[#2e1500] inline-flex items-center justify-center font-extrabold shadow-[0_16px_40px_rgba(255,193,7,0.25)] transition hover:-translate-y-0.5">
                    Mua ngay
                </a>

                <a href="#products"
                    class="h-12 px-6 rounded-full bg-white/85 hover:bg-[#E8F5E9] text-[#00342b] border border-[#bfc9c4]/70 inline-flex items-center justify-center font-extrabold shadow-[0_12px_35px_rgba(0,45,38,0.08)] transition">
                    Xem sản phẩm
                </a>
            </div>

            <div class="grid grid-cols-3 gap-3 mt-8 max-w-xl">
                <div
                    class="rounded-[1.5rem] bg-white/75 border border-white p-4 shadow-[0_12px_35px_rgba(0,45,38,0.07)] backdrop-blur-xl">
                    <p class="text-2xl font-extrabold text-[#00342b]">18+</p>
                    <p class="text-xs text-[#3f4945] mt-1">Sản phẩm hiển thị</p>
                </div>

                <div
                    class="rounded-[1.5rem] bg-white/75 border border-white p-4 shadow-[0_12px_35px_rgba(0,45,38,0.07)] backdrop-blur-xl">
                    <p class="text-2xl font-extrabold text-[#00342b]">12</p>
                    <p class="text-xs text-[#3f4945] mt-1">Video ngắn</p>
                </div>

                <div
                    class="rounded-[1.5rem] bg-white/75 border border-white p-4 shadow-[0_12px_35px_rgba(0,45,38,0.07)] backdrop-blur-xl">
                    <p class="text-2xl font-extrabold text-[#00342b]">6</p>
                    <p class="text-xs text-[#3f4945] mt-1">Bài viết mới</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7">
            <?php if (!empty($homeHeroBanners)): ?>
            <div
                class="carousel w-full rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_24px_80px_rgba(0,45,38,0.16)] overflow-hidden border border-white bg-white/60">
                <?php foreach ($homeHeroBanners as $index => $image): ?>
                <?php
                        $currentSlide = 'home-hero-banner-' . ($index + 1);
                        $prevSlide = 'home-hero-banner-' . ($index === 0 ? count($homeHeroBanners) : $index);
                        $nextSlide = 'home-hero-banner-' . ($index + 2 > count($homeHeroBanners) ? 1 : $index + 2);
                        ?>

                <div id="<?= $currentSlide ?>" class="carousel-item relative w-full">
                    <img src="<?= htmlspecialchars($image) ?>" class="w-full h-64 sm:h-96 lg:h-[520px] object-cover"
                        alt="Home banner">

                    <div class="absolute inset-0 bg-gradient-to-t from-[#002D26]/70 via-[#002D26]/10 to-transparent">
                    </div>

                    <div class="absolute left-5 right-5 bottom-5 sm:left-8 sm:right-8 sm:bottom-8 text-white">
                        <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-[#94d3c1]">
                            <?= htmlspecialchars($siteName) ?>
                        </p>
                        <h3 class="text-2xl sm:text-4xl font-extrabold mt-2 tracking-tight">
                            <?= htmlspecialchars($homepageNotice) ?>
                        </h3>
                    </div>

                    <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                        <a href="#<?= $prevSlide ?>"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg backdrop-blur-xl">❮</a>
                        <a href="#<?= $nextSlide ?>"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg backdrop-blur-xl">❯</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div
                class="carousel w-full rounded-[2rem] sm:rounded-[2.5rem] shadow-[0_24px_80px_rgba(0,45,38,0.16)] overflow-hidden border border-white bg-white/60">
                <div id="hero-slide-1" class="carousel-item relative w-full">
                    <div
                        class="w-full h-64 sm:h-96 lg:h-[520px] bg-gradient-to-br from-[#00342b] via-[#286b33] to-[#90d792] flex items-center justify-center text-white">
                        <div class="text-center px-6">
                            <div class="text-6xl sm:text-7xl lg:text-8xl mb-5">🍎🍊🍇</div>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">Fresh Fruit Sale
                            </h3>
                            <p class="mt-3 text-sm sm:text-base text-white/80">
                                Giảm giá trái cây tươi mỗi ngày
                            </p>
                        </div>
                    </div>

                    <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                        <a href="#hero-slide-3"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                        <a href="#hero-slide-2"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                    </div>
                </div>

                <div id="hero-slide-2" class="carousel-item relative w-full">
                    <div
                        class="w-full h-64 sm:h-96 lg:h-[520px] bg-gradient-to-br from-[#673700] via-[#ff9723] to-[#FFC107] flex items-center justify-center text-white">
                        <div class="text-center px-6">
                            <div class="text-6xl sm:text-7xl lg:text-8xl mb-5">🥭🍍🍌</div>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">Combo trái cây
                                nhiệt đới</h3>
                            <p class="mt-3 text-sm sm:text-base text-white/90">
                                Ảnh demo banner, sau này thay bằng ảnh upload từ admin.
                            </p>
                        </div>
                    </div>

                    <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                        <a href="#hero-slide-1"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                        <a href="#hero-slide-3"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                    </div>
                </div>

                <div id="hero-slide-3" class="carousel-item relative w-full">
                    <div
                        class="w-full h-64 sm:h-96 lg:h-[520px] bg-gradient-to-br from-[#002D26] via-[#004d40] to-[#94d3c1] flex items-center justify-center text-white">
                        <div class="text-center px-6">
                            <div class="text-6xl sm:text-7xl lg:text-8xl mb-5">🍓🍒🍉</div>
                            <h3 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">Ưu đãi cuối tuần
                            </h3>
                            <p class="mt-3 text-sm sm:text-base text-white/90">
                                Carousel dùng DaisyUI, không cần JS.
                            </p>
                        </div>
                    </div>

                    <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                        <a href="#hero-slide-2"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                        <a href="#hero-slide-1"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="products" class="bg-[#f8faf7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-[#286b33] mb-3">
                    Fresh picks
                </p>

                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-[#191c1b]">
                    <?= htmlspecialchars($homeProductTitle) ?>
                </h2>

                <p class="text-[#3f4945] mt-3 text-sm sm:text-base">
                    Hiển thị tối đa 18 sản phẩm. Sản phẩm thêm từ admin sẽ đổ ra đây.
                </p>
            </div>

            <a href="index.php?area=client&controller=product&action=index"
                class="h-11 px-5 rounded-full bg-white hover:bg-[#E8F5E9] text-[#00342b] border border-[#bfc9c4]/70 inline-flex items-center justify-center font-extrabold shadow-[0_10px_30px_rgba(0,45,38,0.07)] transition w-fit">
                Xem tất cả
            </a>
        </div>

        <?php if (!empty($productsForHome)): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <?php foreach ($productsForHome as $product): ?>
            <?php
                    $productDetailUrl = 'index.php?area=client&controller=product&action=detail&id=' . urlencode($product['id']);
                    $isOutOfStock = isset($product['stock']) && (int)$product['stock'] <= 0;
                    $hasSalePrice = !empty($product['sale_price']) && $product['sale_price'] > 0;
                    ?>

            <div
                class="group bg-white rounded-[1.75rem] overflow-hidden shadow-[0_12px_40px_rgba(0,45,38,0.08)] hover:shadow-[0_20px_55px_rgba(0,45,38,0.13)] hover:-translate-y-1 transition border border-white">
                <a href="<?= $productDetailUrl ?>" class="block">
                    <div class="h-32 sm:h-36 bg-[#E8F5E9] relative overflow-hidden">
                        <?php if (clientImageExists($product['image'] ?? '')): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-5xl">
                            🍏
                        </div>
                        <?php endif; ?>

                        <?php if ($isOutOfStock): ?>
                        <span
                            class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#ffdad6] text-[#93000a]">
                            Hết hàng
                        </span>
                        <?php elseif ($hasSalePrice): ?>
                        <span
                            class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#FFC107] text-[#2e1500]">
                            Sale
                        </span>
                        <?php endif; ?>
                    </div>
                </a>

                <div class="p-3.5">
                    <a href="<?= $productDetailUrl ?>" class="block">
                        <h3
                            class="font-extrabold text-sm leading-5 min-h-10 max-h-10 overflow-hidden text-[#191c1b] group-hover:text-[#00342b] transition">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>
                    </a>

                    <p class="text-xs text-[#3f4945] mt-1 truncate">
                        <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                    </p>

                    <div class="mt-3 min-h-10">
                        <?php if ($hasSalePrice): ?>
                        <p class="font-extrabold text-[#00342b] text-base leading-5">
                            <?= number_format($product['sale_price']) ?>đ
                        </p>

                        <p class="text-xs text-[#707975] line-through mt-1">
                            <?= number_format($product['price']) ?>đ
                        </p>
                        <?php else: ?>
                        <p class="font-extrabold text-[#00342b] text-base leading-5">
                            <?= number_format($product['price']) ?>đ
                        </p>

                        <p class="text-xs text-[#707975] mt-1">
                            / <?= htmlspecialchars($product['unit'] ?? 'kg') ?>
                        </p>
                        <?php endif; ?>
                    </div>

                    <div class="grid grid-cols-1 gap-2 mt-3">
                        <a href="<?= $productDetailUrl ?>"
                            class="h-9 rounded-full border border-[#00342b]/20 hover:bg-[#E8F5E9] text-[#00342b] inline-flex items-center justify-center text-xs font-extrabold transition">
                            Xem chi tiết
                        </a>

                        <form action="index.php?area=client&controller=cart&action=add" method="POST">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <input type="hidden" name="quantity" value="1">

                            <button type="submit"
                                class="h-9 rounded-full bg-[#002D26] hover:bg-[#00342b] text-white inline-flex items-center justify-center text-xs font-extrabold w-full transition disabled:bg-[#d8dbd8] disabled:text-[#707975]"
                                <?= $isOutOfStock ? 'disabled' : '' ?>>
                                <?= $isOutOfStock ? 'Hết hàng' : 'Thêm giỏ' ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div
            class="rounded-[2rem] bg-white border border-white shadow-[0_12px_40px_rgba(0,45,38,0.08)] p-10 text-center text-[#3f4945]">
            <div class="text-5xl mb-3">🍃</div>
            <p class="font-extrabold text-[#191c1b]">Chưa có sản phẩm active.</p>
            <p class="text-sm mt-1">Hãy thêm sản phẩm trong admin dashboard.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="relative overflow-hidden bg-[#002D26] text-white py-14 sm:py-18">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <div class="absolute top-0 left-0 w-96 h-96 rounded-full bg-[#94d3c1] blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-[#FFC107] blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-[#94d3c1] mb-3">
                    Fresh stories
                </p>

                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    <?= htmlspecialchars($homeVideoTitle) ?>
                </h2>

                <p class="text-[#eff1ef]/65 mt-3">
                    Hiển thị video short và long từ admin.
                </p>
            </div>

            <a href="index.php?area=client&controller=video&action=index"
                class="h-11 px-5 rounded-full bg-white/10 hover:bg-white hover:text-[#002D26] border border-white/15 text-white inline-flex items-center justify-center font-extrabold transition w-fit">
                Xem tất cả
            </a>
        </div>

        <?php if (!empty($shortVideosForHome)): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
            <?php foreach ($shortVideosForHome as $video): ?>
            <a href="index.php?area=client&controller=video&action=index"
                class="group rounded-[1.75rem] overflow-hidden bg-white/8 border border-white/10 hover:-translate-y-1 hover:bg-white/12 transition shadow-[0_14px_45px_rgba(0,0,0,0.14)]">
                <div class="aspect-[9/14] bg-[#00342b] relative">
                    <?php if (clientImageExists($video['thumbnail'] ?? '')): ?>
                    <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                        alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-5xl">
                        🎬
                    </div>
                    <?php endif; ?>

                    <div class="absolute inset-0 bg-gradient-to-t from-[#002D26]/70 via-transparent to-transparent">
                    </div>

                    <div
                        class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-[#FFC107] text-[#2e1500]">
                        SHORT
                    </div>
                </div>

                <div class="p-3.5">
                    <h3 class="font-extrabold text-sm leading-5 h-10 overflow-hidden">
                        <?= htmlspecialchars($video['title']) ?>
                    </h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="rounded-[2rem] bg-white/8 border border-white/10 p-10 text-center text-[#eff1ef]/65">
            Chưa có video short published.
        </div>
        <?php endif; ?>

        <div class="mt-14">
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Video dài</h2>
                    <p class="text-[#eff1ef]/65 mt-3">
                        Dạng slide carousel cho video long.
                    </p>
                </div>
            </div>

            <?php if (!empty($longVideosForHome)): ?>
            <div
                class="carousel w-full rounded-[2rem] overflow-hidden shadow-[0_24px_80px_rgba(0,0,0,0.2)] border border-white/10">
                <?php foreach ($longVideosForHome as $index => $video): ?>
                <?php
                        $currentSlide = 'long-video-' . ($index + 1);
                        $prevSlide = 'long-video-' . ($index === 0 ? count($longVideosForHome) : $index);
                        $nextSlide = 'long-video-' . ($index + 2 > count($longVideosForHome) ? 1 : $index + 2);
                        ?>

                <div id="<?= $currentSlide ?>" class="carousel-item relative w-full">
                    <div class="w-full grid grid-cols-1 lg:grid-cols-2 bg-white/8">
                        <div class="h-64 sm:h-80 lg:h-[420px] bg-[#00342b]">
                            <?php if (clientImageExists($video['thumbnail'] ?? '')): ?>
                            <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                                alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-8xl">
                                🎥
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-6 sm:p-8 lg:p-12 flex flex-col justify-center">
                            <span
                                class="w-fit px-3 py-1 rounded-full bg-[#FFC107] text-[#2e1500] text-xs font-extrabold mb-4">
                                LONG VIDEO
                            </span>

                            <h3 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                                <?= htmlspecialchars($video['title']) ?>
                            </h3>

                            <p class="text-[#eff1ef]/70 mt-4 leading-7">
                                <?= htmlspecialchars($video['description'] ?? 'Video dài giới thiệu nội dung từ admin.') ?>
                            </p>

                            <a href="index.php?area=client&controller=video&action=index"
                                class="h-11 px-5 rounded-full bg-white hover:bg-[#E8F5E9] text-[#00342b] inline-flex items-center justify-center font-extrabold w-fit mt-6 transition">
                                Xem video
                            </a>
                        </div>
                    </div>

                    <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                        <a href="#<?= $prevSlide ?>"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                        <a href="#<?= $nextSlide ?>"
                            class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="rounded-[2rem] bg-white/8 border border-white/10 p-10 text-center text-[#eff1ef]/65">
                Chưa có video long published.
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="bg-[#f8faf7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-14 sm:py-18">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-[#286b33] mb-3">
                    Journal
                </p>

                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-[#191c1b]">
                    <?= htmlspecialchars($homePostTitle) ?>
                </h2>

                <p class="text-[#3f4945] mt-3">
                    Hiển thị 6 bài viết published từ admin.
                </p>
            </div>

            <a href="index.php?area=client&controller=post&action=index"
                class="h-11 px-5 rounded-full bg-white hover:bg-[#E8F5E9] text-[#00342b] border border-[#bfc9c4]/70 inline-flex items-center justify-center font-extrabold shadow-[0_10px_30px_rgba(0,45,38,0.07)] transition w-fit">
                Xem tất cả
            </a>
        </div>

        <?php if (!empty($postsForHome)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($postsForHome as $post): ?>
            <article
                class="group bg-white rounded-[2rem] overflow-hidden shadow-[0_12px_40px_rgba(0,45,38,0.08)] hover:shadow-[0_20px_55px_rgba(0,45,38,0.13)] hover:-translate-y-1 transition border border-white">
                <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>">
                    <div class="h-56 bg-[#ffdcc1] overflow-hidden">
                        <?php if (clientImageExists($post['thumbnail'] ?? '')): ?>
                        <img src="<?= htmlspecialchars($post['thumbnail']) ?>"
                            alt="<?= htmlspecialchars($post['title']) ?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-6xl">
                            📝
                        </div>
                        <?php endif; ?>
                    </div>
                </a>

                <div class="p-5">
                    <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>">
                        <h3
                            class="text-xl font-extrabold leading-7 h-14 overflow-hidden text-[#191c1b] group-hover:text-[#00342b] transition">
                            <?= htmlspecialchars($post['title']) ?>
                        </h3>
                    </a>

                    <p class="text-sm text-[#3f4945] mt-3 leading-6 h-18 overflow-hidden">
                        <?= htmlspecialchars($post['summary'] ?? '') ?>
                    </p>

                    <div class="flex items-center justify-between mt-5">
                        <span class="text-xs text-[#707975] font-semibold">
                            👁 <?= htmlspecialchars($post['view_count'] ?? 0) ?>
                        </span>

                        <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>"
                            class="h-9 px-4 rounded-full border border-[#00342b]/20 hover:bg-[#E8F5E9] text-[#00342b] inline-flex items-center justify-center text-xs font-extrabold transition">
                            Đọc thêm
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div
            class="rounded-[2rem] bg-white border border-white shadow-[0_12px_40px_rgba(0,45,38,0.08)] p-10 text-center text-[#3f4945]">
            Chưa có bài viết published.
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="bg-[#f8faf7]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10 sm:py-14">
        <?php if (!empty($homeBottomBanners)): ?>
        <div
            class="carousel w-full rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden shadow-[0_24px_80px_rgba(0,45,38,0.16)] border border-white">
            <?php foreach ($homeBottomBanners as $index => $image): ?>
            <?php
                    $currentSlide = 'home-bottom-banner-' . ($index + 1);
                    $prevSlide = 'home-bottom-banner-' . ($index === 0 ? count($homeBottomBanners) : $index);
                    $nextSlide = 'home-bottom-banner-' . ($index + 2 > count($homeBottomBanners) ? 1 : $index + 2);
                    ?>

            <div id="<?= $currentSlide ?>" class="carousel-item relative w-full">
                <img src="<?= htmlspecialchars($image) ?>" class="w-full h-64 sm:h-80 object-cover"
                    alt="Promotion banner">

                <div class="absolute inset-0 bg-gradient-to-r from-[#002D26]/80 via-[#002D26]/35 to-transparent"></div>

                <div class="absolute inset-0 flex items-center text-white px-8 sm:px-12">
                    <div>
                        <p class="text-xs font-extrabold uppercase tracking-[0.25em] text-[#94d3c1] mb-3">
                            Promotion
                        </p>

                        <h3 class="text-3xl sm:text-5xl font-extrabold tracking-tight max-w-2xl">
                            <?= htmlspecialchars($homepageNotice) ?>
                        </h3>
                    </div>
                </div>

                <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                    <a href="#<?= $prevSlide ?>"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                    <a href="#<?= $nextSlide ?>"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div
            class="carousel w-full rounded-[2rem] sm:rounded-[2.5rem] overflow-hidden shadow-[0_24px_80px_rgba(0,45,38,0.16)] border border-white">
            <div id="promo-1" class="carousel-item relative w-full">
                <div
                    class="w-full h-64 sm:h-80 bg-gradient-to-br from-[#00342b] via-[#286b33] to-[#90d792] flex items-center justify-center text-white text-center px-8">
                    <div>
                        <div class="text-5xl sm:text-6xl mb-4">🥝🍏🍐</div>
                        <h3 class="text-3xl sm:text-5xl font-extrabold tracking-tight">Giảm 20% trái cây xanh</h3>
                        <p class="mt-3 text-white/80">Banner quảng cáo demo, sau này thay bằng ảnh thật.</p>
                    </div>
                </div>

                <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                    <a href="#promo-3"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                    <a href="#promo-2"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                </div>
            </div>

            <div id="promo-2" class="carousel-item relative w-full">
                <div
                    class="w-full h-64 sm:h-80 bg-gradient-to-br from-[#673700] via-[#ff9723] to-[#FFC107] flex items-center justify-center text-white text-center px-8">
                    <div>
                        <div class="text-5xl sm:text-6xl mb-4">🍊🍋🥭</div>
                        <h3 class="text-3xl sm:text-5xl font-extrabold tracking-tight">Combo nhiệt đới mỗi ngày</h3>
                        <p class="mt-3 text-white/80">Ảnh demo promotion section.</p>
                    </div>
                </div>

                <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                    <a href="#promo-1"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                    <a href="#promo-3"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                </div>
            </div>

            <div id="promo-3" class="carousel-item relative w-full">
                <div
                    class="w-full h-64 sm:h-80 bg-gradient-to-br from-[#002D26] via-[#004d40] to-[#94d3c1] flex items-center justify-center text-white text-center px-8">
                    <div>
                        <div class="text-5xl sm:text-6xl mb-4">🍓🍒🍉</div>
                        <h3 class="text-3xl sm:text-5xl font-extrabold tracking-tight">Ưu đãi cuối tuần</h3>
                        <p class="mt-3 text-white/80">Carousel DaisyUI không cần JS.</p>
                    </div>
                </div>

                <div class="absolute flex justify-between transform -translate-y-1/2 left-4 right-4 top-1/2">
                    <a href="#promo-2"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❮</a>
                    <a href="#promo-1"
                        class="w-10 h-10 rounded-full bg-white/85 hover:bg-white text-[#00342b] flex items-center justify-center shadow-lg">❯</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>