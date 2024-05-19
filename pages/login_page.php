<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/login_page.tpl.php';
require_once __DIR__ . '/../template/common.tpl.php';
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

<?php function drawLoginPage(Request $request) {
    createPage(function () {
        drawLoginHeader();
        drawLoginPageContent();
        drawFooter();
    });
} ?>
