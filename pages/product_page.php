<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product_page.tpl.php');
?>

<?php function drawProductPageContent(Request $request) { ?>
    <main id="product-page">
        <?php drawProductPhotos($request->get('id')); ?>
        <?php drawProductInfo($request->get('id')); ?>
        <?php drawProductSection('Related Products'); ?>
    </main> 
<?php } ?>

<?php
function drawProductPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader();
        drawProductPageContent($request);
        drawFooter();
    });
} ?>