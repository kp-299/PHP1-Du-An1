<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Chi tiết đơn hàng') ?> #<?= htmlspecialchars($order['id']) ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Xem thông tin khách hàng, sản phẩm và cập nhật trạng thái.
            </p>
        </div>

        <a href="index.php?area=admin&controller=order&action=index" class="btn btn-outline rounded-2xl">
            ← Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 2xl:grid-cols-3 gap-6">
        <div class="2xl:col-span-2 space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <div class="flex items-center justify-between gap-4 mb-5">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900">
                                Sản phẩm trong đơn
                            </h3>
                            <p class="text-sm text-slate-500 mt-1">
                                Danh sách sản phẩm khách đã đặt.
                            </p>
                        </div>

                        <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                            <?= !empty($orderItems) ? count($orderItems) : 0 ?> sản phẩm
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr class="text-slate-500">
                                    <th>Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Đơn vị</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($orderItems)): ?>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr class="hover">
                                            <td class="font-bold">
                                                <?= htmlspecialchars($item['product_name']) ?>
                                            </td>

                                            <td><?= number_format($item['product_price']) ?>đ</td>

                                            <td><?= htmlspecialchars($item['quantity']) ?></td>

                                            <td><?= htmlspecialchars($item['unit'] ?? '') ?></td>

                                            <td class="text-right font-bold">
                                                <?= number_format($item['subtotal']) ?>đ
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">
                                            <div class="py-14 text-center text-slate-500">
                                                Không có sản phẩm trong đơn.
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right text-base font-bold">
                                        Tổng tiền:
                                    </td>
                                    <td class="text-right text-xl font-extrabold text-green-600">
                                        <?= number_format($order['total_amount']) ?>đ
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Ghi chú đơn hàng
                    </h3>

                    <div class="rounded-3xl bg-slate-50 border border-slate-200 p-5 text-slate-600 mt-4">
                        <?= nl2br(htmlspecialchars($order['note'] ?? 'Không có ghi chú.')) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-4">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Thông tin khách hàng
                    </h3>

                    <div>
                        <p class="text-sm text-slate-500">Tên khách hàng</p>
                        <p class="font-bold"><?= htmlspecialchars($order['customer_name']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Số điện thoại</p>
                        <p><?= htmlspecialchars($order['customer_phone']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Địa chỉ</p>
                        <p><?= htmlspecialchars($order['customer_address']) ?></p>
                    </div>

                    <div>
                        <p class="text-sm text-slate-500">Tài khoản</p>
                        <p>
                            <?= !empty($order['user_email'])
                                ? htmlspecialchars($order['user_email'])
                                : 'Guest'
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
                <div class="card-body space-y-5">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        Cập nhật đơn hàng
                    </h3>

                    <form action="index.php?area=admin&controller=order&action=updateStatus" method="POST"
                        class="space-y-4">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Trạng thái đơn</span>
                            </label>

                            <select name="status" class="select select-bordered rounded-2xl w-full">
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending
                                </option>
                                <option value="confirmed" <?= $order['status'] === 'confirmed' ? 'selected' : '' ?>>
                                    Confirmed</option>
                                <option value="shipping" <?= $order['status'] === 'shipping' ? 'selected' : '' ?>>
                                    Shipping</option>
                                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>
                                    Completed</option>
                                <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>
                                    Cancelled</option>
                            </select>
                        </div>

                        <button class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full"
                            type="submit">
                            Cập nhật trạng thái
                        </button>
                    </form>

                    <div class="divider"></div>

                    <form action="index.php?area=admin&controller=order&action=updatePaymentStatus" method="POST"
                        class="space-y-4">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($order['id']) ?>">

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold">Trạng thái thanh toán</span>
                            </label>

                            <select name="payment_status" class="select select-bordered rounded-2xl w-full">
                                <option value="unpaid" <?= $order['payment_status'] === 'unpaid' ? 'selected' : '' ?>>
                                    Unpaid</option>
                                <option value="paid" <?= $order['payment_status'] === 'paid' ? 'selected' : '' ?>>Paid
                                </option>
                            </select>
                        </div>

                        <button
                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl w-full"
                            type="submit">
                            Cập nhật thanh toán
                        </button>
                    </form>
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-green-500 to-lime-500 text-white shadow-lg shadow-green-500/20 rounded-3xl">
                <div class="card-body">
                    <p class="text-sm text-white/80">Tổng tiền đơn hàng</p>
                    <h3 class="text-3xl font-extrabold">
                        <?= number_format($order['total_amount']) ?>đ
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>