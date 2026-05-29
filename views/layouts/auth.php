<!DOCTYPE html>
<html lang="vi" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= htmlspecialchars($title ?? 'Auth') ?></title>

    <link rel="stylesheet" href="src/output.css?v=<?= time() ?>">
</head>

<body class="min-h-screen bg-slate-950">
    <?= $content ?>
</body>

</html>