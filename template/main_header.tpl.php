<?php declare(strict_types=1); ?>

<?php function drawHeaderButton(string $icon) { ?>
    <form id="profile-form" action="login"></form>
    <input type="submit" form="profile-form">
    <label class="material-symbols-outlined"><?= $icon ?></label>
<?php } ?>

<?php function drawHamburgerButton() { ?>
    <input type="checkbox" id="hamburger-button">
    <label for="hamburger-button" class="material-symbols-outlined">menu</label>
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
            <span class="material-symbols-outlined">search</span>
        </button>
    </form>
<?php } ?>