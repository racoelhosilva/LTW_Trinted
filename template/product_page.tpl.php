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
        <?php if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] != $product->seller->id) {
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
    $productsByCategory = Product::getProductsByCategory($db, $product->category);
    $user = $product->seller;
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
        return $p->id != $product->id;
    });
    ?>
    <?php drawProductSection($products, "Related Products (" . count($products) . ")"); ?>
<?php } ?>


<?php function drawProductInfo(Product $product)
{ ?>
    <div id="product-info">
        <div>
            <h2>Published on <?= date('m/d/Y', $product->publishDateTime) ?></h2>
            <h2>By <a href="/actions/go_to_profile.php?id=<?= $product->seller->id ?>"><?= $product->seller->name ?></a></h2>
        </div>
        <a href="/actions/go_to_profile.php?id=<?= $product->seller->id ?>"><img alt="Profile Picture"
                src="<?= $product->seller->profilePicture->url ?>" class="avatar"></a>
        <div class="details">
            <h1><?= $product->title ?></h1>
            <p class="price"><?= $product->price ?></p>
            <p>
                <strong>Size: </strong>
                <?= $product->size->name ?>
            <p>
            <p><strong>Condition: </strong><?= $product->condition->name ?></p>
            <p><strong>Category: </strong> <?= $product->category->name ?></p>
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
        <p class="description"><?= $product->description ?></p>
        <button class="add-cart-button">Add to Cart</button>
    </div>
<?php } ?>

<?php function drawRelatedProducts()
{
    $db = new PDO("sqlite:" . DB_PATH);
    $products = Product::getNProducts($db, 10);
    drawProductSection($products, "Related Products (" . count($products) . ")");
} ?>
