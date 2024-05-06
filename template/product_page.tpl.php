<?php declare(strict_types=1); ?>

<?php function drawProductPhotos(string $product_id) { ?>
    <div id="product-photos">
        <span class="material-symbols-outlined" id="prev-photo">navigate_before</span>
        <span class="material-symbols-outlined" id="next-photo">navigate_next</span>
        <div id="photo-badges">
            <?php for ($i = 0; $i < 10; $i++) { ?>
                <span class="material-symbols-outlined photo-badge">circle</span>
            <?php } ?>
        </div>
        <?php for ($i = 0; $i < 10; $i++) { ?>
            <img src="https://picsum.photos/seed/<?=$product_id + $i?>/200/300" alt="Product Photo">
        <?php } ?>
    </div>
<?php } ?>

<?php function drawProductInfo(string $product_id) { ?>
    <div id="product-info">
        <div>
            <h2>Published two weeks ago</h2>
            <h2>By <a href="profile">John Doe</a></h2>
        </div>
        <a href="profile"><img alt="Profile Picture" src="https://picsum.photos/seed/1/200/300" class="avatar"></a>
        <div class="details">
            <h1><?= $product_id ?></h1>
            <p class="price">$55.49</p>
            <p><strong>Size:</strong> L<p>
            <p><strong>Condition:</strong> Barely Used</p>
            <p><strong>Category:</strong> Clothing</p>
            <p><strong>Brand:</strong> Abibas</p>
            <br>

            <p><strong>Description</strong></p>
        </div>
        <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam  facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat,  pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam  facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat,  pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam  facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat,  pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam  facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat,  pharetra eu arcu id, elementum. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam  facilisis sem aliquam tellus dignissim rutrum. Morbi magna erat,  pharetra eu arcu id, elementum.</p>
        <button class="add-cart-button submit-button">Add to Cart</button>
    </div>
<?php } ?>
