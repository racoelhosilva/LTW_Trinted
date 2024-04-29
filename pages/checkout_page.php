<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/checkout_page.tpl.php');
?>

<?php function drawCheckoutPageContent() { ?>
    <main id="checkout-page">
    </main>
<?php } ?>

<?php
function drawCheckoutPage(Request $request) {
    createPage(function () {
        drawMainHeader();
        drawCheckoutPageContent();
        drawFooter();
    });
}
?>
