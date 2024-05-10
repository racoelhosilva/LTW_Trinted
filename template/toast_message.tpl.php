<?php declare(strict_types=1); ?>

<?php function drawSuccessMessage(string $message, string $id) { ?>
    <div id="<?= $id ?>" class="toast-message">
        <span class="material-symbols-outlined">check</span>
        <?= $message ?>
    </div>
<?php } ?>