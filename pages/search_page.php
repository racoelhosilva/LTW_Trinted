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
    $posts = array_merge(Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10), Post::getNPosts($db, 10));
    $num_pages = (int)ceil(count($posts) / 15);
    ?>
    <main id="search-page">
        <?php drawSearchDrawer(); ?>
        <section id="search-results">
            <!-- TODO: use real search -->
            <?php
            drawSearchedProducts($posts, $page); ?>
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