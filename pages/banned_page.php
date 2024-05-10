<?php
declare(strict_types = 1);

include_once('template/main_header.tpl.php');
include_once('template/common.tpl.php');
?>

<?php function drawBannedPageContent() { ?>
    <main id="page-404">
        <span id="number">404</span>
        <span id="message">You have been banned</span>
    </main>
<?php } ?>

<?php function drawBannedPage() {
    createPage(function () {
        drawMainHeader();
        drawBannedPageContent();
        drawFooter();
    });
} ?>
