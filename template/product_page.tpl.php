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
        <h2>Published two weeks ago</h2>
        <h2>By <a href="profile">John Doe</a></h2>
        <h1><?= $product_id ?></h1>
        <p><strong>Size:</strong> L<p>
        <p><strong>Condition:</strong> Barely Used</p>
        <p><strong>Category:</strong> Clothing</p>
        <p><strong>Brand:</strong> Abibas</p>
        <br>

        <p><strong>Description</strong></p>
        <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam  facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat,  pharetra eu arcu id, elementum.</p>
    </div>
<?php } ?>
