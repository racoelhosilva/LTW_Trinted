<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/toast_message.tpl.php');
?>

<?php function drawProductPhotos(Post $post)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $images = $post->getAllImages($db);
    ?>
    <div id="product-photos">
        <span class="material-symbols-outlined" id="prev-photo">navigate_before</span>
        <span class="material-symbols-outlined" id="next-photo">navigate_next</span>
        <div id="photo-badges">
            <?php for ($i = 0; $i < count($images); $i++) { ?>
                <span class="material-symbols-outlined photo-badge">circle</span>
            <?php } ?>
        </div>
        <?php foreach ($images as $image) { ?>
            <img src="<?= $image->url ?>" class="product-photo">
        <?php } ?>
    </div>
<?php } ?>

<?php function drawRelatedProductsSection(Post $post)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $postsByCategory = Post::getPostsByCategory($db, $post->item->category);
    $user = $post->seller;
    $postsBySeller = $user->getUserPosts($db);

    $postsByBrand = array();
    $brands = $post->item->getBrands($db);
    foreach ($brands as $brand) {
        $postsByBrand = array_merge($postsByBrand, Post::getPostsByBrand($db, $brand));
    }
    $posts = array_merge($postsByCategory, $postsBySeller);
    $posts = array_merge($posts, $postsByBrand);
    $posts = array_unique($posts, SORT_REGULAR);
    $posts = array_filter($posts, function ($p) use ($post) {
        return $p->id != $post->id;
    });
    ?>
    <section id="product-section">
        <h1>Related products (<?= count($posts) ?>)</h1>
        <?php
        foreach ($posts as $post) {
            drawProductCard($post);
        }
        ?>
    </section>
<?php } ?>


<?php function drawProductInfo(Post $post)
{ ?>
    <div id="product-info">
        <div>
            <h2>Published on <?= date('m/d/Y', $post->publishDateTime) ?></h2>
            <h2>By <a href="actions/go_to_profile.php?id=<?= $post->seller->id ?>"><?= $post->seller->name ?></a></h2>
        </div>
        <a href="actions/go_to_profile.php?id=<?= $post->seller->id ?>"><img alt="Profile Picture"
                src="<?= $post->seller->profilePicture->url ?>" class="avatar"></a>
        <div class="details">
            <h1><?= $post->title ?></h1>
            <p class="price"><?= $post->price ?>€</p>
            <p>
                <strong>Size: </strong>
                <?= $post->item->size->size ?>
            <p>
            <p><strong>Condition: </strong><?= $post->item->condition->condition ?></p>
            <p><strong>Category: </strong> <?= $post->item->category->category ?></p>
            <p><strong>Brand: </strong> <?php
            $db = new PDO("sqlite:" . DB_PATH);
            $brands = $post->item->getBrands($db);
            foreach ($brands as $brand) {
                echo $brand->name . " ";
            }
            ?></p>
            <br>
            <p><strong>Description</strong></p>
        </div>
        <p class="description"><?= $post->description ?></p>
        <button class="add-cart-button">Add to Cart</button>
    </div>
<?php } ?>

<?php function drawRelatedProducts()
{
    $db = new PDO("sqlite:" . DB_PATH);
    $posts = Post::getNPosts($db, 10);
    drawProductSection($posts, "Related Products (" . count($posts) . ")");
} ?>
