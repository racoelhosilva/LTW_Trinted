<?php

declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/main_page.tpl.php';
require_once __DIR__ . '/../template/product.tpl.php';
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
    $products = Product::getNProducts($db, 15);
    drawProductSection($products, "Explore new items");
} ?>