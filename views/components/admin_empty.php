<?php
$message = $message ?? 'Không có dữ liệu.';
$description = $description ?? '';
$actionUrl = $actionUrl ?? '';
$actionText = $actionText ?? '';
?>

<div class="text-center py-10">
    <div class="max-w-md mx-auto">
        <p class="font-semibold text-lg">
            <?= htmlspecialchars($message) ?>
        </p>

        <?php if (!empty($description)): ?>
            <p class="text-sm text-base-content/60 mt-2">
                <?= htmlspecialchars($description) ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($actionUrl) && !empty($actionText)): ?>
            <a href="<?= htmlspecialchars($actionUrl) ?>" class="btn btn-primary btn-sm mt-4">
                <?= htmlspecialchars($actionText) ?>
            </a>
        <?php endif; ?>
    </div>
</div>