<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/main_header.tpl.php';
require_once __DIR__ . '/../template/common.tpl.php';
?>

<?php function draw404PageContent() { ?>
    <main id="page-404">
        <span id="number">404</span>
        <span id="message">Page Not Found</span>
    </main>
<?php } ?>

<?php function draw404Page() {
    createPage(function () {
        drawMainHeader();
        draw404PageContent();
        drawFooter();
    });
} ?>
