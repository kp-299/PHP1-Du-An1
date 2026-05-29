<?php
$settings = $settings ?? [];

$queryBase = [
    'area' => 'client',
    'controller' => 'product',
    'action' => 'index',
    'keyword' => $filters['keyword'] ?? '',
    'category' => $filters['category'] ?? '',
    'stock_filter' => $filters['stock_filter'] ?? '',
    'sort' => $filters['sort'] ?? 'newest',
];

if (!function_exists('productPageUrl')) {
    function productPageUrl($queryBase, $page)
    {
        $queryBase['page'] = $page;
        return 'index.php?' . http_build_query($queryBase);
    }
}

if (!function_exists('productFilterUrl')) {
    function productFilterUrl($params = [])
    {
        $base = [
            'area' => 'client',
            'controller' => 'product',
            'action' => 'index',
        ];

        return 'index.php?' . http_build_query(array_merge($base, $params));
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

$productHeaderBanners = settingJsonArray($settings, 'product_header_banners');

$productHeroTitle = $settings['product_hero_title'] ?? 'Sản phẩm tươi mỗi ngày';
$productHeroSubtitle = $settings['product_hero_subtitle'] ?? 'Lọc, tìm kiếm, sắp xếp và mua sản phẩm được quản lý từ admin dashboard.';
$productSectionTitle = !empty($currentCategory) ? $currentCategory['name'] : ($settings['product_section_title'] ?? 'Tất cả sản phẩm');
?>

<!-- Hero product -->
<section class="bg-gradient-to-br from-green-50 via-lime-50 to-yellow-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-8 sm:py-12">
        <?php if (!empty($productHeaderBanners)): ?>
            <div class="carousel w-full rounded-3xl overflow-hidden shadow-sm border border-green-100">
                <?php foreach ($productHeaderBanners as $index => $image): ?>
                    <?php
                    $currentSlide = 'product-hero-banner-' . ($index + 1);
                    $prevSlide = 'product-hero-banner-' . ($index === 0 ? count($productHeaderBanners) : $index);
                    $nextSlide = 'product-hero-banner-' . ($index + 2 > count($productHeaderBanners) ? 1 : $index + 2);
                    ?>

                    <div id="<?= $currentSlide ?>" class="carousel-item relative w-full">
                        <img src="<?= htmlspecialchars($image) ?>" alt="Product banner"
                            class="w-full h-56 sm:h-72 lg:h-80 object-cover">

                        <div class="absolute inset-0 bg-black/30"></div>

                        <div class="absolute inset-0 flex items-center justify-center text-center px-6 text-white">
                            <div class="max-w-2xl">
                                <h1 class="text-3xl sm:text-5xl font-extrabold">
                                    <?= htmlspecialchars($productHeroTitle) ?>
                                </h1>

                                <p class="mt-3 text-white/90 leading-7">
                                    <?= htmlspecialchars($productHeroSubtitle) ?>
                                </p>
                            </div>
                        </div>

                        <div class="absolute flex justify-between left-3 right-3 top-1/2 -translate-y-1/2">
                            <a href="#<?= $prevSlide ?>" class="btn btn-sm sm:btn-md btn-circle">❮</a>
                            <a href="#<?= $nextSlide ?>" class="btn btn-sm sm:btn-md btn-circle">❯</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="carousel w-full rounded-3xl overflow-hidden shadow-sm border border-green-100">
                <div id="product-hero-1" class="carousel-item relative w-full">
                    <div
                        class="w-full min-h-56 sm:min-h-72 site-gradient-bg text-white flex items-center justify-center px-6">
                        <div class="text-center max-w-2xl">
                            <div class="text-5xl sm:text-7xl mb-4">🍎🍊🍇</div>
                            <h1 class="text-3xl sm:text-5xl font-extrabold">
                                <?= htmlspecialchars($productHeroTitle) ?>
                            </h1>
                            <p class="mt-3 text-white/90">
                                <?= htmlspecialchars($productHeroSubtitle) ?>
                            </p>
                        </div>
                    </div>

                    <div class="absolute flex justify-between left-3 right-3 top-1/2 -translate-y-1/2">
                        <a href="#product-hero-3" class="btn btn-sm sm:btn-md btn-circle">❮</a>
                        <a href="#product-hero-2" class="btn btn-sm sm:btn-md btn-circle">❯</a>
                    </div>
                </div>

                <div id="product-hero-2" class="carousel-item relative w-full">
                    <div
                        class="w-full min-h-56 sm:min-h-72 bg-gradient-to-r from-orange-400 to-yellow-400 text-white flex items-center justify-center px-6">
                        <div class="text-center max-w-2xl">
                            <div class="text-5xl sm:text-7xl mb-4">🥭🍍🍌</div>
                            <h2 class="text-3xl sm:text-5xl font-extrabold">
                                Combo trái cây nhiệt đới
                            </h2>
                            <p class="mt-3 text-white/90">
                                Banner demo khuyến mãi, sau này có thể thay bằng ảnh thật.
                            </p>
                        </div>
                    </div>

                    <div class="absolute flex justify-between left-3 right-3 top-1/2 -translate-y-1/2">
                        <a href="#product-hero-1" class="btn btn-sm sm:btn-md btn-circle">❮</a>
                        <a href="#product-hero-3" class="btn btn-sm sm:btn-md btn-circle">❯</a>
                    </div>
                </div>

                <div id="product-hero-3" class="carousel-item relative w-full">
                    <div
                        class="w-full min-h-56 sm:min-h-72 bg-gradient-to-r from-pink-500 to-rose-500 text-white flex items-center justify-center px-6">
                        <div class="text-center max-w-2xl">
                            <div class="text-5xl sm:text-7xl mb-4">🍓🍒🍉</div>
                            <h2 class="text-3xl sm:text-5xl font-extrabold">
                                Ưu đãi cuối tuần
                            </h2>
                            <p class="mt-3 text-white/90">
                                Mua nhiều giảm nhiều, giao nhanh tận nơi.
                            </p>
                        </div>
                    </div>

                    <div class="absolute flex justify-between left-3 right-3 top-1/2 -translate-y-1/2">
                        <a href="#product-hero-2" class="btn btn-sm sm:btn-md btn-circle">❮</a>
                        <a href="#product-hero-1" class="btn btn-sm sm:btn-md btn-circle">❯</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Product listing -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-950">
                <?= htmlspecialchars($productSectionTitle) ?>
            </h1>

            <p class="text-slate-500 mt-2">
                Tìm thấy <?= htmlspecialchars($totalProducts ?? 0) ?> sản phẩm.
            </p>
        </div>

        <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3 w-full lg:max-w-3xl">
            <input type="hidden" name="area" value="client">
            <input type="hidden" name="controller" value="product">
            <input type="hidden" name="action" value="index">
            <input type="hidden" name="category" value="<?= htmlspecialchars($filters['category'] ?? '') ?>">
            <input type="hidden" name="stock_filter" value="<?= htmlspecialchars($filters['stock_filter'] ?? '') ?>">

            <input type="text" name="keyword" class="input input-bordered rounded-2xl w-full sm:col-span-2"
                placeholder="Tìm sản phẩm..." value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">

            <select name="sort" class="select select-bordered rounded-2xl w-full">
                <option value="newest" <?= ($filters['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                <option value="oldest" <?= ($filters['sort'] ?? '') === 'oldest' ? 'selected' : '' ?>>Cũ nhất</option>
                <option value="price_asc" <?= ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' ?>>Giá tăng
                </option>
                <option value="price_desc" <?= ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' ?>>Giá giảm
                </option>
            </select>

            <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                Lọc
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Sidebar -->
        <aside class="lg:col-span-3 xl:col-span-2">
            <div class="lg:sticky lg:top-24 space-y-5">
                <div class="bg-white border border-slate-200 rounded-3xl p-5">
                    <h3 class="font-extrabold text-lg mb-4">Danh mục</h3>

                    <div
                        class="flex lg:block gap-2 overflow-x-auto lg:overflow-visible pb-2 lg:pb-0 space-y-0 lg:space-y-2">
                        <a href="<?= productFilterUrl([
                                        'keyword' => $filters['keyword'] ?? '',
                                        'stock_filter' => $filters['stock_filter'] ?? '',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="shrink-0 block px-4 py-3 rounded-2xl font-semibold <?= empty($filters['category']) ? 'site-primary-bg text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Tất cả
                        </a>

                        <?php foreach (($categories ?? []) as $category): ?>
                            <a href="<?= productFilterUrl([
                                            'category' => $category['slug'],
                                            'keyword' => $filters['keyword'] ?? '',
                                            'stock_filter' => $filters['stock_filter'] ?? '',
                                            'sort' => $filters['sort'] ?? 'newest',
                                        ]) ?>"
                                class="shrink-0 block px-4 py-3 rounded-2xl font-semibold <?= ($filters['category'] ?? '') === $category['slug'] ? 'site-primary-bg text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-5">
                    <h3 class="font-extrabold text-lg mb-4">Tình trạng</h3>

                    <div class="grid grid-cols-3 lg:grid-cols-1 gap-2">
                        <a href="<?= productFilterUrl([
                                        'category' => $filters['category'] ?? '',
                                        'keyword' => $filters['keyword'] ?? '',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="text-center lg:text-left block px-3 lg:px-4 py-3 rounded-2xl font-semibold <?= empty($filters['stock_filter']) ? 'bg-slate-900 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Tất cả
                        </a>

                        <a href="<?= productFilterUrl([
                                        'category' => $filters['category'] ?? '',
                                        'keyword' => $filters['keyword'] ?? '',
                                        'stock_filter' => 'in_stock',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="text-center lg:text-left block px-3 lg:px-4 py-3 rounded-2xl font-semibold <?= ($filters['stock_filter'] ?? '') === 'in_stock' ? 'site-primary-bg text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Còn hàng
                        </a>

                        <a href="<?= productFilterUrl([
                                        'category' => $filters['category'] ?? '',
                                        'keyword' => $filters['keyword'] ?? '',
                                        'stock_filter' => 'out_of_stock',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="text-center lg:text-left block px-3 lg:px-4 py-3 rounded-2xl font-semibold <?= ($filters['stock_filter'] ?? '') === 'out_of_stock' ? 'bg-rose-500 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Hết hàng
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Product grid -->
        <div class="lg:col-span-9 xl:col-span-10">
            <?php if (!empty($products)): ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">
                    <?php foreach ($products as $product): ?>
                        <?php
                        $productDetailUrl = 'index.php?area=client&controller=product&action=detail&id=' . urlencode($product['id']);
                        $isOutOfStock = isset($product['stock']) && (int)$product['stock'] <= 0;
                        $hasSalePrice = !empty($product['sale_price']) && $product['sale_price'] > 0;
                        ?>

                        <div
                            class="bg-white border border-slate-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md transition group">
                            <a href="<?= $productDetailUrl ?>">
                                <div class="h-28 sm:h-32 bg-green-50 relative overflow-hidden">
                                    <?php if (clientImageExists($product['image'] ?? '')): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>"
                                            alt="<?= htmlspecialchars($product['name']) ?>"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-5xl">
                                            🍏
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($isOutOfStock): ?>
                                        <span
                                            class="absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-bold bg-rose-500 text-white">
                                            Hết
                                        </span>
                                    <?php elseif ($hasSalePrice): ?>
                                        <span
                                            class="absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-bold bg-orange-500 text-white">
                                            Sale
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <div class="p-2.5 sm:p-3">
                                <a href="<?= $productDetailUrl ?>">
                                    <h3
                                        class="font-bold text-sm leading-5 h-10 overflow-hidden hover:text-green-600 transition">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>
                                </a>

                                <p class="text-xs text-slate-500 mt-1 truncate">
                                    <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                                </p>

                                <div class="mt-2 min-h-10">
                                    <?php if ($hasSalePrice): ?>
                                        <p class="font-extrabold text-rose-500 text-sm">
                                            <?= number_format($product['sale_price']) ?>đ
                                        </p>

                                        <p class="text-xs text-slate-400 line-through">
                                            <?= number_format($product['price']) ?>đ
                                        </p>
                                    <?php else: ?>
                                        <p class="font-extrabold text-green-600 text-sm">
                                            <?= number_format($product['price']) ?>đ
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            / <?= htmlspecialchars($product['unit'] ?? 'kg') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

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

                <?php if (($totalPages ?? 1) > 1): ?>
                    <div class="flex justify-center mt-10 overflow-x-auto">
                        <div class="join">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="<?= productPageUrl($queryBase, $i) ?>"
                                    class="join-item btn <?= (int)$page === $i ? 'site-primary-bg text-white border-0' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center">
                    <div class="text-6xl mb-4">🍃</div>
                    <h3 class="text-2xl font-extrabold">Không tìm thấy sản phẩm</h3>
                    <p class="text-slate-500 mt-2">Thử đổi bộ lọc hoặc từ khóa tìm kiếm.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Brand logos -->
<section class="bg-white border-y border-slate-200">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-10">
        <p class="text-center text-slate-500 font-semibold mb-6">Đối tác và thương hiệu tin dùng</p>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php foreach (['FreshCo', 'GreenFarm', 'FruitBox', 'Organic+', 'VitaFarm', 'Nature'] as $brand): ?>
                <div
                    class="h-20 rounded-3xl bg-slate-50 border border-slate-200 flex items-center justify-center font-extrabold text-slate-400">
                    <?= htmlspecialchars($brand) ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Posts -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-14">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950">Bài viết mới</h2>
            <p class="text-slate-500 mt-2">Thông tin hữu ích về trái cây và dinh dưỡng.</p>
        </div>

        <a href="index.php?area=client&controller=post&action=index"
            class="btn btn-sm sm:btn-md btn-outline rounded-2xl w-fit">
            Xem tất cả
        </a>
    </div>

    <?php if (!empty($posts)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($posts as $post): ?>
                <article
                    class="bg-white border border-slate-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md transition">
                    <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>">
                        <div class="h-52 bg-orange-50">
                            <?php if (clientImageExists($post['thumbnail'] ?? '')): ?>
                                <img src="<?= htmlspecialchars($post['thumbnail']) ?>" class="w-full h-full object-cover"
                                    alt="<?= htmlspecialchars($post['title']) ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-6xl">📝</div>
                            <?php endif; ?>
                        </div>
                    </a>

                    <div class="p-5">
                        <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>">
                            <h3 class="text-lg font-extrabold leading-6 h-12 overflow-hidden hover:text-green-600 transition">
                                <?= htmlspecialchars($post['title']) ?>
                            </h3>
                        </a>

                        <p class="text-sm text-slate-500 mt-3 leading-6 h-18 overflow-hidden">
                            <?= htmlspecialchars($post['summary'] ?? '') ?>
                        </p>

                        <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>"
                            class="btn btn-sm btn-outline rounded-xl mt-5">
                            Đọc thêm
                        </a>
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