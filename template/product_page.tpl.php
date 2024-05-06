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
    <div id="product-info">
        <div>
            <h2>Published two weeks ago</h2>
            <h2>By <a href="profile"><?= $post->seller->name ?></a></h2>
        </div>
        <a href="profile"><img alt="Profile Picture" src="<?= $post->seller->profilePicture->url?>" class="avatar"></a>
        <div class="details">
            <h1><?= $product_id ?></h1>
            <p class="price">$55.49</p>
            <p><strong>Size:</strong> L
            <p>
            <p><strong>Condition:</strong> Barely Used</p>
            <p><strong>Category:</strong> Clothing</p>
            <p><strong>Brand:</strong> Abibas</p>
            <br>

            <p><strong>Description</strong></p>
        </div>
        <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat, pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat, pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat, pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat, pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat, pharetra eu arcu id, elementum.</p>
        <button class="add-cart-button">Add to Cart</button>
    </div>
<?php } ?>