<!DOCTYPE html>
<html lang="vi" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= htmlspecialchars($title ?? 'Fruit Admin') ?></title>

    <link rel="stylesheet" href="/src/output.css?v=<?= time() ?>">
</head>

<body class="h-screen overflow-hidden bg-slate-100 text-slate-800">
    <div class="h-screen flex overflow-hidden">
        <?php require __DIR__ . '/admin_sidebar.php'; ?>

        <div class="flex-1 min-w-0 h-screen flex flex-col overflow-hidden">
            <?php require __DIR__ . '/admin_header.php'; ?>

            <main class="flex-1 overflow-y-auto p-5 lg:p-8 bg-slate-100">
                <?php require __DIR__ . '/../components/admin_flash.php'; ?>

                <div class="admin-page max-w-[1600px] mx-auto">
                    <?= $content ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>