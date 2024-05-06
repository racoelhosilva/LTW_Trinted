<?php
declare(strict_types=1);

include_once('db/classes/Post.class.php');
?>

<?php function drawOrderItems() { ?>
    <?php $db = new PDO("sqlite:" . DB_PATH); ?>
    <section id="order-items">
        <h1>Order</h1>
        <?php foreach (Post::getNPosts($db, 10) as $post) { ?>
            <?php drawOrderItemCard($post); ?>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawOrderItemCard(Post $post) { ?>
    <?php $db = new PDO("sqlite:" . DB_PATH); ?>
    <div class="order-item-card">
        <img src="<?= $post->getAllImages($db)[0]->url ?>" alt="Product Image">
        <div class="order-item-info">
            <h1><?= $post->title ?></h1>
            <p>$<?= $post->price ?></p>
        </div>
    </div>
<?php } ?>