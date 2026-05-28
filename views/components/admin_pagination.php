<?php
$currentPage = $currentPage ?? 1;
$totalPages = $totalPages ?? 1;
$query = $_GET;
?>

<?php if ($totalPages > 1): ?>
    <div class="join">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php
            $query['page'] = $i;
            $url = 'index.php?' . http_build_query($query);
            ?>

            <a href="<?= htmlspecialchars($url) ?>" class="join-item btn <?= $i == $currentPage ? 'btn-active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>