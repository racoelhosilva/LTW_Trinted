<?php
declare(strict_types = 1);

include_once('template/common.tlp.php');
include_once('template/main_page.tlp.php');
?>

<?php function drawMainPageContent() { ?>
    <main>
        <?php drawWelcomeBanner(); ?>
    </main>
<?php } ?>

<?php 
function drawMainPage() {
    createPage(function () {
        drawMainHeader();
        drawMainPageContent();
        drawFooter();
    });
}
?>