<?php declare(strict_types=1); ?>

<?php function drawStartNowButton() { ?>
    <button id="start-now-button">Start Now</button>
<?php } ?>

<?php function drawWelcomeBanner() { ?>
    <div id="welcome-banner">
        <div id="title-text">
            <h1>Welcome to</h1>
            <h1 class="title">TRINTED</h1>
        </div>
        <p>Buy and sell <strong>trillions of<br> pre-loved</strong> items!</p>
        <?php drawStartNowButton(); ?>
    </div>
<?php } ?>

<?php function drawProductSection() { ?>
    <div id="product-section">
        <h1>Explore new items</h1>
        <div id="product-section-cards">
            <?php
            for ($i = 0; $i < 10; $i++) {
                drawProductCard((string)$i);
            }
            ?>
        </div>
    </div>
<?php } ?>

