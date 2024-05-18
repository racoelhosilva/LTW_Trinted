<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product_page.tpl.php');
include_once('template/profile_page.tpl.php');
include_once('template/shipping_form_page.tpl.php');
include_once('pages/404_page.php');
include_once('db/classes/Payment.class.php');
?>

<?php function drawProductPageContent(Request $request)
{ ?>
    <?php
    $db = new PDO("sqlite:" . DB_PATH);
    $post = Post::getPostByID($db, intval($request->get('id')), false);
    if (!isset($post)) {
        draw404PageContent();
        return;
    }

    if (is_null($post->payment)){ ?>
        <main id="product-page">
            <?php drawProductPhotos($post); ?>
            <?php drawProductInfo($post); ?>
            <?php drawRelatedProductsSection($post); ?>
        </main>
    <?php } elseif ($request->session('user_id') == $post->seller->id) { ?>
        <main id="shipping-form">
            <?php 
                drawShippingForm($post); 
            ?>
        </main>
    <?php } else { 
        draw404PageContent();
        return;
    }
} ?>

<?php
function drawProductPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawProductPageContent($request);
        drawFooter();
    });
} ?>