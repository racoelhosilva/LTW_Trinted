<?php
declare(strict_types=1);

include_once('db/classes/Post.class.php');
?>

<?php function drawOrderItems(array $posts) { ?>
    <section id="order-items">
        <h1>Order</h1>
        <?php foreach ($posts as $post) { ?>
            <?php drawOrderItemCard($post); ?>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawOrderItemCard(Post $post) { ?>
    <?php $db = new PDO("sqlite:" . DB_PATH); ?>
    <div class="order-item-card" data-post-id="<?= $post->id ?>">
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
        <div>
            <div>
                <h1>Subtotal</h1>
                <p id="checkout-subtotal" class="price">0.00</p>
            </div>
            <div>
                <h1>Shipping</h1>
                <p id="checkout-shipping">-</p>
            </div>
            <div>
                <h1>Total</h1>
                <p id="checkout-total">-</p>
            </div>
            <button id="pay-now-button" class="submit-button">Pay now</button>
        </div>
    </section>
<?php } ?>

<?php function drawCheckoutForm() { ?>
    <section id="checkout-form">
        <h1>Shipping Information</h1>
        <form id="checkout-info-form" action="actions/action_pay.php" method="post">
            <input type="hidden" name="shipping" value="0.00">
            <div>
                <input type="text" name="first-name" aria-label="First Name" placeholder="First Name*" required>
                <input type="text" name="last-name" aria-label="Last Name" placeholder="Last Name*" required>
            </div>
            <div>
                <input type="email" name="email" aria-label="Email" placeholder="Email*" required>
                <input type="tel" name="phone" aria-label="Phone" placeholder="Phone Number*" required>
            </div>
            <div>
                <input type="text" name="address" aria-label="Address" placeholder="Address*" required>
                <input type="text" name="zip" pattern="[0-9]{4}-[0-9]{3}" aria-label="Zip-Code" placeholder="Zip-Code*" required>
            </div>
            <div>
                <input type="text" name="town" aria-label="Town" placeholder="Town*" required>
                <input type="text" name="country" aria-label="Country" placeholder="Country*" required>
            </div>
        </form>
    </section>
<?php } ?>

