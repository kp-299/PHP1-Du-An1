<?php if (!empty($_SESSION['flash'])): ?>
    <?php
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    $type = $flash['type'] ?? 'info';
    $message = $flash['message'] ?? '';

    $alertClass = 'alert-info';

    if ($type === 'success') {
        $alertClass = 'alert-success';
    }

    if ($type === 'error') {
        $alertClass = 'alert-error';
    }

    if ($type === 'warning') {
        $alertClass = 'alert-warning';
    }
    ?>

    <div class="alert <?= $alertClass ?> mb-6">
        <span><?= htmlspecialchars($message) ?></span>
    </div>
<?php endif; ?>