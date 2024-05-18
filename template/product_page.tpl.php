<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product.tpl.php');
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
        <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != $product->getSeller()->id) {
            drawLikeButton(User::getUserByID($db, (int)$_SESSION['user']['id'])->isInWishlist($db, $_SESSION['user']['id']));
        } ?>
        <?php foreach ($images as $image) { ?>
            <img src="<?= $image->url ?>" class="product-photo">
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


<?php function drawProductInfo(Product $product)
{ ?>
    <div id="product-info">
        <div>
            <h2>Published on <?= date('m/d/Y', $product->getPublishDatetime()) ?></h2>
            <h2>By <a href="/actions/go_to_profile.php?id=<?= $product->getSeller()->id ?>"><?= $product->getSeller()->name ?></a></h2>
        </div>
        <a href="/actions/go_to_profile.php?id=<?= $product->getSeller()->id ?>"><img alt="Profile Picture"
                src="<?= $product->getSeller()->profilePicture->url ?>" class="avatar"></a>
        <div class="details">
            <h1><?= $product->getTitle() ?></h1>
            <p class="price"><?= $product->getPrice() ?></p>
            <p><strong>Size: </strong><?= $product->getSize()?->getName() ?><p>
            <p><strong>Condition: </strong><?= $product->getCondition()?->getName() ?></p>
            <p><strong>Category: </strong> <?= $product->getCategory()?->getName() ?></p>
            <p><strong>Brands: </strong> <?php
            $db = new PDO("sqlite:" . DB_PATH);
            $brands = $product->getBrands($db);
            foreach ($brands as $brand) {
                echo $brand->name . " ";
            }
            ?></p>
            <br>
            <p><strong>Description</strong></p>
        </div>
        <p class="description"><?= $product->getDescription() ?></p>
        <button class="add-cart-button">Add to Cart</button>
    </div>
<?php } ?>

<?php function drawRelatedProducts()
{
    $db = new PDO("sqlite:" . DB_PATH);
    $products = Product::getNProducts($db, 10);
    drawProductSection($products, "Related Products (" . count($products) . ")");
} ?>
