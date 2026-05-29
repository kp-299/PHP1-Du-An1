<?php
$siteName = $settings['site_name'] ?? 'Trái Cây Tươi';
$footerContent = $settings['footer_content'] ?? '© 2026 Trái Cây Tươi. All rights reserved.';
?>

<footer class="bg-slate-950 text-white mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="md:col-span-2">
            <div class="flex items-center gap-3">
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-lime-500 flex items-center justify-center text-2xl">
                    🍊
                </div>

                <div>
                    <h3 class="text-2xl font-extrabold">
                        <?= htmlspecialchars($siteName) ?>
                    </h3>
                    <p class="text-slate-400 text-sm">Fresh Fruit Store</p>
                </div>
            </div>

            <p class="text-slate-400 mt-5 max-w-xl leading-7">
                <?= htmlspecialchars($footerContent) ?>
            </p>
        </div>

        <div>
            <h4 class="font-bold mb-4">Điều hướng</h4>

            <div class="space-y-3 text-slate-400">
                <a class="block hover:text-white" href="index.php?area=client&controller=pages&action=home">Trang
                    chủ</a>
                <a class="block hover:text-white" href="index.php?area=client&controller=product&action=index">Sản
                    phẩm</a>
                <a class="block hover:text-white" href="index.php?area=client&controller=post&action=index">Bài viết</a>
                <a class="block hover:text-white" href="index.php?area=client&controller=video&action=index">Video</a>
            </div>
        </div>

        <div>
            <h4 class="font-bold mb-4">Thông tin</h4>

            <div class="space-y-3 text-slate-400">
                <a class="block hover:text-white" href="index.php?area=client&controller=pages&action=contact">Liên
                    hệ</a>
                <a class="block hover:text-white" href="index.php?area=client&controller=pages&action=privacy">Chính
                    sách</a>
                <a class="block hover:text-white" href="index.php?area=client&controller=pages&action=terms">Điều
                    khoản</a>
                <a class="block hover:text-white"
                    href="index.php?area=admin&controller=dashboard&action=index">Admin</a>
            </div>
        </div>
    </div>
</footer>