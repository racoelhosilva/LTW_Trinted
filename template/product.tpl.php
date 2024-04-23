<?php

declare(strict_types=1); ?>

<?php function drawLikeButton(string $product)
{ ?>
    <button type="checkbox">
        <span class="material-icons">favorite_border</span>
    </button>
<?php } ?>

<?php function drawProductCard(Post $post)
{
    $db = new PDO("sqlite:" . DB_PATH);
?>
    <div class="product-card">
        <img src="<?= $post->getAllImages($db)[0]->url ?>" alt="<?= $post->item->name ?>">
        <h1><?= $post->title ?></h1>
        <p>$<?= $post->price ?></p>
        <?php drawLikeButton($post->title); ?>
    </div>
<?php } ?>