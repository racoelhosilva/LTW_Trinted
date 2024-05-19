<?php
declare(strict_types=1);

require_once __DIR__ . '/common.tpl.php';
require_once __DIR__ . '/product.tpl.php';
?>

<?php function drawProductPhotos(Product $product)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $images = $product->getAllImages($db);
    ?>
    <div id="product-photos">
        <span class="material-symbols-outlined" id="prev-photo">navigate_before</span>
        <span class="material-symbols-outlined" id="next-photo">navigate_next</span>
        <div id="photo-badges">
            <?php for ($i = 0; $i < count($images); $i++) { ?>
                <span class="material-symbols-outlined photo-badge">circle</span>
            <?php } ?>
        </div>
        <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != $product->getSeller()->getId()) {
            drawLikeButton(User::getUserByID($db, (int)$_SESSION['user']['id'])->isInWishlist($db, $product), $product->getId());
        } ?>
        <?php foreach ($images as $image) { ?>
            <img src="<?= $image->getUrl() ?>" class="product-photo">
        <?php } ?>
    </div>
<?php } ?>

<?php function drawRelatedProductsSection(Product $product)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $productsByCategory = $product->getCategory() ? Product::getProductsByCategory($db, $product->getCategory()) : [];
    $user = $product->getSeller();
    $productsBySeller = $user->getUserProducts($db);

    $productsByBrand = array();
    $brands = $product->getBrands($db);
    foreach ($brands as $brand) {
        $productsByBrand = array_merge($productsByBrand, Product::getProductsByBrand($db, $brand));
    }
    $products = array_merge($productsByCategory, $productsBySeller);
    $products = array_merge($products, $productsByBrand);
    $products = array_unique($products, SORT_REGULAR);
    $products = array_filter($products, function ($p) use ($product) {
        return $p->getId() != $product->getId();
    });
    ?>
    <?php drawProductSection($products, "Related Products (" . count($products) . ")"); ?>
<?php } ?>


<?php function drawProductInfo(Product $product) { ?>
    <?php
    $db = new PDO("sqlite:" . DB_PATH);
    $brands = $product->getBrands($db);
    ?>
    <div id="product-info">
        <div>
            <h2>Published on <?= date('m/d/Y', $product->getPublishDatetime()) ?></h2>
            <h2>By <a href="/profile?id=<?= $product->getSeller()->getId() ?>"><?= $product->getSeller()->getName() ?></a></h2>
        </div>
        <a href="/profile?id=<?= $product->getSeller()->getId() ?>"><img alt="Profile Picture"
                src="<?= $product->getSeller()->getProfilePicture()->getUrl() ?>" class="avatar"></a>
        <div class="details">
            <h1><?= $product->getTitle() ?></h1>
            <p class="price"><?= $product->getPrice() ?></p>
            <p><strong>Size: </strong><?= $product->getSize()?->getName() ?><p>
            <p><strong>Condition: </strong><?= $product->getCondition()?->getName() ?></p>
            <p><strong>Category: </strong> <?= $product->getCategory()?->getName() ?></p>
            <p><strong>Brands: </strong>
            <?php
            echo join(', ', array_map(function ($brand) {
                return $brand->getName();
            }, $brands));
            ?>
            </php>
            <br>
            <p><strong>Description</strong></p>
        </div>
        <p class="description"><?= $product->getDescription() ?></p>
        <button class="add-cart-button">Add to Cart</button>
    </div>
<?php } ?>

<?php function drawRelatedProducts(Request $request)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $products = Product::getNProducts($db, 10);
    drawProductSection($products, "Related Products (" . count($products) . ")");
} ?>
