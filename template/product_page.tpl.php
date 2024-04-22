<?php declare(strict_types=1); ?>

<?php function drawProductPhotos(string $product_id) { ?>
    <div id="product-photos">
        <span class="material-icons" id="prev-photo">navigate_before</span>
        <span class="material-icons" id="next-photo">navigate_next</span>
        <div id="photo-badges">
            <span class="material-icons photo-badge">directions_walk</span>
            <span class="material-icons photo-badge">directions_run</span>
        </div>
        <img src="https://picsum.photos/seed/<?=$product_id?>/200/300" alt="Product Photo">
    </div>
<?php } ?>

<?php function drawProductInfo(string $product_id) { ?>
    <div id="product-info">
        <h1><?= $product_id ?></h1>
    </div>
<?php } ?>
