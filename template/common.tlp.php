<?php
declare(strict_types = 1);

include_once('template/main_header.tlp.php');
?>

<?php function createPage(callable $buildContent) { ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <link rel="stylesheet" href="css/main_header.css">
            <link rel="stylesheet" href="css/main_footer.css">
            <link rel="stylesheet" href="css/main_page.css">
            <link rel="stylesheet" href="css/product.css">
            <title>Trinted</title>
        </head>
        <body>
            <?php $buildContent(); ?>
        </body>
    </html>
<?php } ?>

<?php function drawMainHeader() { ?>
    <header id="main-header">
        <?php drawHamburgerButton(); ?>
        <?php drawHeaderLogo(); ?>
        <?php drawSearchBar(); ?>
        <?php drawActionButtons(); ?>
    </header>
<?php } ?>

<?php function drawFooter() { ?>
    <footer id="main-footer">
    </footer>
<?php } ?>