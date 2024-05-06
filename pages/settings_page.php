<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
?>

<?php function drawSettingsPageContent(Request $request) { ?>
    <main id="settings-page">
        <section id="account-settings">
            <h2>Account Information</h2>
        </section>
    </main> 
<?php } ?>

<?php
function drawSettingsPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader();
        drawSettingsPageContent($request);
        drawFooter();
    });
} ?>