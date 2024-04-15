<?php declare(strict_types = 1); ?>

<?php function createPage(callable $buildContent) { ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Trinted</title>
        </head>
        <body>
            <?php $buildContent(); ?>
        </body>
    </html>
<?php } ?>

<?php function drawMainHeader() { ?>
    <header id="main-header">
        <
    </header>
<?php } ?>

<?php function drawFooter() { ?>
    <footer>
    </footer>
<?php } ?>