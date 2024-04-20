<?php declare(strict_types=1);

include_once('template/common.tlp.php');
include_once('template/search_page.tlp.php');
?>

<?php function drawSearchPageContent() { ?>
    <main id="search-page">
        <?php drawProducts(); ?>
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