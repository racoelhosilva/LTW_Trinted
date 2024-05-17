<?php
declare(strict_types=1);

include_once ('template/main_header.tpl.php');
include_once ('template/common.tpl.php');
?>

<?php function drawBannedPageContent()
{ ?>
    <main id="banned-page">
        <span id="number">BANNED</span>
        <span id="message">You have been banned</span>
        <form method="post" action="/actions/logout.php">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
            <button type="submit" id="ok-button">Ok</button>
        </form>
    </main>
<?php } ?>

<?php function drawBannedPage()
{
    createPage(function () {
        drawMainHeader();
        drawBannedPageContent();
        drawFooter();
    });
} ?>