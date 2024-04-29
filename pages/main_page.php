<?php
declare(strict_types = 1);

include_once('template/common.tpl.php');
include_once('template/main_page.tpl.php');
include_once('template/product.tpl.php');
?>

<?php function drawMainPageContent() { ?>
    <main>
        <?php drawWelcomeBanner(); ?>
        <?php drawProductSection('Explore new items'); ?>
    </main>
<?php } ?>

<?php 
function drawMainPage(Request $request) {
    createPage(function () {
        drawMainHeader();
        drawMainPageContent();
        drawFooter();
    });
}
?>
