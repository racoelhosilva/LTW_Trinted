<?php

declare(strict_types=1);
?>
<?php function drawLikeButton(bool $checked, int $productId)
{ ?>
    <div class="like-button" data-product-id="<?= $productId ?>">
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
        <img src="<?= $product->getAllImages($db)[0]->getUrl() ?>" alt="<?= $product->getTitle() ?>">
        <h1><?= $product->getTitle() ?></h1>
        <p class="price"><?= $product->getPrice() ?></p>
        <?php if (isset($loggedInUser) && $loggedInUser->getId() != $product->getSeller()->getId()) {
            drawLikeButton($loggedInUser->isInWishlist($db, $product), $product->getId());
        } ?>
    </div>
<?php } ?>