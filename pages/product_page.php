<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product_page.tpl.php');
?>

<?php function drawProductPageContent() { ?>
    <main>
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