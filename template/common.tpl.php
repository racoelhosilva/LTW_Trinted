<?php

declare(strict_types=1);

require_once __DIR__ . '/main_header.tpl.php';
require_once __DIR__ . '/product.tpl.php';
require_once __DIR__ . '/../rest_api/utils.php';
?>

<?php function createPage(callable $buildContent, Request $request)
{ ?>
    <?php $csrfToken = $request->getSession()->getCsrf(); ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="csrf-token" content="<?= htmlspecialchars($csrfToken) ?>">
            <link rel="icon" href="/icon/logo.ico">
            <link rel="stylesheet" href="/css/styles.css">
            <link rel="stylesheet" href="/css/main_header.css">
            <link rel="stylesheet" href="/css/footer.css">
            <link rel="stylesheet" href="/css/404_page.css">
            <link rel="stylesheet" href="/css/main_page.css">
            <link rel="stylesheet" href="/css/messages_page.css">
            <link rel="stylesheet" href="/css/product.css">
            <link rel="stylesheet" href="/css/login_page.css">
            <link rel="stylesheet" href="/css/title.css">
            <link rel="stylesheet" href="/css/search_page.css">
            <link rel="stylesheet" href="/css/profile_page.css">
            <link rel="stylesheet" href="/css/product_page.css">
            <link rel="stylesheet" href="/css/settings_page.css">
            <link rel="stylesheet" href="/css/checkout_page.css">
            <link rel="stylesheet" href="/css/about_page.css">
            <link rel="stylesheet" href="/css/help_page.css">
            <link rel="stylesheet" href="/css/toast_message.css">
            <link rel="stylesheet" href="/css/banned_page.css">
            <link rel="stylesheet" href="/css/dashboard_page.css">
            <link rel="stylesheet" href="/css/shipping_form_page.css">
            <link rel="stylesheet" href="/css/new_product_page.css">
            <link rel="stylesheet" href="/css/edit_product_page.css">
            <script src="/javascript/utils.js" defer></script>
            <script src="/javascript/product.js" defer></script>
            <script src="/javascript/product_page.js" defer></script>
            <script src="/javascript/main_page.js" defer></script>
            <script src="/javascript/main_header.js" defer></script>
            <script src="/javascript/checkout_page.js" defer></script>
            <script src="/javascript/search_page.js" defer></script>
            <script src="/javascript/contacts.js" defer></script>
            <script src="/javascript/messages.js" defer></script>
            <script src="/javascript/profile.js" defer></script>
            <script src="/javascript/settings.js" defer></script>
            <script src="/javascript/dashboard_page.js" defer></script>
            <title>Trinted</title>
        </head>
        <body>
            <?php $buildContent(); ?>
        </body>
    </html>
    <script 
<?php } ?>

<?php function drawMainHeader(Request $request)
{ ?>
    <header id="main-header">
        <?php drawHamburgerButton(); ?>
        <?php drawHeaderLogo(); ?>
        <?php drawSearchBar(); ?>
        <?php drawActionButtons($request); ?>
    </header>
<?php } ?>

<?php function drawFooter()
{ ?>
    <footer id="main-footer">
    <div id="footer-content">
        <div id="about">
            <h1>About Us</h1>
            <ul>
                <li><a href="/about">About Us</a></li>
            </ul>
        </div>
        <div id="help">
            <h1>Help</h1>
            <ul>
                <li><a href="/help">Help & Tips</a></li>
            </ul>
        </div>
        
        <div id="legal">
            <ul>
            <li><a href="cookie-policy">Cookie Policy</a></li>
            <li><a href="privacy-policy">Privacy Policy</a></li>
            <li><a href="terms-and-conditions">Terms & Conditions</a></li>
            </ul>
        </div>
    </div>
    </footer>
<?php } ?>

<?php function drawLoadingSpinner() { ?>
    <div class="spinner"><div></div></div>
<?php } ?>

<?php function drawProductSection(array $products, Request $request, string $title, string $emptyMessage = "No products here") { ?>
    <?php
        $db = new PDO("sqlite:" . DB_PATH);
        $loggedInUser = isLoggedIn($request) ? User::getUserByID($db, $request->session('user')['id']) : null;
    ?>
    <section id="product-section">
        <h1><?= $title ?></h1>
        <?php if (count($products) === 0) { ?>
            <h2><?= $emptyMessage ?></h2>
        <?php } else { ?>
            <?php foreach ($products as $product) {
                drawProductCard($product, $loggedInUser);
            } ?>
        <?php } ?>
    </section>
<?php } ?>
