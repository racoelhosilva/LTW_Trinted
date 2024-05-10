<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/checkout_page.tpl.php');
include_once('db/classes/Post.class.php');
?>

<?php function drawCheckoutPageContent() { ?>
    <?php $db = new PDO("sqlite:" . DB_PATH); ?>
    <main id="checkout-page">
        <?php drawOrderItems(); ?>
        <?php drawCheckoutSummary(); ?>
        <?php drawCheckoutForm(); ?>
        <?php drawPaymentSuccess(); ?>
    </main>
    <!-- <main id="checkout-empty" class="hidden">
        <?php // drawEmptyCart(); ?>
    </main> -->
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
