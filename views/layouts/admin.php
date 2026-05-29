<!DOCTYPE html>
<html lang="vi" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= htmlspecialchars($title ?? 'Fruit Admin') ?></title>

    <link rel="stylesheet" href="/src/output.css?v=<?= time() ?>">
</head>

<body class="h-screen overflow-hidden bg-slate-100 text-slate-800">
    <div class="drawer lg:drawer-open h-screen overflow-hidden">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle">

        <!-- Main content -->
        <div class="drawer-content h-screen flex flex-col overflow-hidden">
            <?php require __DIR__ . '/admin_header.php'; ?>

            <main class="flex-1 overflow-y-auto bg-slate-100">
                <div class="w-full px-3 py-4 sm:px-5 sm:py-5 lg:px-8 lg:py-8">
                    <?php require __DIR__ . '/../components/admin_flash.php'; ?>

                    <div class="admin-page w-full max-w-[1600px] mx-auto">
                        <?= $content ?>
                    </div>
                </div>
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-50">
            <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

            <?php require __DIR__ . '/admin_sidebar.php'; ?>
        </div>
    </div>
</body>

</html>