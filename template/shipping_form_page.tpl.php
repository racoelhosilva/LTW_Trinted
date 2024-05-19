<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
?>

<?php function drawShippingForm(Product $initialPost) {
    $db = new PDO("sqlite:" . DB_PATH);
    $payment = $initialPost->getPayment();
    $seller = $initialPost->getSeller();
    $posts = $payment->getAssociatedProductsFromSeller($db, $seller->getId()); ?>

    <section id="form-buyer-info">
        <p id="name"><?= $payment->getLastName() . ', ' . $payment->getFirstName() ?></p>
        <p id="address"><?= $payment->getAddress() . ', ' . $payment->getZipCode() ?></p>
        <p id="location"><?= $payment->getTown() . ', ' . $payment->getCountry() ?></p>
    </section>

    <section id="form-product-info">
        <?php 
        $sum = 0;
        $count = 0;
        foreach ($posts as $post) { 
            $sum += $post->getPrice();
            $count += 1; ?>
            <div class="product-name-price">
                <p class="product-name"> <?= $post->getTitle() ?> </p>
                <p class="price product-price"> <?= $post->getPrice() ?> </p>
            </div>
            <p class="product-description"> <?= $post->getDescription() ?> </p>
        <?php } ?>
    </section>
    
    <section id="form-price-info">
        <p class="price" id="total-cost"> Total Cost: <?= $sum ?> </p>
        <p class="price" id="shipping-cost"> Shipping: <?= $payment->getShipping() ?> </p>
    </section>

    <section id="form-seller-info">
        <p id="sold-by">Sold by: <span><?= $seller->getName() ?></span> </p>
    </section>

<?php } ?>