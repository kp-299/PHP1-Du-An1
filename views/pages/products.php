<?php
$queryBase = [
    'area' => 'client',
    'controller' => 'product',
    'action' => 'index',
    'keyword' => $filters['keyword'] ?? '',
    'category' => $filters['category'] ?? '',
    'stock_filter' => $filters['stock_filter'] ?? '',
    'sort' => $filters['sort'] ?? 'newest',
];

function productPageUrl($queryBase, $page)
{
    $queryBase['page'] = $page;
    return 'index.php?' . http_build_query($queryBase);
}

function productFilterUrl($params = [])
{
    $base = [
        'area' => 'client',
        'controller' => 'product',
        'action' => 'index',
    ];

    return 'index.php?' . http_build_query(array_merge($base, $params));
}

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
?>

<!-- Hero product -->
<section class="bg-gradient-to-br from-green-50 via-lime-50 to-yellow-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-8 sm:py-12">
        <div class="carousel w-full rounded-3xl overflow-hidden shadow-sm border border-green-100">
            <div id="product-hero-1" class="carousel-item relative w-full">
                <div
                    class="w-full min-h-56 sm:min-h-72 bg-gradient-to-r from-green-500 to-lime-500 text-white flex items-center justify-center px-6">
                    <div class="text-center max-w-2xl">
                        <div class="text-5xl sm:text-7xl mb-4">🍎🍊🍇</div>
                        <h1 class="text-3xl sm:text-5xl font-extrabold">
                            Sản phẩm tươi mỗi ngày
                        </h1>
                        <p class="mt-3 text-white/90">
                            Lọc, tìm kiếm, sắp xếp và mua sản phẩm được quản lý từ admin dashboard.
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
    </div>
</section>

<!-- Product listing -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-10 sm:py-14">
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-950">
                <?= !empty($currentCategory) ? htmlspecialchars($currentCategory['name']) : 'Tất cả sản phẩm' ?>
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
            <div class="sticky top-24 space-y-5">
                <div class="bg-white border border-slate-200 rounded-3xl p-5">
                    <h3 class="font-extrabold text-lg mb-4">Danh mục</h3>

                    <div class="space-y-2">
                        <a href="<?= productFilterUrl([
                                        'keyword' => $filters['keyword'] ?? '',
                                        'stock_filter' => $filters['stock_filter'] ?? '',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="block px-4 py-3 rounded-2xl font-semibold <?= empty($filters['category']) ? 'bg-green-500 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Tất cả
                        </a>

                        <?php foreach (($categories ?? []) as $category): ?>
                            <a href="<?= productFilterUrl([
                                            'category' => $category['slug'],
                                            'keyword' => $filters['keyword'] ?? '',
                                            'stock_filter' => $filters['stock_filter'] ?? '',
                                            'sort' => $filters['sort'] ?? 'newest',
                                        ]) ?>"
                                class="block px-4 py-3 rounded-2xl font-semibold <?= ($filters['category'] ?? '') === $category['slug'] ? 'bg-green-500 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                                <?= htmlspecialchars($category['name']) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-3xl p-5">
                    <h3 class="font-extrabold text-lg mb-4">Tình trạng</h3>

                    <div class="space-y-2">
                        <a href="<?= productFilterUrl([
                                        'category' => $filters['category'] ?? '',
                                        'keyword' => $filters['keyword'] ?? '',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="block px-4 py-3 rounded-2xl font-semibold <?= empty($filters['stock_filter']) ? 'bg-slate-900 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Tất cả
                        </a>

                        <a href="<?= productFilterUrl([
                                        'category' => $filters['category'] ?? '',
                                        'keyword' => $filters['keyword'] ?? '',
                                        'stock_filter' => 'in_stock',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="block px-4 py-3 rounded-2xl font-semibold <?= ($filters['stock_filter'] ?? '') === 'in_stock' ? 'bg-green-500 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
                            Còn hàng
                        </a>

                        <a href="<?= productFilterUrl([
                                        'category' => $filters['category'] ?? '',
                                        'keyword' => $filters['keyword'] ?? '',
                                        'stock_filter' => 'out_of_stock',
                                        'sort' => $filters['sort'] ?? 'newest',
                                    ]) ?>"
                            class="block px-4 py-3 rounded-2xl font-semibold <?= ($filters['stock_filter'] ?? '') === 'out_of_stock' ? 'bg-rose-500 text-white' : 'hover:bg-slate-100 text-slate-700' ?>">
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
                        <div
                            class="bg-white border border-slate-200 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md transition group">
                            <a
                                href="index.php?area=client&controller=product&action=detail&id=<?= urlencode($product['id']) ?>">
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

                                    <?php if (($product['stock'] ?? 0) <= 0): ?>
                                        <span
                                            class="absolute top-2 left-2 px-2 py-1 rounded-full text-xs font-bold bg-rose-500 text-white">
                                            Hết
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>

                            <div class="p-2.5 sm:p-3">
                                <a
                                    href="index.php?area=client&controller=product&action=detail&id=<?= urlencode($product['id']) ?>">
                                    <h3
                                        class="font-bold text-sm leading-5 h-10 overflow-hidden hover:text-green-600 transition">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h3>
                                </a>

                                <p class="text-xs text-slate-500 mt-1">
                                    <?= htmlspecialchars($product['category_name'] ?? 'Sản phẩm') ?>
                                </p>

                                <div class="mt-2">
                                    <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
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
                                    <?php endif; ?>
                                </div>

                                <div class="grid grid-cols-1 gap-2 mt-3">
                                    <a href="index.php?area=client&controller=product&action=detail&id=<?= urlencode($product['id']) ?>"
                                        class="btn btn-xs btn-outline rounded-xl w-full">
                                        Xem chi tiết
                                    </a>

                                    <form action="index.php?area=client&controller=cart&action=add" method="POST">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                                        <input type="hidden" name="quantity" value="1">

                                        <button
                                            class="btn btn-xs bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-xl w-full"
                                            <?= (($product['stock'] ?? 0) <= 0) ? 'disabled' : '' ?>>
                                            Thêm giỏ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-10">
                    <div class="join">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="<?= productPageUrl($queryBase, $i) ?>"
                                class="join-item btn <?= (int) $page === $i ? 'bg-green-500 text-white border-green-500' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
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
                    <?= $brand ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Posts -->
<section class="max-w-7xl mx-auto px-3 sm:px-4 py-14">
    <div class="flex items-end justify-between gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-950">Bài viết mới</h2>
            <p class="text-slate-500 mt-2">Thông tin hữu ích về trái cây và dinh dưỡng.</p>
        </div>

        <a href="index.php?area=client&controller=post&action=index" class="btn btn-outline rounded-2xl">
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
                            <?php if (!empty($post['thumbnail'])): ?>
                                <img src="<?= htmlspecialchars($post['thumbnail']) ?>" class="w-full h-full object-cover"
                                    alt="<?= htmlspecialchars($post['title']) ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-6xl">📝</div>
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

                        <a href="index.php?area=client&controller=post&action=detail&slug=<?= urlencode($post['slug']) ?>"
                            class="btn btn-sm btn-outline rounded-xl mt-5">
                            Đọc thêm
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>