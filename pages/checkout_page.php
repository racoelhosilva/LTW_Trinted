<?php
declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/checkout_page.tpl.php';
require_once __DIR__ . '/../framework/Autoload.php';
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
