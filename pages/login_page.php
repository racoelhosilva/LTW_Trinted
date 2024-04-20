<?php
declare(strict_types = 1);

include_once('template/login_page.tlp.php');
include_once('template/common.tlp.php');
?>

<?php function drawLoginPageContent() { ?>
    <main id="login-page">
        <div class="loginscreen">
            <div class="welcometext">
                <h1>Welcome to</h1>
                <h1 class="title">TRINTED</h1>
            </div>
            <div class="forms">
                <?php drawLoginForm(); ?>
                <?php drawRegisterForm(); ?>
            </div>
        </div>
    </main>
<?php } ?>

<?php function drawLoginPage() {
    createPage(function () {
        drawLoginHeader();
        drawLoginPageContent();
        drawFooter();
    });
} ?>

<?php drawLoginPage(); ?>
