<?php
declare(strict_types=1);

require_once __DIR__ . 'template/common.tpl.php';
?>

<?php function drawAboutPageContent() { ?>
    <main id="about-page">
        <h1>Welcome to Our Second-Hand Marketplace Platform!</h1>
        <section>
            <h2>Overview</h2>
            <p>With Trinted, you can browse, wishlist, buy and even sell all of the second-hand products you could ever want!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non eleifend lectus, a consequat nisl. Proin non nunc sit amet neque lobortis cursus. Donec nec pretium mauris. Nulla varius imperdiet suscipit. Ut massa turpis, luctus ac urna sed, hendrerit feugiat tellus. Morbi ut lorem porta, convallis orci quis, semper mauris. Donec dapibus ligula nibh, at venenatis neque tincidunt at. Etiam congue pulvinar magna at hendrerit. Ut consequat odio erat. Integer vel ante eget diam molestie congue a vel nisl. Donec quis urna nec dolor pulvinar tristique eget sed mauris. Duis eget scelerisque sem. Vestibulum nibh turpis, accumsan eget tempor eu, posuere eu turpis.</p>
            <p>Morbi sed risus quis dui interdum ultricies vitae vel mauris. Nam pellentesque, dolor id varius blandit, mi urna efficitur felis, sed consectetur odio libero elementum lorem. Vivamus accumsan ut nisi vitae blandit. Aliquam diam risus, volutpat non erat posuere, ultricies suscipit metus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aliquam sem elit, hendrerit vitae volutpat nec, vehicula et ipsum. Etiam tellus tortor, tincidunt nec odio eu, maximus accumsan ante. Fusce at facilisis arcu, non porta tortor. Nullam sodales mi id laoreet iaculis. Integer porta arcu in massa volutpat, a posuere lacus tincidunt. Nulla sodales varius rhoncus. Donec rhoncus justo placerat, auctor ante ut, vestibulum est. Sed eros diam, fringilla id libero sit amet, pellentesque tincidunt urna. Vestibulum lacinia lacus vitae leo sodales fringilla. Etiam volutpat tempor tincidunt.</p>
            <p>Mauris ultrices orci a ultricies sollicitudin. Pellentesque quis ex id turpis convallis luctus accumsan non libero. In vel tellus id metus aliquet fermentum nec porttitor ex. Aliquam vitae bibendum lectus. Phasellus posuere augue ipsum, a malesuada neque aliquet interdum. Integer tempor mauris sit amet est dapibus, non dapibus turpis euismod. Aliquam in nibh dapibus, cursus eros non, efficitur ipsum. Phasellus mattis pretium ante et scelerisque. Nam pulvinar arcu ut tortor accumsan feugiat. Praesent lacinia sollicitudin tortor. Phasellus dictum eros commodo feugiat efficitur. Aliquam ornare sapien non sollicitudin consectetur.</p>
        </section>
        <footer>
            <p>Join us today and experience the convenience of buying and selling second-hand items!</p>
        </footer>
    </main> 
<?php } ?>

<?php
function drawAboutPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader($request);
        drawAboutPageContent();
        drawFooter();
    }, $request);
} ?>