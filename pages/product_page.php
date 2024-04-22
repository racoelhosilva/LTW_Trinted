<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product_page.tpl.php');
?>

<?php function drawProductPageContent() { ?>
    <main id="product-page">
        <?php drawProductPhotos("1"); ?>
    </main> 
<?php } ?>

<?php
function drawProductPage(Request $request) {
    createPage(function () {
        drawMainHeader();
        drawProductPageContent();
        drawFooter();
    });
} ?>