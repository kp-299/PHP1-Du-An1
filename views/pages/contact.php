<?php
$settings = $settings ?? [];
$errors = $errors ?? [];
$old = $old ?? [];

$siteName = $settings['site_name'] ?? 'Fresh Fruit Store';
$contactEmail = $settings['contact_email'] ?? '';
$contactPhone = $settings['contact_phone'] ?? '';
$contactAddress = $settings['contact_address'] ?? '';

function contactOld($old, $key, $default = '')
{
    return htmlspecialchars($old[$key] ?? $default);
}

function contactError($errors, $key)
{
    if (empty($errors[$key])) {
        return '';
    }

    return '<p class="text-error text-sm mt-2">' . htmlspecialchars($errors[$key]) . '</p>';
}
?>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="client-card overflow-hidden mb-8">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-6 sm:p-10 lg:p-12">
                    <span class="client-badge mb-5">
                        Contact
                    </span>

                    <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950 leading-tight">
                        Liên hệ với chúng tôi
                    </h1>

                    <p class="text-slate-500 mt-5 max-w-2xl leading-8">
                        Bạn cần hỗ trợ về sản phẩm, đơn hàng hoặc hợp tác? Hãy gửi thông tin bên dưới, admin sẽ nhận
                        được trong dashboard và qua email.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-8">
                        <div class="rounded-3xl bg-green-50 p-4">
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="font-extrabold text-slate-950 mt-1 break-all text-sm">
                                <?= htmlspecialchars($contactEmail ?: 'Chưa cấu hình') ?>
                            </p>
                        </div>

                        <div class="rounded-3xl bg-green-50 p-4">
                            <p class="text-sm text-slate-500">Hotline</p>
                            <p class="font-extrabold text-slate-950 mt-1 text-sm">
                                <?= htmlspecialchars($contactPhone ?: 'Chưa cấu hình') ?>
                            </p>
                        </div>

                        <div class="rounded-3xl bg-green-50 p-4">
                            <p class="text-sm text-slate-500">Địa chỉ</p>
                            <p class="font-extrabold text-slate-950 mt-1 text-sm leading-6">
                                <?= htmlspecialchars($contactAddress ?: 'Chưa cấu hình') ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-950 text-white p-6 sm:p-10 lg:p-12 flex items-center">
                    <div>
                        <div class="text-7xl mb-5">🍊</div>

                        <h2 class="text-3xl font-extrabold">
                            <?= htmlspecialchars($siteName) ?>
                        </h2>

                        <p class="text-slate-300 mt-4 leading-8">
                            Tin nhắn của khách hàng sẽ được lưu lại để admin kiểm tra, ghi chú và phản hồi sau.
                        </p>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-3xl bg-white/10 p-4">
                                <p class="text-2xl font-extrabold">24h</p>
                                <p class="text-sm text-slate-300 mt-1">Phản hồi</p>
                            </div>

                            <div class="rounded-3xl bg-white/10 p-4">
                                <p class="text-2xl font-extrabold">100%</p>
                                <p class="text-sm text-slate-300 mt-1">Hỗ trợ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div
                class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> rounded-3xl mb-6">
                <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-error rounded-3xl mb-6">
                <span><?= htmlspecialchars($errors['general']) ?></span>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-4">
                <div class="client-card p-5 sm:p-6 lg:sticky lg:top-24">
                    <h2 class="text-2xl font-extrabold text-slate-950">
                        Thông tin liên hệ
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Các thông tin này lấy từ phần Cài đặt website trong admin dashboard.
                    </p>

                    <div class="space-y-4 mt-6">
                        <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="font-extrabold text-slate-950 mt-1 break-all">
                                <?= htmlspecialchars($contactEmail ?: 'Chưa cấu hình') ?>
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Số điện thoại</p>
                            <p class="font-extrabold text-slate-950 mt-1">
                                <?= htmlspecialchars($contactPhone ?: 'Chưa cấu hình') ?>
                            </p>
                        </div>

                        <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5">
                            <p class="text-sm text-slate-500">Địa chỉ</p>
                            <p class="font-extrabold text-slate-950 mt-1 leading-7">
                                <?= htmlspecialchars($contactAddress ?: 'Chưa cấu hình') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8">
                <div class="client-card p-5 sm:p-6">
                    <h2 class="text-2xl font-extrabold text-slate-950">
                        Gửi liên hệ
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Nội dung sẽ được lưu vào admin dashboard.
                    </p>

                    <form action="index.php?area=client&controller=pages&action=handleContact" method="POST"
                        class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Họ tên
                            </label>

                            <input type="text" name="name"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                                value="<?= contactOld($old, 'name') ?>" placeholder="Nguyễn Văn A">

                            <?= contactError($errors, 'name') ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Email
                            </label>

                            <input type="email" name="email"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['email']) ? 'input-error' : '' ?>"
                                value="<?= contactOld($old, 'email') ?>" placeholder="email@gmail.com">

                            <?= contactError($errors, 'email') ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Số điện thoại
                            </label>

                            <input type="text" name="phone"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['phone']) ? 'input-error' : '' ?>"
                                value="<?= contactOld($old, 'phone') ?>" placeholder="090...">

                            <?= contactError($errors, 'phone') ?>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Chủ đề
                            </label>

                            <input type="text" name="subject"
                                class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['subject']) ? 'input-error' : '' ?>"
                                value="<?= contactOld($old, 'subject') ?>" placeholder="Hỗ trợ đơn hàng">

                            <?= contactError($errors, 'subject') ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 text-sm font-semibold text-slate-700">
                                Nội dung
                            </label>

                            <textarea name="message"
                                class="textarea textarea-bordered rounded-3xl w-full min-h-40 bg-white <?= !empty($errors['message']) ? 'textarea-error' : '' ?>"
                                placeholder="Nhập nội dung cần hỗ trợ..."><?= contactOld($old, 'message') ?></textarea>

                            <?= contactError($errors, 'message') ?>
                        </div>

                        <div class="md:col-span-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <p class="text-sm text-slate-500">
                                Admin sẽ nhận nội dung này trong dashboard.
                            </p>

                            <button class="client-btn-accent h-11 px-6">
                                Gửi liên hệ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>