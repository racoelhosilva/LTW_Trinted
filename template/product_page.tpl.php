<?php

declare(strict_types=1); ?>

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

<?php function drawProductInfo(Post $post)
{ ?>
    <!-- TODO date missing and profile button is redirecting to user profile -->
    <div id="product-info">
        <div>
            <h2>Published two weeks ago</h2>
            <h2>By <a href="profile"><?= $post->seller->name ?></a></h2>
        </div>
        <a href="profile"><img alt="Profile Picture" src="<?= $post->seller->profilePicture->url ?>" class="avatar"></a>
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