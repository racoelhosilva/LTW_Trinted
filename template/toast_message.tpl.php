<?php declare(strict_types=1); ?>

<?php function drawSuccessMessage(string $message, string $id) { ?>
    <div id="<?= $id ?>" class="toast-message success">
        <span class="material-symbols-outlined">check</span>
        <?= $message ?>
    </div>
<?php } ?>

<?php function drawErrorMessage(string $message, string $id) { ?>
    <div id="<?= $id ?>" class="toast-message error">
        <span class="material-symbols-outlined">error</span>
        <?= $message ?>
    </div>
<?php } ?>