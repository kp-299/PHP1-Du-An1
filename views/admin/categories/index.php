<div class="space-y-8">
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">
                <?= htmlspecialchars($title ?? 'Quản lý danh mục') ?>
            </h1>
            <p class="text-slate-500 mt-2">
                Quản lý danh mục sản phẩm hiển thị trên website.
            </p>
        </div>

        <a href="index.php?area=admin&controller=category&action=create"
            class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 border-0 text-white rounded-2xl shadow-lg shadow-green-500/20">
            + Thêm danh mục
        </a>
    </div>

    <div class="card bg-white shadow-sm border border-slate-200 rounded-3xl">
        <div class="card-body">
            <form method="GET" class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                <input type="hidden" name="area" value="admin">
                <input type="hidden" name="controller" value="category">
                <input type="hidden" name="action" value="index">

                <div class="lg:col-span-6">
                    <input type="text" name="keyword" placeholder="Tìm theo tên danh mục..."
                        class="input input-bordered rounded-2xl w-full"
                        value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
                </div>

                <div class="lg:col-span-3">
                    <select name="status" class="select select-bordered rounded-2xl w-full">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>
                            Active
                        </option>
                        <option value="hidden" <?= ($filters['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>
                            Hidden
                        </option>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <button type="submit"
                        class="btn bg-slate-900 hover:bg-slate-800 border-0 text-white rounded-2xl w-full">
                        Lọc
                    </button>
                </div>

                <div class="lg:col-span-1">
                    <a href="index.php?area=admin&controller=category&action=index"
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
                        Danh sách danh mục
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Tổng hợp các danh mục sản phẩm.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-2xl bg-slate-900 text-white text-sm font-bold">
                    <?= !empty($categories) ? count($categories) : 0 ?> danh mục
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr class="text-slate-500">
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr class="hover">
                                    <td class="font-bold">#<?= $category['id'] ?></td>

                                    <td>
                                        <?php if (!empty($category['image'])): ?>
                                            <img src="<?= htmlspecialchars($category['image']) ?>"
                                                alt="<?= htmlspecialchars($category['name']) ?>"
                                                class="w-14 h-14 rounded-2xl object-cover border border-slate-200">
                                        <?php else: ?>
                                            <div
                                                class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-xl">
                                                🗂️
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="font-semibold">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </td>

                                    <td class="text-slate-500">
                                        <?= htmlspecialchars($category['slug']) ?>
                                    </td>

                                    <td class="max-w-xs text-slate-500">
                                        <p class="truncate">
                                            <?= htmlspecialchars($category['description'] ?? '') ?>
                                        </p>
                                    </td>

                                    <td>
                                        <?php if (($category['status'] ?? '') === 'active'): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                                active
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                                hidden
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-slate-500">
                                        <?= htmlspecialchars($category['created_at'] ?? '') ?>
                                    </td>

                                    <td>
                                        <div class="flex justify-end gap-2">
                                            <a href="index.php?area=admin&controller=category&action=edit&id=<?= $category['id'] ?>"
                                                class="btn btn-sm btn-outline rounded-xl">
                                                Sửa
                                            </a>

                                            <?php if (($category['status'] ?? '') === 'active'): ?>
                                                <a href="index.php?area=admin&controller=category&action=hide&id=<?= $category['id'] ?>"
                                                    class="btn btn-sm bg-amber-400 hover:bg-amber-500 border-0 text-white rounded-xl"
                                                    onclick="return confirm('Bạn muốn ẩn danh mục này?')">
                                                    Ẩn
                                                </a>
                                            <?php else: ?>
                                                <a href="index.php?area=admin&controller=category&action=active&id=<?= $category['id'] ?>"
                                                    class="btn btn-sm bg-green-500 hover:bg-green-600 border-0 text-white rounded-xl"
                                                    onclick="return confirm('Bạn muốn hiện danh mục này?')">
                                                    Hiện
                                                </a>
                                            <?php endif; ?>

                                            <a href="index.php?area=admin&controller=category&action=delete&id=<?= $category['id'] ?>"
                                                class="btn btn-sm bg-rose-500 hover:bg-rose-600 border-0 text-white rounded-xl"
                                                onclick="return confirm('Bạn chắc chắn muốn xóa/ẩn danh mục này?')">
                                                Xóa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">
                                    <div class="py-16 text-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center text-3xl mx-auto">
                                            🗂️
                                        </div>

                                        <p class="font-bold mt-4">Chưa có danh mục nào</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Hãy thêm danh mục đầu tiên cho website.
                                        </p>

                                        <a href="index.php?area=admin&controller=category&action=create"
                                            class="btn bg-gradient-to-r from-green-500 to-lime-500 border-0 text-white rounded-2xl mt-4">
                                            + Thêm danh mục
                                        </a>
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