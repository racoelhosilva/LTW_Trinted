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

<?php function drawSearchPageContent(Request $request)
{ ?>
    <?php $page = (int) $request->get('page') ?>
    <main id="search-page">
        <?php drawSearchDrawer(); ?>
        <section id="results">
            <h1>Found 200 results</h1>
            <!-- TODO: use real search -->
            <?php
            $db = new PDO("sqlite:" . DB_PATH);
            drawProducts(Post::getNPosts($db, 10)); ?>
            <?php drawPagination(10, $page); ?>
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