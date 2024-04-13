<?php declare(strict_types=1); ?>

<?php function drawWelcomeBanner() { ?>
    <div id="welcome-banner">
        <h1>Welcome to Trinted!</h1>
        <p>Buy and sell <strong>trillions of pre-loved</strong> items!</p>
        <?php drawStartNowButton(); ?>
    </div>
<?php } ?>

<?php function drawStartNowButton() { ?>
    <button id="start-now-button">Start Now</button>
<?php } ?>