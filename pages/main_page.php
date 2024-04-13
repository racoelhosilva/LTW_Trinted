<?php
declare(strict_types = 1);

include_once('template/common.tlp.php');
?>

<?php function drawMainPageContent() { ?>
    <main>

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