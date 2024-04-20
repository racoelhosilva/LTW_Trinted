<?php
declare(strict_types = 1);

include_once('template/common.tlp.php');
include_once('template/main_page.tlp.php');
include_once('template/product.tlp.php');
?>

<?php function drawMainPageContent() { ?>
    <main>
        <?php drawWelcomeBanner(); ?>
        <?php drawProductSection(); ?>
    </main>
<?php } ?>

<?php 
function drawMainPage() {
    createPage(function () {
        drawMainHeader();
        drawMainPageContent();
        drawFooter();
    });
}
?>

<?php drawMainPage(); ?>