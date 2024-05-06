<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
?>

<?php function drawAboutPageContent() { ?>
    <main id="about-page">
        <h1>Welcome to Our Second-Hand Marketplace Platform!</h1>

        <section>
            <h2>Overview</h2>
            <p>Our platform features three types of users: sellers, buyers, and admins. Here's what each user can do:</p>
            <ul>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
                <li><strong>Sellers</strong> can list and manage their items, respond to buyer inquiries, and print shipping forms.</li>
                <li><strong>Buyers</strong> can browse items, engage with sellers, add items to a wishlist or shopping cart, and proceed to checkout.</li>
                <li><strong>Admins</strong> can manage user roles, introduce new item categories, and oversee the smooth operation of the platform.</li>
            </ul>
            
        </section>

        <footer>
            <p>Join us today and experience the convenience of buying and selling second-hand items!</p>
        </footer>
    </main> 
<?php } ?>

<?php
function drawAboutPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader();
        drawAboutPageContent();
        drawFooter();
    });
} ?>