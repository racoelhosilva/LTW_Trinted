<?php declare(strict_types=1); ?>

<?php function drawHeaderButton(string $icon) { ?>
    <button type="submit" formmethod="get" formaction="pages/login_page.php">
        <span class="material-icons md-36"><?= $icon ?></span>
    </button>
<?php } ?>

<?php
function drawHamburgerButton() {
    drawHeaderButton('menu');
}
?>

<?php function drawActionButtons() { ?>
    <div id="action-buttons">
        <?php drawHeaderButton('person'); ?>
        <?php drawHeaderButton('shopping_cart'); ?>
    </div>
<?php } ?>

<?php function drawHeaderLogo() { ?>
    <a href="/">
        <img src="svg/logo_large.svg" alt="Trinted Logo" id="header-logo">
    </a>
<?php } ?>

<?php function drawSearchBar() { ?>
    <form id="search-bar">
        <input type="text" placeholder="Search items...">
        <button type="submit" id="search-button">
            <span class="material-icons">search</span>
        </button>
    </form>
<?php } ?>