<?php
declare(strict_types = 1);

include_once('template/common.tlp.php');
include_once('template/main_page.tlp.php');
include_once('template/product.tlp.php');
?>

<?php function drawWelcomeBanner() { ?>
    <div id="welcome-banner">
        <h1>Welcome to Trinted!</h1>
        <p>Buy and sell <strong>trillions of pre-loved</strong> items!</p>
        <?php drawStartNowButton(); ?>
    </div>
<?php } ?>

<?php function drawProductSection() { ?>
    <div id="product-section">
        <h1>Explore new items</h1>
        <div id="product-section-cards">
            <?php
            for ($i = 0; $i < 10; $i++) {
                drawProductCard((string)$i);
            }
            ?>
        </div>
    </div>
<?php } ?>

<?php function drawMainPageContent() { ?>
    <main>
        <?php drawWelcomeBanner(); ?>
        <?php drawProductSection(); ?>
    </main>
<?php } ?>

<?php 
function drawMainPage() {
    createPage(function () {
        drawMainHeader();
        drawMainPageContent();
        drawFooter();
    });
}
?>