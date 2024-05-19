<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/message_page.tpl.php';
?>

<?php function drawMessagePageContent() { ?>
    <main id="message-box">
    <?php drawContactSection()?>
    <?php drawChatSection()?>
    </main>
<?php } ?>

<?php 
function drawMessagePage(Request $request) {
    createPage(function () {
        drawMainHeader();
        drawMessagePageContent();
        drawFooter();
    });
}
?>