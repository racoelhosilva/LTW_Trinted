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
        <div>
            <h1><?= $post->title ?></h1>
            <p><?= $post->item->size->size ?> - <?= $post->item->condition->condition ?></p>
        </div>
        <div>
            <p>$<?= $post->price ?></h1>
            <p class="num-items">2</p>
        </div>
    </div>
<?php } ?>

<?php function drawCheckoutSummary() { ?>
    <section id="checkout-summary">
        <h1>Summary</h1>
        <div id="checkout-total">
            <div>
                <h1>Subtotal</h1>
                <p>$100.00</p>
            </div>
            <div>
                <h1>Shipping</h1>
                <p>$10.00</p>
            </div>
            <div>
                <h1>Total</h1>
                <p>$110.00</p>
            </div>
            <button id="pay-now-button" class="submit-button">Pay now</button>
        </div>
    </section>
<?php } ?>

<?php function drawCheckoutForm() { ?>
    <section id="checkout-form">
        <h1>Shipping Information</h1>
        <form action="checkout.php" method="post">
            <input type="text" name="first-name" placeholder="First Name" required>
            <input type="text" name="last-name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="zip" placeholder="Zip-Code" required>
            <input type="text" name="town" placeholder="Town" required>
            <input type="text" name="country" placeholder="Country" required>
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </section>
<?php } ?>
