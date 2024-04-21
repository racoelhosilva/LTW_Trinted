<?php declare(strict_types=1); ?>

<?php function drawHeaderButton(string $icon) { ?>
    <form id="profile-form" action="login"></form>
    <button type="submit" form="profile-form">
        <span class="material-icons md-36"><?= $icon ?></span>
    </button>
<?php } ?>

<?php function drawHamburgerButton() { ?>
    <input type="checkbox" id="hamburger-button">
    <label for="hamburger-button" class="material-icons md-36">menu</label>
<?php } ?>

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
    <form id="search-bar" method="get" action="search">
        <input type="text" placeholder="Search items...">
        <input type="hidden" name="page" value="1">
        <button type="submit" id="search-button">
            <span class="material-icons">search</span>
        </button>
    </form>
<?php } ?>