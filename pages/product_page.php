<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product_page.tpl.php');
include_once('template/profile_page.tpl.php');
include_once('pages/404_page.php');
?>

<?php function drawProductPageContent(Request $request)
{ ?>
    <?php
    $db = new PDO("sqlite:" . DB_PATH);
    $post = Post::getPostByID($db, intval($request->get('id')));
    if (!isset($post)) {
        draw404PageContent();
        return;
    }
    ?>
    <main id="product-page">
        <?php drawProductPhotos($post); ?>
        <?php drawProductInfo($post); ?>
        <?php drawRelatedProductsSection($post); ?>
    </main>
<?php } ?>

<?php
function drawProductPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawProductPageContent($request);
        drawFooter();
    });
} ?>