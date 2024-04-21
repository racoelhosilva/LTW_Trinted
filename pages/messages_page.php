<?php
declare(strict_types = 1);

include_once('template/common.tpl.php');
?>

<?php function drawMessagePageContent() { ?>
    <main>
        <?php echo 'Messages Page' ?>
    </main>
<?php } ?>

<?php 
function drawMessagePage() {
    createPage(function () {
        drawMainHeader();
        drawMessagePageContent();
        drawFooter();
    });
}
?>

<?php drawMessagePage(); ?>