<?php
declare(strict_types = 1);

include_once('template/common.tpl.php');
include_once('template/message_page.tpl.php');
?>

<?php function drawMessagePageContent() { ?>
    <main id="message-box">
    <?php drawContactSection()?>
    <?php drawChatSection()?>
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