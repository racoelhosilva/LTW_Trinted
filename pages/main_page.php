<?php

declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/main_page.tpl.php';
require_once __DIR__ . '/../template/product.tpl.php';
?>

<?php function drawMainPageContent(Request $request)
{ ?>
    <main>
        <?php drawWelcomeBanner(); ?>
        <?php drawHomeProductsSection($request); ?>
    </main>
<?php } ?>

<?php
function drawMainPage(Request $request)
{
    createPage(function () use ($request) {
        drawMainHeader($request);
        drawMainPageContent($request);
        drawFooter();
    }, $request);
}
?>

<?php function drawHomeProductsSection(Request $request)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $products = Product::getNProducts($db, 15);
    drawProductSection($products, $request, "Explore new items");
} ?>