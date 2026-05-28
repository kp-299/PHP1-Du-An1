<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
            <?= htmlspecialchars($title ?? 'Quản lý đơn hàng') ?>
        </h1>
        <p class="text-slate-500 mt-2">
            Theo dõi, lọc và cập nhật trạng thái đơn hàng.
        </p>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="order">
                <input type="hidden" name="action" value="index">

                <div class="xl:col-span-4">
                    <input type="text" name="keyword" placeholder="Tên khách, SĐT, email..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                </div>

                <div class="xl:col-span-3">
                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả trạng thái</option>
                        <option value="pending" <?= ($filters['status'] ?? '') === 'pending' ? 'selected' : '' ?>>
                            Pending</option>
                        <option value="confirmed" <?= ($filters['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>
                            Confirmed</option>
                        <option value="shipping" <?= ($filters['status'] ?? '') === 'shipping' ? 'selected' : '' ?>>
                            Shipping</option>
                        <option value="completed" <?= ($filters['status'] ?? '') === 'completed' ? 'selected' : '' ?>>
                            Completed</option>
                        <option value="cancelled" <?= ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>
                            Cancelled</option>
                    </select>
                </div>

                <div class="xl:col-span-2">
                    <input type="date" name="date_from" class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
                </div>

                <div class="xl:col-span-2">
                    <input type="date" name="date_to" class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
                </div>

                <div class="xl:col-span-1 flex gap-2">
                    <button type="submit"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl flex-1">
                        Lọc
                    </button>
                </div>

                <div class="xl:col-span-1">
                    <a href="index.php?area=admin&controller=order&action=index"
                        class="btn btn-outline rounded-2xl w-full">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Danh sách đơn hàng
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Các đơn hàng được tạo từ client.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($orders) ? count($orders) : 0 ?> đơn hàng
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Liên hệ</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr class="hover">
                                    <td class="font-bold">#<?= $order['id'] ?></td>

                                    <td>
                                        <div class="font-bold"><?= htmlspecialchars($order['customer_name']) ?></div>
                                        <div class="text-xs text-slate-500">
                                            <?= !empty($order['user_email']) ? htmlspecialchars($order['user_email']) : 'Guest' ?>
                                        </div>
                                    </td>

                                    <td>
                                        <div><?= htmlspecialchars($order['customer_phone']) ?></div>
                                        <div class="text-xs text-slate-500 max-w-xs truncate">
                                            <?= htmlspecialchars($order['customer_address']) ?>
                                        </div>
                                    </td>

                                    <td class="font-bold"><?= number_format($order['total_amount']) ?>đ</td>

                                    <td>
                                        <div class="flex flex-col gap-1">
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                                <?= htmlspecialchars($order['payment_method']) ?>
                                            </span>

                                            <?php if (($order['payment_status'] ?? '') === 'paid'): ?>
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">paid</span>
                                            <?php else: ?>
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">unpaid</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php
                                        $statusClass = 'bg-amber-100 text-amber-700';
                                        if ($order['status'] === 'completed') $statusClass = 'bg-green-100 text-green-700';
                                        if ($order['status'] === 'cancelled') $statusClass = 'bg-rose-100 text-rose-700';
                                        if ($order['status'] === 'confirmed' || $order['status'] === 'shipping') $statusClass = 'bg-sky-100 text-sky-700';
                                        ?>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $statusClass ?>">
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
                                    </td>

                                    <td class="text-slate-500">
                                        <?= htmlspecialchars($order['created_at']) ?>
                                    </td>

                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <a href="index.php?area=admin&controller=order&action=detail&id=<?= $order['id'] ?>"
                                                class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-xl">
                                                Chi tiết
                                            </a>

                                            <?php if ($order['status'] === 'pending'): ?>
                                                <a href="index.php?area=admin&controller=order&action=cancel&id=<?= $order['id'] ?>"
                                                    class="btn btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-xl"
                                                    onclick="return confirm('Bạn muốn hủy đơn hàng này?')">
                                                    Hủy
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="py-16 text-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-sky-50 flex items-center justify-center text-3xl mx-auto">
                                            🧾
                                        </div>
                                        <p class="font-bold mt-4">Chưa có đơn hàng nào</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Khi khách đặt hàng, đơn sẽ xuất hiện tại đây.
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
</div>