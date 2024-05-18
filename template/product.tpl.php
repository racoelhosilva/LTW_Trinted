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

<?php function drawProductCard(Product $product, ?User $loggedInUser)
{
    $db = new PDO("sqlite:" . DB_PATH);
    ?>
    <div class="product-card" data-product-id="<?= $product->getId() ?>">
        <img src="<?= $product->getAllImages($db)[0]->url ?>" alt="<?= $product->getTitle() ?>">
        <h1><?= $product->getTitle() ?></h1>
        <p class="price"><?= $product->getPrice() ?></p>
        <?php if (isset($loggedInUser) && $loggedInUser->getId() != $product->getSeller()->getId()) {
            drawLikeButton($loggedInUser->isInWishlist($db, $product));
        } ?>
    </div>
<?php } ?>