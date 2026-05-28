<div class="min-h-screen bg-slate-50 text-slate-900">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between gap-4">
            <a href="index.php?area=client&controller=pages&action=home" class="flex items-center gap-3">
                <?php if (!empty($settings['logo'])): ?>
                <img src="<?= htmlspecialchars($settings['logo']) ?>" alt="Logo"
                    class="w-12 h-12 rounded-2xl object-cover">
                <?php else: ?>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 flex items-center justify-center text-2xl">
                    🍊
                </div>
                <?php endif; ?>

                <div>
                    <h1 class="text-xl font-extrabold">
                        <?= htmlspecialchars($settings['site_name'] ?? 'Trái Cây Tươi') ?>
                    </h1>
                    <p class="text-sm text-slate-500">
                        Website bán trái cây demo
                    </p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold">
                <a href="index.php?area=client&controller=pages&action=home" class="hover:text-green-600">
                    Trang chủ
                </a>

                <a href="index.php?area=client&controller=product&action=index" class="hover:text-green-600">
                    Sản phẩm
                </a>

                <a href="#posts" class="hover:text-green-600">
                    Bài viết
                </a>

                <a href="#videos" class="hover:text-green-600">
                    Video
                </a>

                <a href="index.php?area=client&controller=pages&action=contact" class="hover:text-green-600">
                    Liên hệ
                </a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="index.php?area=client&controller=cart&action=index" class="btn btn-outline rounded-2xl">
                    🛒 Giỏ hàng
                    <span class="badge badge-success text-white">
                        <?= $cartTotalQuantity ?? 0 ?>
                    </span>
                </a>

                <a href="index.php?area=client&controller=auth&action=login"
                    class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl">
                    Đăng nhập
                </a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-br from-green-500 via-lime-500 to-yellow-400">
        <div class="max-w-7xl mx-auto px-4 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="text-white">
                <span class="inline-flex px-4 py-2 rounded-full bg-white/20 text-sm font-bold mb-5">
                    <?= htmlspecialchars($settings['homepage_notice'] ?? 'Trái cây tươi mỗi ngày') ?>
                </span>

                <h2 class="text-4xl lg:text-6xl font-extrabold leading-tight">
                    Trái cây tươi ngon cho mọi nhà
                </h2>

                <p class="text-white/90 mt-5 text-lg leading-8">
                    Trang home này đang test toàn bộ dữ liệu từ controller:
                    sản phẩm, danh mục, bài viết, video, settings và giỏ hàng.
                </p>

                <div class="flex flex-wrap gap-3 mt-8">
                    <a href="index.php?area=client&controller=product&action=index"
                        class="btn bg-white text-green-700 border-0 hover:bg-slate-100 rounded-2xl">
                        Xem sản phẩm
                    </a>

                    <a href="#debug"
                        class="btn btn-outline border-white text-white hover:bg-white hover:text-green-700 rounded-2xl">
                        Xem biến test
                    </a>
                </div>
            </div>

            <div>
                <?php if (!empty($settings['banner'])): ?>
                <img src="<?= htmlspecialchars($settings['banner']) ?>" alt="Banner"
                    class="w-full rounded-[2rem] shadow-2xl object-cover max-h-[420px]">
                <?php else: ?>
                <div class="rounded-[2rem] bg-white/20 border border-white/30 p-10 text-center text-white shadow-2xl">
                    <div class="text-8xl mb-6">🍎🍊🍇</div>
                    <h3 class="text-3xl font-extrabold">Fresh Fruit Store</h3>
                    <p class="mt-3 text-white/80">Chưa có banner trong web_settings.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Stats test -->
    <section class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-slate-500">Danh mục</p>
                    <h3 class="text-3xl font-extrabold"><?= count($categories ?? []) ?></h3>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-slate-500">Sản phẩm mới</p>
                    <h3 class="text-3xl font-extrabold"><?= count($latestProducts ?? []) ?></h3>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-slate-500">Bài viết</p>
                    <h3 class="text-3xl font-extrabold"><?= count($posts ?? []) ?></h3>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-slate-500">Video</p>
                    <h3 class="text-3xl font-extrabold"><?= count($videos ?? []) ?></h3>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-slate-500">Giỏ hàng</p>
                    <h3 class="text-3xl font-extrabold"><?= $cartTotalQuantity ?? 0 ?></h3>
                    <p class="text-sm text-green-600 font-bold">
                        <?= number_format($cartTotalAmount ?? 0) ?>đ
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="max-w-7xl mx-auto px-4 py-14">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-extrabold">Danh mục sản phẩm</h2>
                <p class="text-slate-500 mt-2">Test biến $categories từ Category::getActive()</p>
            </div>
        </div>

        <?php if (!empty($categories)): ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php foreach ($categories as $category): ?>
            <a href="index.php?area=client&controller=product&action=index&category=<?= urlencode($category['slug']) ?>"
                class="card bg-white shadow-sm border border-slate-200 rounded-3xl hover:-translate-y-1 transition">
                <div class="card-body items-center text-center">
                    <?php if (!empty($category['image'])): ?>
                    <img src="<?= htmlspecialchars($category['image']) ?>"
                        alt="<?= htmlspecialchars($category['name']) ?>" class="w-20 h-20 rounded-3xl object-cover">
                    <?php else: ?>
                    <div class="w-20 h-20 rounded-3xl bg-green-50 flex items-center justify-center text-4xl">
                        🗂️
                    </div>
                    <?php endif; ?>

                    <h3 class="font-bold mt-2">
                        <?= htmlspecialchars($category['name']) ?>
                    </h3>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có danh mục active.
        </div>
        <?php endif; ?>
    </section>

    <!-- Latest products -->
    <section class="max-w-7xl mx-auto px-4 py-14">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-extrabold">Sản phẩm mới nhất</h2>
                <p class="text-slate-500 mt-2">Test biến $latestProducts từ Product::getLatest(8)</p>
            </div>

            <a href="index.php?area=client&controller=product&action=index" class="btn btn-outline rounded-2xl">
                Xem tất cả
            </a>
        </div>

        <?php if (!empty($latestProducts)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ($latestProducts as $product): ?>
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl overflow-hidden">
                <figure class="bg-green-50 h-56">
                    <?php if (!empty($product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-7xl">
                        🍏
                    </div>
                    <?php endif; ?>
                </figure>

                <div class="card-body">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="card-title text-lg">
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>

                        <span class="badge badge-success text-white">
                            <?= htmlspecialchars($product['unit'] ?? 'kg') ?>
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">
                        <?= htmlspecialchars($product['category_name'] ?? '') ?>
                    </p>

                    <div class="flex items-end justify-between gap-3 mt-2">
                        <div>
                            <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
                            <p class="text-rose-500 font-extrabold text-xl">
                                <?= number_format($product['sale_price']) ?>đ
                            </p>
                            <p class="text-sm text-slate-400 line-through">
                                <?= number_format($product['price']) ?>đ
                            </p>
                            <?php else: ?>
                            <p class="text-green-600 font-extrabold text-xl">
                                <?= number_format($product['price']) ?>đ
                            </p>
                            <?php endif; ?>
                        </div>

                        <a href="index.php?area=client&controller=product&action=detail&slug=<?= urlencode($product['slug']) ?>"
                            class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-xl">
                            Xem
                        </a>
                    </div>

                    <form action="index.php?area=client&controller=cart&action=add" method="POST" class="mt-3">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" name="quantity" value="1">

                        <button
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl w-full">
                            Thêm vào giỏ
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có sản phẩm active.
        </div>
        <?php endif; ?>
    </section>

    <!-- Posts -->
    <section id="posts" class="max-w-7xl mx-auto px-4 py-14">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-extrabold">Bài viết mới</h2>
                <p class="text-slate-500 mt-2">Test biến $posts từ Post::getPublished(6)</p>
            </div>
        </div>

        <?php if (!empty($posts)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php foreach ($posts as $post): ?>
            <article class="card bg-white shadow-sm border border-slate-200 rounded-3xl overflow-hidden">
                <figure class="h-48 bg-orange-50">
                    <?php if (!empty($post['thumbnail'])): ?>
                    <img src="<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>"
                        class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-6xl">
                        📝
                    </div>
                    <?php endif; ?>
                </figure>

                <div class="card-body">
                    <h3 class="card-title">
                        <?= htmlspecialchars($post['title']) ?>
                    </h3>

                    <p class="text-sm text-slate-500 line-clamp-3">
                        <?= htmlspecialchars($post['summary'] ?? '') ?>
                    </p>

                    <div class="flex items-center justify-between mt-3">
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

    <!-- Videos -->
    <section id="videos" class="max-w-7xl mx-auto px-4 py-14">
        <div class="flex items-end justify-between gap-4 mb-6">
            <div>
                <h2 class="text-3xl font-extrabold">Video mới</h2>
                <p class="text-slate-500 mt-2">Test biến $videos từ Video::getPublished(6)</p>
            </div>
        </div>

        <?php if (!empty($videos)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <?php foreach ($videos as $video): ?>
            <article class="card bg-white shadow-sm border border-slate-200 rounded-3xl overflow-hidden">
                <figure class="h-48 bg-pink-50 relative">
                    <?php if (!empty($video['thumbnail'])): ?>
                    <img src="<?= htmlspecialchars($video['thumbnail']) ?>"
                        alt="<?= htmlspecialchars($video['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center text-6xl">
                        🎬
                    </div>
                    <?php endif; ?>

                    <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-xs font-bold bg-white/90">
                        <?= htmlspecialchars($video['video_type']) ?>
                    </span>
                </figure>

                <div class="card-body">
                    <h3 class="card-title">
                        <?= htmlspecialchars($video['title']) ?>
                    </h3>

                    <p class="text-sm text-slate-500 line-clamp-3">
                        <?= htmlspecialchars($video['description'] ?? '') ?>
                    </p>

                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs text-slate-400">
                            👁 <?= htmlspecialchars($video['view_count'] ?? 0) ?>
                        </span>

                        <a href="index.php?area=client&controller=video&action=detail&slug=<?= urlencode($video['slug']) ?>"
                            class="btn btn-sm btn-outline rounded-xl">
                            Xem video
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
            Chưa có video published.
        </div>
        <?php endif; ?>
    </section>

    <!-- Debug variables -->
    <section id="debug" class="max-w-7xl mx-auto px-4 py-14">
        <div class="card bg-slate-900 text-white rounded-3xl shadow-xl">
            <div class="card-body">
                <h2 class="text-2xl font-extrabold">Debug biến từ Controller</h2>
                <p class="text-slate-300">
                    Mục này để test nhanh toàn bộ biến đang truyền xuống view.
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-5">
                    <div class="rounded-2xl bg-white/10 p-5">
                        <h3 class="font-bold mb-3">Settings</h3>
                        <pre class="text-xs overflow-auto max-h-80"><?php print_r($settings ?? []); ?></pre>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-5">
                        <h3 class="font-bold mb-3">Cart</h3>
                        <pre class="text-xs overflow-auto max-h-80"><?php print_r([
                                                                        'cartItems' => $cartItems ?? [],
                                                                        'cartTotalQuantity' => $cartTotalQuantity ?? 0,
                                                                        'cartTotalAmount' => $cartTotalAmount ?? 0,
                                                                    ]); ?></pre>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-5">
                        <h3 class="font-bold mb-3">Categories</h3>
                        <pre class="text-xs overflow-auto max-h-80"><?php print_r($categories ?? []); ?></pre>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-5">
                        <h3 class="font-bold mb-3">Latest Products</h3>
                        <pre class="text-xs overflow-auto max-h-80"><?php print_r($latestProducts ?? []); ?></pre>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-5">
                        <h3 class="font-bold mb-3">Posts</h3>
                        <pre class="text-xs overflow-auto max-h-80"><?php print_r($posts ?? []); ?></pre>
                    </div>

                    <div class="rounded-2xl bg-white/10 p-5">
                        <h3 class="font-bold mb-3">Videos</h3>
                        <pre class="text-xs overflow-auto max-h-80"><?php print_r($videos ?? []); ?></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-white mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-2xl font-extrabold">
                    <?= htmlspecialchars($settings['site_name'] ?? 'Trái Cây Tươi') ?>
                </h3>
                <p class="text-slate-400 mt-2">
                    <?= htmlspecialchars($settings['footer_content'] ?? '© 2026 Trái Cây Tươi') ?>
                </p>
            </div>

            <a href="index.php?area=admin&controller=dashboard&action=index"
                class="btn btn-outline border-white text-white hover:bg-white hover:text-slate-900 rounded-2xl">
                Vào admin
            </a>
        </div>
    </footer>
</div>