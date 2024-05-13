<?php

declare(strict_types=1);
?>
<?php function drawLikeButton(bool $checked)
{ ?>
    <div class="like-button">
        <label class="material-symbols-outlined">
            <input type="checkbox" <?php if ($checked) echo 'checked'; ?>>
            favorite_border
        </label>
    </div>
<?php } ?>

<?php function drawProductCard(Post $post, User $loggedInUser)
{
    $db = new PDO("sqlite:" . DB_PATH);
    ?>
    <div class="product-card" data-post-id="<?= $post->id ?>">
        <img src="<?= $post->getAllImages($db)[0]->url ?>" alt="<?= $post->item->name ?>">
        <h1><?= $post->title ?></h1>
        <p class="price"><?= $post->price ?></p>
        <?php if (isset($loggedInUser) && $loggedInUser->id != $post->seller->id) {
            drawLikeButton($loggedInUser->isInWishlist($db, (int)$post->id));
        } ?>
    </div>
<?php } ?>