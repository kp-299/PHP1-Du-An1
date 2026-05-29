<!DOCTYPE html>
<html lang="vi" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= htmlspecialchars($title ?? 'Trái Cây Tươi') ?></title>

    <link rel="stylesheet" href="/src/output.css?v=<?= time() ?>">
</head>

<body class="bg-slate-50 text-slate-900">
    <?php require __DIR__ . '/layouts/client_navbar.php'; ?>

    <main>
        <?= $content ?>
    </main>

    <?php require __DIR__ . '/layouts/client_footer.php'; ?>
</body>

</html>