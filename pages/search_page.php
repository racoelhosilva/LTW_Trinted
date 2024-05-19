<?php

declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/search_page.tpl.php';
?>

<?php function drawSearchPageContent(Request $request) { ?>
    <main id="search-page">
        <?php drawSearchDrawer(); ?>
        <section id="search-results">
            <?php drawSearchedProducts($request); ?>
        </section>
    </main>
<?php } ?>

<?php function drawSearchPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawSearchPageContent($request);
        drawFooter();
    }, $request);
} ?>