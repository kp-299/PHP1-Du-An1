<?php
$siteName = $settings['site_name'] ?? 'Trái Cây Tươi';
$homepageNotice = $settings['homepage_notice'] ?? 'Giảm giá trái cây tươi mỗi ngày';
$banner = $settings['banner'] ?? '';

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
?>

<!-- Hero -->
<section class="bg-gradient-to-br from-green-50 via-lime-50 to-yellow-50">
    <div
        class="max-w-7xl mx-auto px-3 sm:px-4 py-8 sm:py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-center">
        <div class="text-center sm:text-left">
            <span
                class="inline-flex px-3 sm:px-4 py-2 rounded-full bg-green-100 text-green-700 text-xs sm:text-sm font-bold mb-4 sm:mb-5">
                <?= htmlspecialchars($homepageNotice) ?>
            </span>

            <h2 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold leading-tight text-slate-950">
                Trái cây tươi ngon, giao nhanh mỗi ngày
            </h2>

            <p class="text-slate-600 mt-4 sm:mt-5 text-base sm:text-lg leading-7 sm:leading-8 max-w-xl mx-auto sm:mx-0">
                Cửa hàng chuyên cung cấp trái cây, rau củ tươi sạch. Sản phẩm được cập nhật từ admin dashboard và hiển
                thị trực tiếp ra ngoài client.
            </p>

            <div class="grid grid-cols-2 sm:flex gap-3 mt-6 sm:mt-8">
                <a href="index.php?area=client&controller=product&action=index"
                    class="btn btn-sm sm:btn-md bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl">
                    Mua ngay
                </a>

                <a href="#products" class="btn btn-sm sm:btn-md btn-outline rounded-2xl">
                    Xem sản phẩm
                </a>
            </div>
        </div>

        <div class="w-full">
            <div class="carousel w-full rounded-3xl sm:rounded-[2rem] shadow-xl overflow-hidden">
                <div id="hero-slide-1" class="carousel-item relative w-full">
                    <?php if (!empty($banner)): ?>
                        <img src="<?= htmlspecialchars($banner) ?>" class="w-full h-56 sm:h-80 lg:h-[460px] object-cover"
                            alt="Banner">
                    <?php else: ?>
                        <div
                            class="w-full h-56 sm:h-80 lg:h-[460px] bg-gradient-to-br from-green-500 to-lime-500 flex items-center justify-center text-white">
                            <div class="text-center px-6">
                                <div class="text-5xl sm:text-7xl lg:text-8xl mb-4 sm:mb-5">🍎🍊🍇</div>
                                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold">Fresh Fruit Sale</h3>
                                <p class="mt-2 sm:mt-3 text-sm sm:text-base text-white/80">
                                    Giảm giá trái cây tươi mỗi ngày
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div
                        class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                        <a href="#hero-slide-3" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                        <a href="#hero-slide-2" class="btn btn-xs sm:btn-md btn-circle">❯</a>
                    </div>
                </div>

                <div id="hero-slide-2" class="carousel-item relative w-full">
                    <div
                        class="w-full h-56 sm:h-80 lg:h-[460px] bg-gradient-to-br from-orange-400 to-yellow-400 flex items-center justify-center text-white">
                        <div class="text-center px-6">
                            <div class="text-5xl sm:text-7xl lg:text-8xl mb-4 sm:mb-5">🥭🍍🍌</div>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold">Combo trái cây nhiệt đới</h3>
                            <p class="mt-2 sm:mt-3 text-sm sm:text-base text-white/90">
                                Ảnh demo banner, sau này thay bằng ảnh upload từ admin.
                            </p>
                        </div>
                    </div>

                    <div
                        class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                        <a href="#hero-slide-1" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                        <a href="#hero-slide-3" class="btn btn-xs sm:btn-md btn-circle">❯</a>
                    </div>
                </div>

                <div id="hero-slide-3" class="carousel-item relative w-full">
                    <div
                        class="w-full h-56 sm:h-80 lg:h-[460px] bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center text-white">
                        <div class="text-center px-6">
                            <div class="text-5xl sm:text-7xl lg:text-8xl mb-4 sm:mb-5">🍓🍒🍉</div>
                            <h3 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold">Ưu đãi cuối tuần</h3>
                            <p class="mt-2 sm:mt-3 text-sm sm:text-base text-white/90">
                                Carousel dùng DaisyUI, không cần JS.
                            </p>
                        </div>
                    </div>

                    <div
                        class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                        <a href="#hero-slide-2" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                        <a href="#hero-slide-1" class="btn btn-xs sm:btn-md btn-circle">❯</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products grid -->
