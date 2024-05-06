<?php

declare(strict_types=1);
?>
<?php function drawLikeButton(string $product)
{ ?>
    <div class="like-button">
        <label class="material-symbols-outlined">
            <input type="checkbox">
            favorite_border
        </label>
    </div>
<?php } ?>

<?php function drawProductCard(Post $post)
{
    $db = new PDO("sqlite:" . DB_PATH);
?>
    <div class="product-card" onClick="goToProduct(<?= $post->id ?>)">
        <img src="<?= $post->getAllImages($db)[0]->url ?>" alt="<?= $post->item->name ?>">
        <h1><?= $post->title ?></h1>
        <p>$<?= $post->price ?></p>
        <?php drawLikeButton($post->title); ?>
    </div>
<?php } ?>