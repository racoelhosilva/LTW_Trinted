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
        <p><?= $payment->lastName . ', ' . $payment->firstName ?></p>
        <p><?= $payment->address . ', ' . $payment->zipCode ?></p>
        <p><?= $payment->town . ', ' . $payment->country ?></p>
    </section>

    <section id="form-product-info">
        <?php 
        $sum = 0;
        $count = 0;
        foreach ($posts as $post) { 
            $sum += $post->price;
            $count += 1; ?>
            <p> <?= $post->title ?> </p>
            <p class="price"> <?= $post->price ?> </p>
            <p> <?= $post->description ?> </p>
        <?php } ?>

        <p class="price"> Total Cost: <?= $sum ?> </p>
        <p class="price"> Shipping: <?= $payment->shipping ?> </p>
    </section>

    <section id="form-product-info">
        <p>Sold by: <?= $seller->name ?> </p>
    </section>

<?php
}
