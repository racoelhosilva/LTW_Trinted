<?php declare(strict_types = 1); ?>

<?php function drawLikeButton(string $product) { ?>
    <div class="like-button">
        <label class="material-symbols-outlined">
            <input type="checkbox">
            favorite_border
        </label>
    </div>
<?php } ?>

<?php function drawProductCard(string $product) { ?>  <!-- TODO: Use real database product -->
    <div class="product-card">
        <img src="https://picsum.photos/seed/<?=$product?>/200/300" alt="<?=$product?>">
        <h1><?=$product?></h1>
        <p>$55.49</p>
        <?php drawLikeButton($product); ?>
    </div>
<?php } ?>