<section id="products" class="max-w-7xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">
                Sản phẩm nổi bật
            </h2>

            <p class="text-slate-500 mt-2 text-sm sm:text-base">
                Hiển thị tối đa 18 sản phẩm. Sản phẩm thêm từ admin sẽ đổ ra đây.
            </p>
        </div>

        <a href="index.php?area=client&controller=product&action=index"
            class="btn btn-sm sm:btn-md btn-outline rounded-2xl w-fit">
            Xem tất cả
        </a>
    </div>

    <?php if (!empty($productsForHome)): ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <?php foreach ($productsForHome as $product): ?>
                <?php
                $productDetailUrl = 'index.php?area=client&controller=product&action=detail&id=' . urlencode($product['id']);
                $isOutOfStock = isset($product['stock']) && (int) $product['stock'] <= 0;
                $hasSalePrice = !empty($product['sale_price']) && $product['sale_price'] > 0;
                ?>

                <div
                    class="group bg-white border border-slate-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md transition">
                    <!-- Product image -->
                    <a href="<?= $productDetailUrl ?>" class="block">
                        <div class="h-28 sm:h-32 bg-green-50 relative overflow-hidden">
                            <?php if (clientImageExists($product['image'] ?? '')): ?>
                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-4xl sm:text-5xl">
                                    🍏
                                </div>
                            <?php endif; ?>

                            <?php if ($isOutOfStock): ?>
                                <span
                                    class="absolute top-2 left-2 px-2 py-1 rounded-full text-[10px] sm:text-xs font-bold bg-rose-500 text-white">
                                    Hết hàng
                                </span>
                            <?php elseif ($hasSalePrice): ?>
                                <span
                                    class="absolute top-2 left-2 px-2 py-1 rounded-full text-[10px] sm:text-xs font-bold bg-orange-500 text-white">
                                    Sale
                                </span>
                            <?php endif; ?>
                        </div>
                    </a>

                    <!-- Product info -->
                    <div class="p-2.5 sm:p-3">
                        <a href="<?= $productDetailUrl ?>" class="block">
                            <h3
                                class="font-bold text-sm leading-5 min-h-10 max-h-10 overflow-hidden hover:text-green-600 transition">
                                <?= htmlspecialchars($product['name']) ?>
                            </h3>
                        </a>

                        <p class="text-xs text-slate-500 mt-1 truncate">
                            <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                        </p>

                        <div class="mt-2 min-h-10">
                            <?php if ($hasSalePrice): ?>
                                <p class="font-extrabold text-rose-500 text-sm sm:text-base leading-5">
                                    <?= number_format($product['sale_price']) ?>đ
                                </p>

                                <p class="text-xs text-slate-400 line-through">
                                    <?= number_format($product['price']) ?>đ
                                </p>
                            <?php else: ?>
                                <p class="font-extrabold text-green-600 text-sm sm:text-base leading-5">
                                    <?= number_format($product['price']) ?>đ
                                </p>

                                <p class="text-xs text-slate-400">
                                    / <?= htmlspecialchars($product['unit'] ?? 'kg') ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Actions -->
                        <div class="grid grid-cols-1 gap-2 mt-3">
                            <a href="<?= $productDetailUrl ?>" class="btn btn-xs btn-outline rounded-xl w-full">
                                Xem chi tiết
                            </a>

                            <form action="index.php?area=client&controller=cart&action=add" method="POST">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                <input type="hidden" name="quantity" value="1">

                                <button type="submit"
                                    class="btn btn-xs bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-xl w-full"
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
        <div class="rounded-3xl bg-white border border-slate-200 p-8 sm:p-10 text-center text-slate-500">
            <div class="text-5xl mb-3">🍃</div>
            <p class="font-bold text-slate-700">Chưa có sản phẩm active.</p>
            <p class="text-sm mt-1">Hãy thêm sản phẩm trong admin dashboard.</p>
        </div>
    <?php endif; ?>
