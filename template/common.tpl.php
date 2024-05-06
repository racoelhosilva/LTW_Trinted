<?php

declare(strict_types=1);

include_once('template/main_header.tpl.php');
include_once('template/product.tpl.php');
?>

<?php function createPage(callable $buildContent)
{ ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="icon" href="icon/logo.ico">
            <link rel="stylesheet" href="css/styles.css">
            <link rel="stylesheet" href="css/main_header.css">
            <link rel="stylesheet" href="css/footer.css">
            <link rel="stylesheet" href="css/404_page.css">
            <link rel="stylesheet" href="css/main_page.css">
            <link rel="stylesheet" href="css/product.css">
            <link rel="stylesheet" href="css/login_page.css">
            <link rel="stylesheet" href="css/title.css">
            <link rel="stylesheet" href="css/search_page.css">
            <link rel="stylesheet" href="css/profile_page.css">
            <link rel="stylesheet" href="css/product_page.css">
            <script src="typescript/product_page.js" defer></script>
            <script src="typescript/product.js" defer></script>
            <script src="typescript/main_page.js" defer></script>
            <title>Trinted</title>
        </head>
        <body>
            <?php $buildContent(); ?>
        </body>
    </html>
    <script 
<?php } ?>

<?php function drawMainHeader()
{ ?>
    <header id="main-header">
        <?php drawHamburgerButton(); ?>
        <?php drawHeaderLogo(); ?>
        <?php drawSearchBar(); ?>
        <?php drawActionButtons(); ?>
    </header>
<?php } ?>

<?php function drawProductSection(User $user)
{ 
    $db = new PDO("sqlite:" . DB_PATH);
    $posts = $user->getUserPosts($db);
    ?>
    <section id="product-section">
        <h1>Products by the seller (<?= count($posts) ?>)</h1>
            <?php
            foreach ($posts as $post) {
                drawProductCard($post);
            }
            ?>
    </section>
<?php } ?>

<?php function drawFooter()
{ ?>
    <footer id="main-footer">
    </footer>
<?php } ?>