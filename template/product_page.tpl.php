<?php declare(strict_types=1); ?>

<?php function drawProductPhotos(string $product_id) { ?>
    <div id="product-photos">
        <span class="material-icons" id="prev-photo">navigate_before</span>
        <span class="material-icons" id="next-photo">navigate_next</span>
        <img src="https://picsum.photos/seed/<?=$product_id?>/200/300" alt="Product Photo">
    </div>
<?php } ?>