</section>

<!-- Videos -->
<section class="bg-slate-950 text-white py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-3 sm:px-4">
        <div class="flex items-end justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold">Video ngắn</h2>
                <p class="text-slate-400 mt-2">
                    Hiển thị tối đa 12 video short từ admin.
                </p>
            </div>

            <a href="index.php?area=client&controller=video&action=index"
                class="btn btn-outline border-white text-white hover:bg-white hover:text-slate-950 rounded-2xl">
                Xem tất cả
            </a>
        </div>

        <?php if (!empty($shortVideosForHome)): ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                <?php foreach ($shortVideosForHome as $video): ?>
                    <a href="index.php?area=client&controller=video&action=detail&slug=<?= urlencode($video['slug']) ?>"
                        class="group rounded-3xl overflow-hidden bg-white/5 border border-white/10 hover:-translate-y-1 transition">
                        <div class="aspect-[9/14] bg-pink-950 relative">
                            <?php if (!empty($video['thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                                    alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-5xl">
                                    🎬
                                </div>
                            <?php endif; ?>

                            <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>

                            <div class="absolute top-3 left-3 px-2 py-1 rounded-full text-xs font-bold bg-pink-500">
                                SHORT
                            </div>
                        </div>

                        <div class="p-3">
                            <h3 class="font-bold text-sm leading-5 h-10 overflow-hidden">
                                <?= htmlspecialchars($video['title']) ?>
                            </h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="rounded-3xl bg-white/5 border border-white/10 p-10 text-center text-slate-400">
                Chưa có video short published.
            </div>
        <?php endif; ?>

        <div class="mt-14">
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-3xl font-extrabold">Video dài</h2>
                    <p class="text-slate-400 mt-2">
                        Dạng slide carousel cho video long.
                    </p>
                </div>
            </div>

            <?php if (!empty($longVideosForHome)): ?>
                <div class="carousel w-full rounded-3xl sm:rounded-[2rem] overflow-hidden">
                    <?php foreach ($longVideosForHome as $index => $video): ?>
                        <?php
                        $currentSlide = 'long-video-' . ($index + 1);
                        $prevSlide = 'long-video-' . ($index === 0 ? count($longVideosForHome) : $index);
                        $nextSlide = 'long-video-' . ($index + 2 > count($longVideosForHome) ? 1 : $index + 2);
                        ?>

                        <div id="<?= $currentSlide ?>" class="carousel-item relative w-full">
                            <div class="w-full grid grid-cols-1 lg:grid-cols-2 bg-white/5 border border-white/10">
                                <div class="h-64 sm:h-80 lg:h-[420px] bg-slate-900">
                                    <?php if (!empty($video['thumbnail'])): ?>
                                        <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                                            alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-8xl">
                                            🎥
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="p-6 sm:p-8 lg:p-12 flex flex-col justify-center">
                                    <span class="w-fit px-3 py-1 rounded-full bg-violet-500 text-xs font-bold mb-4">
                                        LONG VIDEO
                                    </span>

                                    <h3 class="text-2xl sm:text-3xl font-extrabold">
                                        <?= htmlspecialchars($video['title']) ?>
                                    </h3>

                                    <p class="text-slate-300 mt-4 leading-7">
                                        <?= htmlspecialchars($video['description'] ?? 'Video dài giới thiệu nội dung từ admin.') ?>
                                    </p>

                                    <a href="index.php?area=client&controller=video&action=detail&slug=<?= urlencode($video['slug']) ?>"
                                        class="btn bg-white text-slate-950 border-0 hover:bg-slate-100 rounded-2xl w-fit mt-6">
                                        Xem video
                                    </a>
                                </div>
                            </div>

                            <div
                                class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                                <a href="#<?= $prevSlide ?>" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                                <a href="#<?= $nextSlide ?>" class="btn btn-xs sm:btn-md btn-circle">❯</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="rounded-3xl bg-white/5 border border-white/10 p-10 text-center text-slate-400">
                    Chưa có video long published.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Posts -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-12 sm:py-16">
    <div class="flex items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-950">Bài viết mới</h2>
            <p class="text-slate-500 mt-2">
                Hiển thị 6 bài viết published từ admin.
            </p>
        </div>

        <a href="index.php?area=client&controller=post&action=index" class="btn btn-outline rounded-2xl">
            Xem tất cả
        </a>
    </div>

    <?php if (!empty($postsForHome)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
            <?php foreach ($postsForHome as $post): ?>
                <article
                    class="bg-white border border-slate-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md transition">
                    <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>">
                        <div class="h-52 bg-orange-50">
                            <?php if (!empty($post['thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                                    class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-6xl">
                                    📝
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>

                    <div class="p-5">
                        <h3 class="text-lg font-extrabold leading-6 h-12 overflow-hidden">
                            <?= htmlspecialchars($post['title']) ?>
                        </h3>

                        <p class="text-sm text-slate-500 mt-3 leading-6 h-18 overflow-hidden">
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
    <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có bài viết published.
        </div>
    <?php endif; ?>
</section>

<!-- Promo carousel -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
    <div class="carousel w-full rounded-3xl sm:rounded-[2rem] overflow-hidden shadow-xl">
        <div id="promo-1" class="carousel-item relative w-full">
            <div
                class="w-full h-56 sm:h-72 bg-gradient-to-r from-green-500 to-lime-500 flex items-center justify-center text-white text-center px-8">
                <div>
                    <div class="text-5xl sm:text-6xl mb-4">🥝🍏🍐</div>
                    <h3 class="text-2xl sm:text-4xl font-extrabold">Giảm 20% trái cây xanh</h3>
                    <p class="mt-3 text-white/80">Banner quảng cáo demo, sau này thay bằng ảnh thật.</p>
                </div>
            </div>

            <div
                class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                <a href="#promo-3" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                <a href="#promo-2" class="btn btn-xs sm:btn-md btn-circle">❯</a>
            </div>
        </div>

        <div id="promo-2" class="carousel-item relative w-full">
            <div
                class="w-full h-56 sm:h-72 bg-gradient-to-r from-orange-400 to-yellow-400 flex items-center justify-center text-white text-center px-8">
                <div>
                    <div class="text-5xl sm:text-6xl mb-4">🍊🍋🥭</div>
                    <h3 class="text-2xl sm:text-4xl font-extrabold">Combo nhiệt đới mỗi ngày</h3>
                    <p class="mt-3 text-white/80">Ảnh demo promotion section.</p>
                </div>
            </div>

            <div
                class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                <a href="#promo-1" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                <a href="#promo-3" class="btn btn-xs sm:btn-md btn-circle">❯</a>
            </div>
        </div>

        <div id="promo-3" class="carousel-item relative w-full">
            <div
                class="w-full h-56 sm:h-72 bg-gradient-to-r from-pink-500 to-rose-500 flex items-center justify-center text-white text-center px-8">
                <div>
                    <div class="text-5xl sm:text-6xl mb-4">🍓🍒🍉</div>
                    <h3 class="text-2xl sm:text-4xl font-extrabold">Ưu đãi cuối tuần</h3>
                    <p class="mt-3 text-white/80">Carousel DaisyUI không cần JS.</p>
                </div>
            </div>

            <div
                class="absolute flex justify-between transform -translate-y-1/2 left-3 right-3 sm:left-5 sm:right-5 top-1/2">
                <a href="#promo-2" class="btn btn-xs sm:btn-md btn-circle">❮</a>
                <a href="#promo-1" class="btn btn-xs sm:btn-md btn-circle">❯</a>
            </div>
        </div>
    </div>
</section>