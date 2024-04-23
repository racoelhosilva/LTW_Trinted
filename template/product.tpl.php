<?php declare(strict_types = 1); ?>

<?php function drawLikeButton(string $product) { ?>
    <button type="checkbox">
        <span class="material-icons">favorite_border</span>
    </button>
<?php } ?>

<?php function drawProductCard(Item $product) { ?>  <!-- TODO: Use real database product -->
    <div class="product-card">
        <img src="https://picsum.photos/seed/<?=$product->name?>/200/300" alt="<?=$product->name?>">
        <h1><?=$product->name?></h1>
        <p>$55.49</p>
        <?php drawLikeButton($product->name); ?>
    </div>
<?php } ?>
