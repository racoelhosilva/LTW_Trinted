<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/main_page.tpl.php');
include_once('template/product.tpl.php');
?>

<?php function drawMainPageContent()
{ ?>
    <main>
        <?php drawWelcomeBanner(); ?>
        <?php drawHomeProductsSection(); ?>
    </main>
<?php } ?>

<?php
function drawMainPage(Request $request)
{
    createPage(function () {
        drawMainHeader();
        drawMainPageContent();
        drawFooter();
    });
}
?>

<?php function drawHomeProductsSection()
{
    $db = new PDO("sqlite:" . DB_PATH);
    $posts = Post::getNPosts($db, 10);
    drawProductSection($posts, "Explore new items");
} ?>