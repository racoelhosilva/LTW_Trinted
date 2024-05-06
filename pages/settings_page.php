<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
?>

<?php function drawSettingsPageContent(Request $request) { ?>
    <main id="settings-page">
        <section id="account-settings">
            <h2>Account Information</h2>
            <div class="information-field">
                <h3>Change Username</h3>
                <input type="text" id="username" name="username" placeholder="Username">
            </div>
            <div class="information-field">
                <h3>Change E-mail</h3>
                <input type="text" id="email" name="email" placeholder="E-mail">
            </div>
            <div class="information-field">
                <h3>Change Password</h3>
                <input type="password" id="password" name="password" placeholder="Password">
            </div>
            <input type="submit" value="Save">
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