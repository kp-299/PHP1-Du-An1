<!DOCTYPE html>
<html lang="vi" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?= htmlspecialchars($title ?? ($settings['site_name'] ?? 'Trái Cây Tươi')) ?></title>

    <link rel="stylesheet" href="src/output.css?v=<?= time() ?>">

    <?php
    $settings = $settings ?? [];

    $primaryColor = $settings['primary_color'] ?? '#22c55e';
    $secondaryColor = $settings['secondary_color'] ?? '#84cc16';
    $accentColor = $settings['accent_color'] ?? '#f97316';
    $fontFamily = $settings['font_family'] ?? 'Inter, sans-serif';

    $backgroundType = $settings['background_type'] ?? 'color';
    $backgroundColor = $settings['background_color'] ?? '#f8fafc';
    $backgroundGradient = $settings['background_gradient'] ?? 'linear-gradient(135deg, #ecfdf5 0%, #f7fee7 50%, #fefce8 100%)';
    $backgroundImage = $settings['background_image'] ?? '';

    $bodyBackground = $backgroundColor;

    if ($backgroundType === 'gradient' && !empty($backgroundGradient)) {
        $bodyBackground = $backgroundGradient;
    }

    if ($backgroundType === 'image' && !empty($backgroundImage)) {
        $safeBackgroundImage = htmlspecialchars($backgroundImage, ENT_QUOTES);
        $bodyBackground = "url('{$safeBackgroundImage}') center/cover fixed no-repeat";
    }
    ?>

    <style>
        :root {
            --site-primary: <?= htmlspecialchars($primaryColor) ?>;
            --site-secondary: <?= htmlspecialchars($secondaryColor) ?>;
            --site-accent: <?= htmlspecialchars($accentColor) ?>;
            --site-font: <?= htmlspecialchars($fontFamily) ?>;
            --site-background: <?= $bodyBackground ?>;
        }

        body {
            font-family: var(--site-font);
            background: var(--site-background);
        }

        .site-primary-bg {
            background: var(--site-primary);
        }

        .site-primary-text {
            color: var(--site-primary);
        }

        .site-secondary-bg {
            background: var(--site-secondary);
        }

        .site-accent-bg {
            background: var(--site-accent);
        }

        .site-gradient-bg {
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary));
        }

        .site-gradient-text {
            background: linear-gradient(135deg, var(--site-primary), var(--site-secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .site-ring {
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--site-primary) 18%, transparent);
        }
    </style>
</head>

<body class="text-slate-900 overflow-x-hidden">
    <?php require __DIR__ . '/layouts/client_navbar.php'; ?>

    <main class="min-h-screen">
        <?= $content ?>
    </main>

    <?php require __DIR__ . '/layouts/client_footer.php'; ?>

    <?php if (($settings['popup_enabled'] ?? '0') === '1'): ?>
        <dialog id="site_popup_modal" class="modal">
            <div class="modal-box rounded-[2rem] border border-slate-200">
                <div class="w-14 h-14 rounded-2xl site-gradient-bg flex items-center justify-center text-3xl mb-4">
                    🍊
                </div>

                <h3 class="font-extrabold text-2xl text-slate-950">
                    <?= htmlspecialchars($settings['popup_title'] ?? 'Thông báo') ?>
                </h3>

                <p class="py-4 text-slate-600 leading-7">
                    <?= nl2br(htmlspecialchars($settings['popup_content'] ?? '')) ?>
                </p>

                <div class="modal-action">
                    <form method="dialog">
                        <button class="btn rounded-2xl site-gradient-bg border-0 text-white">
                            Đóng
                        </button>
                    </form>
                </div>
            </div>
        </dialog>

        <script>
            const popupModal = document.getElementById('site_popup_modal');

            if (popupModal && !sessionStorage.getItem('site_popup_seen')) {
                popupModal.showModal();
                sessionStorage.setItem('site_popup_seen', '1');
            }
        </script>
    <?php endif; ?>
</body>

</html>