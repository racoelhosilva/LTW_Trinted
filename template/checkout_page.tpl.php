<?php
declare(strict_types=1);

include_once('db/classes/Product.class.php');
?>

<?php function drawOrderItems(array $products) { ?>
    <section id="order-items">
        <h1>Order</h1>
        <?php foreach ($products as $product) { ?>
            <?php drawOrderItemCard($product); ?>
        <?php } ?>
    </section>
<?php } ?>

<?php function drawOrderItemCard(Product $product) { ?>
    <?php $db = new PDO("sqlite:" . DB_PATH); ?>
    <div class="order-item-card" data-product-id="<?= $product->getId() ?>">
        <img src="<?= $product->getAllImages($db)[0]->url ?>" alt="Product Image">
        <div>
            <h1><?= $product->getTitle() ?></h1>
            <p><?= $product->getSize()->getName() ?> - <?= $product->getCondition()->getName() ?></p>
        </div>
        <div>
            <p>$<?= $product->getPrice() ?></h1>
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

<?php function drawCheckoutForm(string $csrfToken) { ?>
    <section id="checkout-form">
        <h1>Shipping Information</h1>
        <form id="checkout-info-form" action="actions/action_pay.php" method="post">
            <input type="hidden" name="shipping" value="0.00">
            <input type="hidden" name="csrf" value="<?= $csrfToken ?>">
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

