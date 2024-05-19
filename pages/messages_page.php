<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/message_page.tpl.php';
?>

<?php function drawMessagePageContent(Request $request) { ?>
    <main id="message-box">
    <?php drawContactSection($request)?>
    <?php drawChatSection($request)?>
    </main>
<?php } ?>

<?php 
function drawMessagePage(Request $request) {
    createPage(function () use ($request) {
        drawMainHeader($request);
        drawMessagePageContent($request);
        drawFooter();
    }, $request);
}
?>