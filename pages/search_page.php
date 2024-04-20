<?php declare(strict_types=1);

include_once('template/common.tlp.php');
include_once('template/search_page.tlp.php');
?>

<!-- TODO: Remove this function -->
<?php function generateProducts(int $from, int $to): array {
    $products = array();
    for ($i = $from; $i <= $to; $i++)
        $products[] = (string) $i;
    return $products;
} ?>

<?php function drawSearchPageContent() { ?>
    <?php $page = (int) $_GET['page'] ?>
    <main id="search-page">
        <?php drawProducts(generateProducts($page * 20 - 19, $page * 20)); ?>
        <?php drawPagination(10, $page); ?>
    </main>
<?php } ?>

<?php function drawSearchPage() {
    createPage(function () {
        drawMainHeader();
        drawSearchPageContent();
        drawFooter();
    });
} ?>

<?php drawSearchPage(); ?>