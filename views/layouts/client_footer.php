<?php
$settings = $settings ?? [];

$siteName = $settings['site_name'] ?? 'Trái Cây Tươi';
$siteSubtitle = $settings['site_subtitle'] ?? 'Premium Fresh Market';
$logo = $settings['logo'] ?? '';

$footerContent = $settings['footer_content'] ?? '© 2026 Trái Cây Tươi. All rights reserved.';

$contactPhone = $settings['contact_phone'] ?? '';
$contactEmail = $settings['contact_email'] ?? '';
$contactAddress = $settings['contact_address'] ?? '';

$currentYear = date('Y');
?>

<footer class="relative mt-20 overflow-hidden bg-[#002D26] text-white">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-[#94d3c1] blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-[#FFC107] blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10">
            <div class="md:col-span-6">
                <div
                    class="rounded-[2rem] bg-white/8 border border-white/10 backdrop-blur-xl p-5 sm:p-6 shadow-[0_20px_70px_rgba(0,0,0,0.18)]">
                    <div class="flex items-center gap-3">
                        <?php if (!empty($logo)): ?>
                        <img src="<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($siteName) ?>"
                            class="w-13 h-13 sm:w-14 sm:h-14 rounded-[1.35rem] object-cover border border-white/20 shrink-0">
                        <?php else: ?>
                        <div
                            class="w-13 h-13 sm:w-14 sm:h-14 rounded-[1.35rem] bg-[#FFC107] flex items-center justify-center text-2xl shrink-0 shadow-[0_14px_35px_rgba(255,193,7,0.2)]">
                            🍊
                        </div>
                        <?php endif; ?>

                        <div class="min-w-0">
                            <h3 class="text-2xl sm:text-3xl font-extrabold tracking-tight truncate">
                                <?= htmlspecialchars($siteName) ?>
                            </h3>

                            <p class="text-[#94d3c1] text-sm mt-1">
                                <?= htmlspecialchars($siteSubtitle) ?>
                            </p>
                        </div>
                    </div>

                    <p class="text-[#eff1ef]/75 mt-5 max-w-xl leading-7">
                        <?= nl2br(htmlspecialchars($footerContent)) ?>
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6">
                        <?php if (!empty($contactPhone)): ?>
                        <div class="rounded-[1.5rem] bg-white/8 border border-white/10 p-4">
                            <p class="text-xs text-[#94d3c1] uppercase tracking-widest font-bold">Hotline</p>
                            <p class="text-sm font-bold mt-2">
                                <?= htmlspecialchars($contactPhone) ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($contactEmail)): ?>
                        <div class="rounded-[1.5rem] bg-white/8 border border-white/10 p-4">
                            <p class="text-xs text-[#94d3c1] uppercase tracking-widest font-bold">Email</p>
                            <p class="text-sm font-bold mt-2 break-all">
                                <?= htmlspecialchars($contactEmail) ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($contactAddress)): ?>
                        <div class="rounded-[1.5rem] bg-white/8 border border-white/10 p-4">
                            <p class="text-xs text-[#94d3c1] uppercase tracking-widest font-bold">Địa chỉ</p>
                            <p class="text-sm font-bold mt-2 leading-6">
                                <?= htmlspecialchars($contactAddress) ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <div class="rounded-[2rem] bg-white/8 border border-white/10 backdrop-blur-xl p-5 sm:p-6 h-full">
                    <h4 class="font-extrabold mb-5 text-lg">Điều hướng</h4>

                    <div class="space-y-2 text-[#eff1ef]/75">
                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=pages&action=home">
                            <span>Trang chủ</span>
                            <span>→</span>
                        </a>

                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=product&action=index">
                            <span>Sản phẩm</span>
                            <span>→</span>
                        </a>

                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=post&action=index">
                            <span>Bài viết</span>
                            <span>→</span>
                        </a>

                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=video&action=index">
                            <span>Video</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="md:col-span-3">
                <div class="rounded-[2rem] bg-white/8 border border-white/10 backdrop-blur-xl p-5 sm:p-6 h-full">
                    <h4 class="font-extrabold mb-5 text-lg">Thông tin</h4>

                    <div class="space-y-2 text-[#eff1ef]/75">
                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=pages&action=contact">
                            <span>Liên hệ</span>
                            <span>→</span>
                        </a>

                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=pages&action=privacy">
                            <span>Chính sách</span>
                            <span>→</span>
                        </a>

                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=client&controller=pages&action=terms">
                            <span>Điều khoản</span>
                            <span>→</span>
                        </a>

                        <?php if (function_exists('isAdmin') && isAdmin()): ?>
                        <a class="flex items-center justify-between rounded-2xl px-3 py-2.5 hover:bg-white/10 hover:text-white transition"
                            href="index.php?area=admin&controller=dashboard&action=index">
                            <span>Admin Dashboard</span>
                            <span>→</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative border-t border-white/10">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-[#eff1ef]/55">
            <p>
                © <?= htmlspecialchars($currentYear) ?> <?= htmlspecialchars($siteName) ?>.
            </p>

            <p>
                Built with PHP MVC · Fresh commerce playground
            </p>
        </div>
    </div>
</footer>