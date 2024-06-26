<?php declare(strict_types=1); ?>

<?php function drawStartNowButton() { ?>
    <button id="start-now-button">Start Now</button>
<?php } ?>

<?php function drawWelcomeBanner() { ?>
    <section id="welcome-banner">
        <div>
            <div id="title-text">
                <h1>Welcome to</h1>
                <h1 class="title">TRINTED</h1>
            </div>
            <p>Buy and sell <strong>trillions of<br> pre-loved</strong> items!</p>
            <?php drawStartNowButton(); ?>
        </div>
    </section>
<?php } ?>

