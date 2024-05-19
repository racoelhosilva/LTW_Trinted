<?php
declare(strict_types=1);

require_once __DIR__ . 'template/main_header.tpl.php';
require_once __DIR__ . 'template/common.tpl.php';
require_once __DIR__ . 'rest_api/utils.php';
?>

<?php function drawBannedPageContent(Request $request)
{ ?>
    <main id="banned-page">
        <span id="number">BANNED</span>
        <span id="message">You have been banned</span>
        <form method="post" action="/actions/action_logout.php">
            <input type="hidden" name="user_id" value="<?= getSessionUser($request)['id'] ?>">
            <button type="submit" id="ok-button">Ok</button>
        </form>
    </main>
<?php } ?>

<?php function drawBannedPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader($request);
        drawBannedPageContent($request);
        drawFooter();
    }, $request);
} ?>