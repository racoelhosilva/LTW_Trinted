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
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>
            <div class="information-field">
                <h3>Change E-mail</h3>
                <input type="e-mail" id="new-email" name="newemail" placeholder="New E-mail">
            </div>
            <div class="information-field">
                <h3>Change Password</h3>
                <input type="password" id="new-password" name="newpassword" placeholder="New Password">
            </div>
            <br>
            <div class="information-field">
                <h3>Validate with Current Password</h3>
                <input type="password" id="old-password" required name="currentpassword" placeholder="Current Password">
            </div>
            <input type="button" id="settings-button" value="Save">
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