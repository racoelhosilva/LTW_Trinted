<?php

declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/search_page.tpl.php';
?>

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
            <?php drawSearchedProducts($products, $page); ?>
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