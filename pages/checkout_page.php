<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/checkout_page.tpl.php');
include_once('db/classes/Product.class.php');
?>

<?php function drawCheckoutPageContent(Request $request) { ?>
    <main id="checkout-page">
        <?php drawOrderItems([]); ?>
        <?php drawCheckoutSummary(); ?>
        <?php drawCheckoutForm($request->getSession()->getCsrf()); ?>
    </main>
    <!-- <main id="checkout-empty" class="hidden">
        <?php // drawEmptyCart(); ?>
    </main> -->
<?php } ?>

<?php
function drawCheckoutPage(Request $request) {
    createPage(function () use ($request) {
        drawMainHeader();
        drawCheckoutPageContent($request);
        drawFooter();
    });
}
?>
