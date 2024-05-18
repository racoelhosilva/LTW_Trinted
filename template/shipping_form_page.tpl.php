<?php
declare(strict_types=1);

include_once('db/classes/Payment.class.php');
include_once('template/common.tpl.php');
include_once('db/classes/Post.class.php');
?>

<?php function drawShippingForm(Post $initialPost) {
    $db = new PDO("sqlite:" . DB_PATH);
    $payment = $initialPost->payment;
    $seller = $initialPost->seller;
    $posts = $payment->getAssociatedPostsFromSeller($db, $seller->id); ?>

    <section id="form-buyer-info">
        <p id="name"><?= $payment->lastName . ', ' . $payment->firstName ?></p>
        <p id="address"><?= $payment->address . ', ' . $payment->zipCode ?></p>
        <p id="location"><?= $payment->town . ', ' . $payment->country ?></p>
    </section>

    <section id="form-product-info">
        <?php 
        $sum = 0;
        $count = 0;
        foreach ($posts as $post) { 
            $sum += $post->price;
            $count += 1; ?>
            <div class="product-name-price">
                <p class="product-name"> <?= $post->title ?> </p>
                <p class="price product-price"> <?= $post->price ?> </p>
            </div>
            <p class="product-description"> <?= $post->description ?> </p>
        <?php } ?>
    </section>
    
    <section id="form-price-info">
        <p class="price" id="total-cost"> Total Cost: <?= $sum ?> </p>
        <p class="price" id="shipping-cost"> Shipping: <?= $payment->shipping ?> </p>
    </section>

    <section id="form-seller-info">
        <p id="sold-by">Sold by: <span><?= $seller->name ?></span> </p>
    </section>

<?php } ?>