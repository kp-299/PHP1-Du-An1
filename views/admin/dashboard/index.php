<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Tổng quan') ?>
            </h1>

            <p class="text-slate-500 mt-2">
                Theo dõi nhanh tình hình website bán trái cây.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="index.php?area=admin&controller=product&action=create"
                class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
                + Thêm sản phẩm
            </a>

            <a href="index.php?area=admin&controller=order&action=index" class="btn btn-outline rounded-2xl">
                Xem đơn hàng
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-5">
        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Người dùng</p>
                        <h3 class="text-4xl font-extrabold mt-3"><?= $totalUsers ?? 0 ?></h3>
                    </div>

                    <div
                        class="w-14 h-14 rounded-3xl bg-violet-100 text-violet-600 flex items-center justify-center text-2xl">
                        👥
                    </div>
                </div>

                <div class="mt-4">
                    <span class="badge bg-violet-600 text-white border-0">
                        Admin: <?= $totalAdmins ?? 0 ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Sản phẩm</p>
                        <h3 class="text-4xl font-extrabold mt-3"><?= $totalProducts ?? 0 ?></h3>
                    </div>

                    <div
                        class="w-14 h-14 rounded-3xl bg-green-100 text-green-600 flex items-center justify-center text-2xl">
                        🍏
                    </div>
                </div>

                <div class="mt-4">
                    <span class="badge bg-green-500 text-white border-0">
                        Active: <?= $totalActiveProducts ?? 0 ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Đơn hàng</p>
                        <h3 class="text-4xl font-extrabold mt-3"><?= $totalOrders ?? 0 ?></h3>
                    </div>

                    <div
                        class="w-14 h-14 rounded-3xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl">
                        🧾
                    </div>
                </div>

                <div class="mt-4">
                    <span class="badge bg-sky-500 text-white border-0">
                        Hôm nay: <?= $countTodayOrders ?? 0 ?>
                    </span>
                </div>
            </div>
        </div>

        <div
            class="card bg-gradient-to-br from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20 rounded-3xl">
            <div class="card-body">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-white/80">Doanh thu</p>
                        <h3 class="text-4xl font-extrabold mt-3">
                            <?= number_format($totalRevenue ?? 0) ?>đ
                        </h3>
                    </div>

                    <div class="w-14 h-14 rounded-3xl bg-white/20 flex items-center justify-center text-2xl">
                        💰
                    </div>
                </div>

                <p class="text-sm text-white/80 mt-4">
                    Tính từ đơn completed
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl 2xl:col-span-2">
            <div class="card-body">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900">
                            Đơn hàng hôm nay
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Các đơn mới được tạo trong ngày.
                        </p>
                    </div>

                    <a href="index.php?area=admin&controller=order&action=index"
                        class="btn btn-sm btn-outline rounded-xl">
                        Xem tất cả
                    </a>
                </div>

                <div class="overflow-x-auto mt-5">
                    <table class="table">
                        <thead>
                            <tr class="text-slate-500">
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>SĐT</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($todayOrders)): ?>
                            <?php foreach ($todayOrders as $order): ?>
                            <?php
                                    $statusClass = 'bg-amber-100 text-amber-700';

                                    if ($order['status'] === 'confirmed') {
                                        $statusClass = 'bg-sky-100 text-sky-700';
                                    } elseif ($order['status'] === 'shipping') {
                                        $statusClass = 'bg-sky-100 text-sky-700';
                                    } elseif ($order['status'] === 'completed') {
                                        $statusClass = 'bg-green-100 text-green-700';
                                    } elseif ($order['status'] === 'cancelled') {
                                        $statusClass = 'bg-rose-100 text-rose-700';
                                    }
                                    ?>

                            <tr class="hover">
                                <td class="font-bold">#<?= $order['id'] ?></td>

                                <td>
                                    <div class="font-semibold">
                                        <?= htmlspecialchars($order['customer_name']) ?>
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        <?= htmlspecialchars($order['created_at']) ?>
                                    </div>
                                </td>

                                <td><?= htmlspecialchars($order['customer_phone']) ?></td>

                                <td class="font-bold">
                                    <?= number_format($order['total_amount']) ?>đ
                                </td>

                                <td>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold <?= $statusClass ?>">
                                        <?= htmlspecialchars($order['status']) ?>
                                    </span>
                                </td>

                                <td class="text-right">
                                    <a href="index.php?area=admin&controller=order&action=detail&id=<?= $order['id'] ?>"
                                        class="btn btn-sm bg-slate-900 hover:bg-slate-800 text-white rounded-xl">
                                        Xem
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6">
                                    <div class="py-16 text-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center text-3xl mx-auto">
                                            🧺
                                        </div>

                                        <p class="font-bold mt-4">Hôm nay chưa có đơn hàng</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Khi có đơn mới, dữ liệu sẽ hiển thị tại đây.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold">Trạng thái sản phẩm</h3>

                    <div class="space-y-4 mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Active</span>
                            <span class="badge bg-green-500 text-white border-0"><?= $totalActiveProducts ?? 0 ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Hidden</span>
                            <span class="badge bg-amber-400 text-white border-0"><?= $totalHiddenProducts ?? 0 ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Out of stock</span>
                            <span
                                class="badge bg-rose-500 text-white border-0"><?= $totalOutOfStockProducts ?? 0 ?></span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <a href="index.php?area=admin&controller=product&action=index"
                        class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl">
                        Quản lý sản phẩm
                    </a>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold">Trạng thái đơn hàng</h3>

                    <div class="space-y-4 mt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Pending</span>
                            <span class="badge bg-amber-400 text-white border-0"><?= $pendingOrders ?? 0 ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Completed</span>
                            <span class="badge bg-green-500 text-white border-0"><?= $completedOrders ?? 0 ?></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-slate-600">Cancelled</span>
                            <span class="badge bg-rose-500 text-white border-0"><?= $cancelledOrders ?? 0 ?></span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <a href="index.php?area=admin&controller=order&action=index" class="btn btn-outline rounded-2xl">
                        Quản lý đơn hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>