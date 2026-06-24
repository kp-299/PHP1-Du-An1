<?php
$user = $user ?? [];
$orders = $orders ?? [];
$currentOrders = $currentOrders ?? [];
$errors = $errors ?? [];
$old = $old ?? [];

$activeTab = $activeTab ?? ($_GET['tab'] ?? 'overview');

function userTabClass($tab, $activeTab)
{
    return $tab === $activeTab
        ? 'bg-green-700 text-white shadow-sm'
        : 'bg-white text-slate-600 hover:bg-green-50 hover:text-green-700 border border-slate-200';
}

function userOld($old, $user, $key, $default = '')
{
    return htmlspecialchars($old[$key] ?? $user[$key] ?? $default);
}

function userError($errors, $key)
{
    if (empty($errors[$key])) {
        return '';
    }

    return '<p class="text-error text-sm mt-2">' . htmlspecialchars($errors[$key]) . '</p>';
}

function dashboardOrderStatusLabel($status)
{
    return match ($status) {
        'pending' => 'Chờ xử lý',
        'processing' => 'Đang xử lý',
        'shipping' => 'Đang giao',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã hủy',
        default => 'Không rõ',
    };
}

function dashboardOrderStatusClass($status)
{
    return match ($status) {
        'pending' => 'bg-amber-100 text-amber-700',
        'processing' => 'bg-sky-100 text-sky-700',
        'shipping' => 'bg-violet-100 text-violet-700',
        'completed' => 'bg-emerald-100 text-emerald-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };
}

function dashboardPaymentLabel($status)
{
    return match ($status) {
        'paid' => 'Đã thanh toán',
        'unpaid' => 'Chưa thanh toán',
        'refunded' => 'Đã hoàn tiền',
        default => 'Không rõ',
    };
}

function dashboardPaymentClass($status)
{
    return match ($status) {
        'paid' => 'bg-emerald-100 text-emerald-700',
        'unpaid' => 'bg-rose-100 text-rose-700',
        'refunded' => 'bg-sky-100 text-sky-700',
        default => 'bg-slate-100 text-slate-700',
    };
}

$totalOrders = count($orders);
$totalCurrentOrders = count($currentOrders);
$totalCompletedOrders = 0;
$totalSpent = 0;

foreach ($orders as $order) {
    if (($order['status'] ?? '') === 'completed') {
        $totalCompletedOrders++;
        $totalSpent += (float)($order['total_amount'] ?? 0);
    }
}
?>

<section class="client-section bg-slate-50">
    <div class="client-shell">
        <div class="mb-8 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
            <div>
                <span class="client-badge mb-3">
                    Account
                </span>

                <h1 class="client-section-title">
                    Tài khoản của tôi
                </h1>

                <p class="client-section-subtitle max-w-2xl">
                    Quản lý thông tin cá nhân, đơn hàng hiện tại và lịch sử mua hàng.
                </p>
            </div>

            <a href="index.php?area=client&controller=product&action=index" class="client-btn-outline h-11 px-5 w-fit">
                Tiếp tục mua hàng
            </a>
        </div>

        <?php if (!empty($_SESSION['flash'])): ?>
            <div
                class="alert <?= $_SESSION['flash']['type'] === 'success' ? 'alert-success' : 'alert-error' ?> rounded-3xl mb-6">
                <span><?= htmlspecialchars($_SESSION['flash']['message']) ?></span>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <aside class="lg:col-span-3">
                <div class="client-card p-5 lg:sticky lg:top-24">
                    <div class="rounded-3xl bg-slate-950 text-white p-5 mb-5">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 rounded-3xl bg-green-600 flex items-center justify-center text-white text-2xl font-extrabold shrink-0">
                                <?= htmlspecialchars(strtoupper(mb_substr($user['name'] ?? 'U', 0, 1))) ?>
                            </div>

                            <div class="min-w-0">
                                <h2 class="font-extrabold text-white truncate">
                                    <?= htmlspecialchars($user['name'] ?? 'User') ?>
                                </h2>

                                <p class="text-sm text-slate-300 truncate">
                                    <?= htmlspecialchars($user['email'] ?? '') ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-1 gap-2">
                        <a href="index.php?area=client&controller=user&action=profile&tab=overview"
                            class="block px-4 py-3 rounded-2xl font-bold transition <?= userTabClass('overview', $activeTab) ?>">
                            📊 Tổng quan
                        </a>

                        <a href="index.php?area=client&controller=user&action=profile&tab=profile"
                            class="block px-4 py-3 rounded-2xl font-bold transition <?= userTabClass('profile', $activeTab) ?>">
                            👤 Thông tin
                        </a>

                        <a href="index.php?area=client&controller=user&action=profile&tab=security"
                            class="block px-4 py-3 rounded-2xl font-bold transition <?= userTabClass('security', $activeTab) ?>">
                            🔐 Bảo mật
                        </a>

                        <a href="index.php?area=client&controller=user&action=profile&tab=verify"
                            class="block px-4 py-3 rounded-2xl font-bold transition <?= userTabClass('verify', $activeTab) ?>">
                            ✉️ Verify mail
                        </a>

                        <a href="index.php?area=client&controller=user&action=profile&tab=current_orders"
                            class="block px-4 py-3 rounded-2xl font-bold transition <?= userTabClass('current_orders', $activeTab) ?>">
                            📦 Đơn hiện tại
                        </a>

                        <a href="index.php?area=client&controller=user&action=profile&tab=orders"
                            class="block px-4 py-3 rounded-2xl font-bold transition <?= userTabClass('orders', $activeTab) ?>">
                            🧾 Lịch sử
                        </a>

                        <a href="index.php?area=client&controller=auth&action=logout"
                            class="block px-4 py-3 rounded-2xl font-bold bg-rose-50 text-rose-600 hover:bg-rose-100 transition col-span-2 lg:col-span-1">
                            🚪 Đăng xuất
                        </a>
                    </div>
                </div>
            </aside>

            <div class="lg:col-span-9 space-y-6">
                <?php if ($activeTab === 'overview'): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                        <div class="client-card p-5">
                            <p class="text-slate-500">Tổng đơn</p>
                            <p class="text-3xl font-extrabold mt-3 text-slate-950"><?= htmlspecialchars($totalOrders) ?></p>
                        </div>

                        <div class="client-card p-5">
                            <p class="text-slate-500">Đơn hiện tại</p>
                            <p class="text-3xl font-extrabold mt-3 text-amber-600">
                                <?= htmlspecialchars($totalCurrentOrders) ?></p>
                        </div>

                        <div class="client-card p-5">
                            <p class="text-slate-500">Đơn hoàn thành</p>
                            <p class="text-3xl font-extrabold mt-3 text-green-700">
                                <?= htmlspecialchars($totalCompletedOrders) ?></p>
                        </div>

                        <div class="client-card p-5">
                            <p class="text-slate-500">Đã chi tiêu</p>
                            <p class="text-3xl font-extrabold mt-3 text-green-700">
                                <?= number_format($totalSpent) ?>đ
                            </p>
                        </div>
                    </div>

                    <div class="client-card p-5 sm:p-6">
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 items-stretch">
                            <div class="xl:col-span-1 rounded-3xl bg-green-50 p-6">
                                <p class="text-sm font-bold text-green-700">Welcome back</p>

                                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-950 mt-2">
                                    Xin chào, <?= htmlspecialchars($user['name'] ?? 'User') ?>
                                </h2>

                                <p class="text-slate-500 mt-3 leading-7">
                                    Đây là khu vực quản lý tài khoản, đơn hàng và bảo mật.
                                </p>
                            </div>

                            <div class="xl:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <a href="index.php?area=client&controller=user&action=profile&tab=profile"
                                    class="rounded-3xl bg-white border border-slate-200 p-5 hover:bg-green-50 transition">
                                    <div class="text-3xl mb-3">👤</div>
                                    <h3 class="font-extrabold text-slate-950">Cập nhật thông tin</h3>
                                    <p class="text-sm text-slate-500 mt-1">Tên, số điện thoại và địa chỉ.</p>
                                </a>

                                <a href="index.php?area=client&controller=user&action=profile&tab=current_orders"
                                    class="rounded-3xl bg-white border border-slate-200 p-5 hover:bg-green-50 transition">
                                    <div class="text-3xl mb-3">📦</div>
                                    <h3 class="font-extrabold text-slate-950">Theo dõi đơn</h3>
                                    <p class="text-sm text-slate-500 mt-1">Xem đơn đang xử lý hoặc đang giao.</p>
                                </a>

                                <a href="index.php?area=client&controller=user&action=profile&tab=orders"
                                    class="rounded-3xl bg-white border border-slate-200 p-5 hover:bg-green-50 transition">
                                    <div class="text-3xl mb-3">🧾</div>
                                    <h3 class="font-extrabold text-slate-950">Lịch sử mua hàng</h3>
                                    <p class="text-sm text-slate-500 mt-1">Xem lại tất cả đơn đã đặt.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($activeTab === 'profile'): ?>
                    <div class="client-card p-5 sm:p-6">
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Thông tin tài khoản
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Cập nhật thông tin nhận hàng mặc định.
                        </p>

                        <form action="index.php?area=client&controller=user&action=updateProfile" method="POST"
                            class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Họ tên</label>

                                <input type="text" name="name"
                                    class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['name']) ? 'input-error' : '' ?>"
                                    value="<?= userOld($old, $user, 'name') ?>">

                                <?= userError($errors, 'name') ?>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Email</label>

                                <input type="email" class="input input-bordered rounded-full w-full bg-slate-100"
                                    value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled>

                                <p class="text-xs text-slate-500 mt-2">
                                    Email sẽ được dùng cho xác thực sau này.
                                </p>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Số điện thoại</label>

                                <input type="text" name="phone"
                                    class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['phone']) ? 'input-error' : '' ?>"
                                    value="<?= userOld($old, $user, 'phone') ?>">

                                <?= userError($errors, 'phone') ?>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Địa chỉ</label>

                                <textarea name="address"
                                    class="textarea textarea-bordered rounded-3xl w-full min-h-28 bg-white"><?= userOld($old, $user, 'address') ?></textarea>
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button class="client-btn-accent h-11 px-6">
                                    Lưu thông tin
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($activeTab === 'security'): ?>
                    <div class="client-card p-5 sm:p-6">
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Bảo mật tài khoản
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Đổi mật khẩu đăng nhập.
                        </p>

                        <form action="index.php?area=client&controller=user&action=changePassword" method="POST"
                            class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-6">
                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Mật khẩu hiện tại</label>

                                <input type="password" name="current_password"
                                    class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['current_password']) ? 'input-error' : '' ?>">

                                <?= userError($errors, 'current_password') ?>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Mật khẩu mới</label>

                                <input type="password" name="new_password"
                                    class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['new_password']) ? 'input-error' : '' ?>">

                                <?= userError($errors, 'new_password') ?>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Nhập lại mật khẩu mới</label>

                                <input type="password" name="confirm_password"
                                    class="input input-bordered rounded-full w-full bg-white <?= !empty($errors['confirm_password']) ? 'input-error' : '' ?>">

                                <?= userError($errors, 'confirm_password') ?>
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button class="client-btn-primary h-11 px-6">
                                    Đổi mật khẩu
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if ($activeTab === 'verify'): ?>
                    <div class="client-card p-5 sm:p-6">
                        <h2 class="text-2xl font-extrabold text-slate-950">
                            Xác thực email
                        </h2>

                        <p class="text-slate-500 mt-2">
                            Chức năng này để khung trước. Sau này sẽ thêm gửi mã qua email để xác thực tài khoản và xác nhận
                            hủy đơn.
                        </p>

                        <div class="alert alert-info rounded-3xl mt-6">
                            <span>
                                Email hiện tại: <b><?= htmlspecialchars($user['email'] ?? '') ?></b>
                            </span>
                        </div>

                        <button class="btn btn-disabled rounded-full mt-4">
                            Gửi mã xác thực email - làm sau
                        </button>
                    </div>
                <?php endif; ?>

                <?php if ($activeTab === 'current_orders' || $activeTab === 'orders'): ?>
                    <?php
                    $listOrders = $activeTab === 'current_orders' ? $currentOrders : $orders;
                    $sectionTitle = $activeTab === 'current_orders' ? 'Đơn hiện tại' : 'Lịch sử đơn hàng';
                    $sectionDesc = $activeTab === 'current_orders'
                        ? 'Các đơn đang chờ xử lý, đang xử lý hoặc đang giao.'
                        : 'Tất cả đơn hàng bạn đã đặt.';
                    ?>

                    <div class="client-card overflow-hidden">
                        <div
                            class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-950">
                                    <?= htmlspecialchars($sectionTitle) ?>
                                </h2>

                                <p class="text-slate-500 mt-2">
                                    <?= htmlspecialchars($sectionDesc) ?>
                                </p>
                            </div>

                            <span class="px-4 py-2 rounded-full bg-slate-950 text-white text-sm font-bold w-fit">
                                <?= count($listOrders) ?> đơn
                            </span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="table min-w-[900px]">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Người nhận</th>
                                        <th>Tổng tiền</th>
                                        <th>Thanh toán</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th class="text-right">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($listOrders)): ?>
                                        <?php foreach ($listOrders as $order): ?>
                                            <tr>
                                                <td class="font-bold text-slate-950">
                                                    #<?= htmlspecialchars($order['id']) ?>
                                                </td>

                                                <td>
                                                    <div class="font-bold text-slate-950">
                                                        <?= htmlspecialchars($order['customer_name'] ?? '-') ?>
                                                    </div>

                                                    <div class="text-xs text-slate-500">
                                                        <?= htmlspecialchars($order['customer_phone'] ?? '-') ?>
                                                    </div>
                                                </td>

                                                <td class="font-bold text-green-700">
                                                    <?= number_format($order['total_amount'] ?? 0) ?>đ
                                                </td>

                                                <td>
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-bold <?= dashboardPaymentClass($order['payment_status'] ?? '') ?>">
                                                        <?= dashboardPaymentLabel($order['payment_status'] ?? '') ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-bold <?= dashboardOrderStatusClass($order['status'] ?? '') ?>">
                                                        <?= dashboardOrderStatusLabel($order['status'] ?? '') ?>
                                                    </span>
                                                </td>

                                                <td class="text-sm text-slate-500">
                                                    <?= htmlspecialchars($order['created_at'] ?? '-') ?>
                                                </td>

                                                <td class="text-right whitespace-nowrap">
                                                    <a href="index.php?area=client&controller=order&action=detail&id=<?= urlencode($order['id']) ?>"
                                                        class="btn btn-sm bg-slate-950 hover:bg-slate-800 border-0 text-white rounded-full">
                                                        Chi tiết
                                                    </a>

                                                    <?php if (($order['status'] ?? '') === 'pending'): ?>
                                                        <a href="index.php?area=client&controller=order&action=cancel&id=<?= urlencode($order['id']) ?>"
                                                            class="btn btn-sm btn-error rounded-full"
                                                            onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                                                            Hủy
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7">
                                                <div class="py-14 text-center">
                                                    <div
                                                        class="w-16 h-16 rounded-3xl bg-green-50 flex items-center justify-center text-4xl mx-auto">
                                                        📦
                                                    </div>

                                                    <p class="font-bold mt-4 text-slate-950">
                                                        Chưa có đơn hàng nào
                                                    </p>

                                                    <p class="text-sm text-slate-500 mt-1">
                                                        Đơn hàng của bạn sẽ hiển thị tại đây.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>