<?php
$settings = $settings ?? [];

$siteName = $settings['site_name'] ?? 'Trái Cây Tươi';
$siteSubtitle = $settings['site_subtitle'] ?? 'Fresh Fruit Store';
$logo = $settings['logo'] ?? '';

$footerContent = $settings['footer_content'] ?? '© 2026 Trái Cây Tươi. All rights reserved.';

$contactPhone = $settings['contact_phone'] ?? '';
$contactEmail = $settings['contact_email'] ?? '';
$contactAddress = $settings['contact_address'] ?? '';

$currentYear = date('Y');
?>

<footer class="bg-slate-950 text-white mt-16">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div class="md:col-span-2">
            <div class="flex items-center gap-3">
                <?php if (!empty($logo)): ?>
                    <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($siteName) ?>"
                        class="w-12 h-12 rounded-2xl object-cover border border-white/10 shrink-0">
                <?php else: ?>
                    <div class="w-12 h-12 rounded-2xl site-gradient-bg flex items-center justify-center text-2xl shrink-0">
                        🍊
                    </div>
                <?php endif; ?>

                <div class="min-w-0">
                    <h3 class="text-2xl font-extrabold truncate">
                        <?= htmlspecialchars($siteName) ?>
                    </h3>

                    <p class="text-slate-400 text-sm">
                        <?= htmlspecialchars($siteSubtitle) ?>
                    </p>
                </div>
            </div>

            <p class="text-slate-400 mt-5 max-w-xl leading-7">
                <?= nl2br(htmlspecialchars($footerContent)) ?>
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6">
                <?php if (!empty($contactPhone)): ?>
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-xs text-slate-500">Hotline</p>
                        <p class="text-sm font-bold mt-1">
                            <?= htmlspecialchars($contactPhone) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($contactEmail)): ?>
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-xs text-slate-500">Email</p>
                        <p class="text-sm font-bold mt-1 break-all">
                            <?= htmlspecialchars($contactEmail) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($contactAddress)): ?>
                    <div class="rounded-2xl bg-white/5 border border-white/10 p-4">
                        <p class="text-xs text-slate-500">Địa chỉ</p>
                        <p class="text-sm font-bold mt-1">
                            <?= htmlspecialchars($contactAddress) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <h4 class="font-bold mb-4">Điều hướng</h4>

            <div class="space-y-3 text-slate-400">
                <a class="block hover:text-white transition" href="index.php?area=client&controller=pages&action=home">
                    Trang chủ
                </a>

                <a class="block hover:text-white transition"
                    href="index.php?area=client&controller=product&action=index">
                    Sản phẩm
                </a>

                <a class="block hover:text-white transition" href="index.php?area=client&controller=post&action=index">
                    Bài viết
                </a>

                <a class="block hover:text-white transition" href="index.php?area=client&controller=video&action=index">
                    Video
                </a>
            </div>
        </div>

        <div>
            <h4 class="font-bold mb-4">Thông tin</h4>

            <div class="space-y-3 text-slate-400">
                <a class="block hover:text-white transition"
                    href="index.php?area=client&controller=pages&action=contact">
                    Liên hệ
                </a>

                <a class="block hover:text-white transition"
                    href="index.php?area=client&controller=pages&action=privacy">
                    Chính sách
                </a>

                <a class="block hover:text-white transition" href="index.php?area=client&controller=pages&action=terms">
                    Điều khoản
                </a>

                <?php if (function_exists('isAdmin') && isAdmin()): ?>
                    <a class="block hover:text-white transition"
                        href="index.php?area=admin&controller=dashboard&action=index">
                        Admin Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div
            class="max-w-7xl mx-auto px-3 sm:px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-slate-500">
            <p>
                © <?= htmlspecialchars($currentYear) ?> <?= htmlspecialchars($siteName) ?>.
            </p>

            <p>
                Powered by PHP MVC
            </p>
        </div>
    </div>
</footer>