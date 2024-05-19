<?php
declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
?>

<?php function drawAboutPageContent()
{ ?>
    <main id="about-page">
        <h1>Welcome to Our Second-Hand Marketplace Platform!</h1>
        <section>
            <h2>Overview</h2>
            <p>With Trinted, you can browse, wishlist, buy, and even sell all the second-hand clothing you could ever
                want!</p>
            <p>Discover a wide variety of pre-loved fashion right at your fingertips. Whether you're looking for vintage
                pieces, designer labels, or everyday basics at a fraction of the retail price, Trinted has it all. Our
                platform is designed to make buying and selling second-hand clothes easy, fun, and secure.</p>
            <p>Explore our extensive categories and find exactly what you need without breaking the bank. Our
                user-friendly interface allows you to search for items, add them to your wishlist, and complete
                purchases with just a few clicks. Selling your own clothing is just as simple—create a listing, upload
                photos, and set your price in minutes.</p>
            <p>At Trinted, we believe in the power of sustainability and giving clothes a second life. By choosing
                second-hand fashion, you're not only saving money but also contributing to a more sustainable future.
                Every purchase helps reduce waste and supports a community of eco-conscious shoppers and sellers.</p>
        </section>
        <footer>
            <p>Ready to get started? Create your account now and dive into the world of second-hand fashion with
                Trinted. Enjoy great deals, unique finds, and the satisfaction of knowing you’re making a difference.
                Happy shopping!</p>
        </footer>
    </main>
<?php } ?>

<?php
function drawAboutPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader();
        drawAboutPageContent($request);
        drawFooter();
    }, $request);
} ?>