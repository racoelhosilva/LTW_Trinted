<?php

declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/product_page.tpl.php';
require_once __DIR__ . '/../template/profile_page.tpl.php';
require_once __DIR__ . '/../template/shipping_form_page.tpl.php';
require_once __DIR__ . '/404_page.php';
require_once __DIR__ . '/../framework/Autoload.php';
?>

<?php function drawProductPageContent(Request $request, int $productId)
{ ?>
    <?php
    $db = new PDO("sqlite:" . DB_PATH);
    $product = Product::getProductByID($db, $productId);
    if (!isset($product)) {
        draw404PageContent();
        return;
    }

    if (is_null($product->getPayment())){ ?>
        <main id="product-page">
            <?php drawProductPhotos($product); ?>
            <?php drawProductInfo($product); ?>
            <?php drawRelatedProductsSection($product); ?>
        </main>
    <?php } elseif ($request->session('user_id') == $product->getSeller()->getId()) { ?>
        <main id="shipping-form">
            <?php 
                drawShippingForm($product); 
            ?>
        </main>
    <?php } else { 
        draw404PageContent();
        return;
    }
} ?>

<?php
function drawProductPage(Request $request, int $productId)
{
    createPage(function () use ($request, $productId) {
        drawMainHeader();
        drawProductPageContent($request, $productId);
        drawFooter();
    });
} ?>