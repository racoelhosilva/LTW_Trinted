<?php

declare(strict_types=1); ?>

<?php function drawHeaderButton(string $icon)
{ ?>
    <button class="header-button" id="<?= $icon ?>">
        <label class="material-symbols-outlined"><?= $icon ?></label>
    </button>
<?php } ?>

<?php function drawHamburgerButton()
{ ?>
    <input type="checkbox" id="hamburger-button" checked>
    <label for="hamburger-button" class="material-symbols-outlined">menu</label>
<?php } ?>

<?php function drawActionButtons()
{ ?>
    <div id="action-buttons">
        <?php drawHeaderButton('settings'); ?>
        <?php drawHeaderButton('message'); ?>
        <?php drawHeaderButton('person'); ?>
        <?php drawHeaderButton('shopping_cart'); ?>
    </div>
<?php } ?>

<?php function drawHeaderLogo()
{ ?>
    <a href="/">
        <img src="/svg/logo_large.svg" alt="Trinted Logo" id="header-logo">
    </a>
<?php } ?>

<?php function drawSearchBar()
{ ?>
    <form id="search-bar" method="get" action="search">
        <input id="search-input" type="text" name="query" placeholder="Search items...">
        <input type="hidden" name="page" value="1">
        <button type="submit" id="search-button">
            <span class="material-symbols-outlined">search</span>
        </button>
    </form>
<?php } ?>