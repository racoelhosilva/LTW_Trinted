<?php
declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/checkout_page.tpl.php';
require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../actions/utils.php';
?>

<?php function drawCheckoutPageContent(Request $request) {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $cart = getCart($request, $db);

    if (!empty($cart)) { ?>
    <main id="checkout-page">
        <?php drawOrderItems([]); ?>
        <?php drawCheckoutSummary(); ?>
        <?php drawCheckoutForm($request->getSession()->getCsrf()); ?>
    </main>
    <?php } else { ?>
    <main id="checkout-empty">
        <?php drawEmptyCart(); ?>
    </main>
    <?php }
} ?>

<?php
function drawCheckoutPage(Request $request) {
    createPage(function () use ($request) {
        drawMainHeader($request);
        drawCheckoutPageContent($request);
        drawFooter();
    }, $request);
}
?>
