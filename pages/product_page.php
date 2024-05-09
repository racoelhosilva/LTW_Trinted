<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product_page.tpl.php');
include_once('template/profile_page.tpl.php');
?>

<?php function drawProductPageContent(Request $request)
{ ?>
    <main id="product-page">
        <?php
        $db = new PDO("sqlite:" . DB_PATH);
        $post = Post::getPost($db, intval($request->get('id')));
        ?>
        <?php drawProductPhotos($post); ?>
        <?php drawProductInfo($post); ?>
        <?php drawUserProductSection($post->seller); ?>
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