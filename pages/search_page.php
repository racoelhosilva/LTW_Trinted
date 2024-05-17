<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/search_page.tpl.php');
?>

<!-- TODO: Remove this function-->
<?php function generateProducts(int $from, int $to): array
{
    $products = array();
    for ($i = $from; $i <= $to; $i++)
        $products[] = (string) $i;
    return $products;
} ?>

<?php function drawSearchPageContent(Request $request) { ?>
    <?php
    $page = (int) $request->get('page');
    $db = new PDO("sqlite:" . DB_PATH);
    $products = array_merge(Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10), Product::getNProducts($db, 10));
    $num_pages = (int)ceil(count($products) / 15);
    ?>
    <main id="search-page">
        <?php drawSearchDrawer(); ?>
        <section id="search-results">
            <!-- TODO: use real search -->
            <?php
            drawSearchedProducts($products, $page); ?>
        </section>
    </main>
<?php } ?>

<?php function drawSearchPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawSearchPageContent($request);
        drawFooter();
    });
} ?>