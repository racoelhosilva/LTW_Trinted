<?php declare(strict_types=1); ?>

<?php function drawStartNowButton() { ?>
    <button id="start-now-button">Start Now</button>
<?php } ?>

<?php function drawWelcomeBanner() { ?>
    <div id="welcome-banner">
        <h1>Welcome to Trinted!</h1>
        <p>Buy and sell <strong>trillions of pre-loved</strong> items!</p>
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

