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

<section class="max-w-7xl mx-auto px-3 sm:px-4 py-8 sm:py-12">
    <div class="mb-8">
        <p class="text-sm text-slate-500">
            <?= htmlspecialchars($siteName) ?>
        </p>

        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-950">
            Liên hệ với chúng tôi
        </h1>

        <p class="text-slate-500 mt-3 max-w-2xl leading-7">
            Bạn cần hỗ trợ về sản phẩm, đơn hàng hoặc hợp tác? Hãy gửi thông tin bên dưới, admin sẽ nhận được trong
            dashboard và qua email.
        </p>
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
        <div class="lg:col-span-5 space-y-5">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-6 shadow-sm">
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

        <div class="lg:col-span-7">
            <div class="bg-white border border-slate-200 rounded-[2rem] p-5 sm:p-6 shadow-sm">
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
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                            value="<?= contactOld($old, 'name') ?>" placeholder="Nguyễn Văn A">

                        <?= contactError($errors, 'name') ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Email
                        </label>

                        <input type="email" name="email"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['email']) ? 'input-error' : '' ?>"
                            value="<?= contactOld($old, 'email') ?>" placeholder="email@gmail.com">

                        <?= contactError($errors, 'email') ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Số điện thoại
                        </label>

                        <input type="text" name="phone"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['phone']) ? 'input-error' : '' ?>"
                            value="<?= contactOld($old, 'phone') ?>" placeholder="090...">

                        <?= contactError($errors, 'phone') ?>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Chủ đề
                        </label>

                        <input type="text" name="subject"
                            class="input input-bordered rounded-2xl w-full <?= !empty($errors['subject']) ? 'input-error' : '' ?>"
                            value="<?= contactOld($old, 'subject') ?>" placeholder="Hỗ trợ đơn hàng">

                        <?= contactError($errors, 'subject') ?>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-semibold text-slate-700">
                            Nội dung
                        </label>

                        <textarea name="message"
                            class="textarea textarea-bordered rounded-2xl w-full min-h-40 <?= !empty($errors['message']) ? 'textarea-error' : '' ?>"
                            placeholder="Nhập nội dung cần hỗ trợ..."><?= contactOld($old, 'message') ?></textarea>

                        <?= contactError($errors, 'message') ?>
                    </div>

                    <div class="md:col-span-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <p class="text-sm text-slate-500">
                            Admin sẽ nhận nội dung này trong dashboard.
                        </p>

                        <button class="btn site-gradient-bg border-0 text-white rounded-2xl">
                            Gửi liên hệ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>