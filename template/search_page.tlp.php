<?php
declare(strict_types=1);

include_once('template/product.tlp.php');
?>

<?php function drawProducts(array $products) { ?>
    <section id="searched-products">
        <?php
        foreach ($products as $product) {
            drawProductCard((string)$product);
        }
        ?>
    </section>
<?php } ?>

<?php function drawPagination(int $pages, int $current) { ?>
    <div id="pagination">
        <?php if ($current > 1) { ?>
            <a href="?page=<?= $current - 1 ?>">&lt;</a>
        <?php } else { ?>
            <a class="blocked">&lt;</a>
        <?php } ?>
        <?php if ($current == 1) { ?>
            <a href="" onclick="return false;" class="active">1</a>
        <?php } else { ?>
            <a href="?page=1">1</a>
        <?php } ?>
        <?php if ($current > 3) { ?>
            <a class="ellipsis">...</a>
        <?php } ?>
        <?php for ($i = max(2, $current - 1); $i <= min($pages - 1, $current + 1); $i++) { ?>
            <?php if ($i == $current) { ?>
                <a href="" onclick="return false;" class="active"><?= $i ?></a>
            <?php } else { ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php } ?>
        <?php } ?>
        <?php if ($current < $pages - 2) { ?>
            <a class="ellipsis">...</a>
        <?php } ?>
        <?php if ($current == $pages) { ?>
            <a href="" onclick="return false;" class="active"><?= $pages ?></a>
        <?php } else { ?>
            <a href="?page=<?= $pages ?>"><?=$pages ?></a>
        <?php } ?>
        <?php if ($current < $pages) { ?>
            <a href="?page=<?= $current + 1 ?>">&gt;</a>
        <?php } else { ?>
            <a class="blocked">&gt;</a>
        <?php } ?>
    </div>
<?php } ?>

<?php function drawSearchDrawer() { ?>
    <section id="search-drawer">
        <h1>Search</h1>
        <ul>
            <li><a href="#">Woman/Female</a></li>
            <li><a href="#">Man/Male</a></li>
            <li><a href="#">Child</a></li>
            <li><a href="#">Home</a></li>
            <li><a href="#">Entretainment</a></li>
            <li><a href="#">Pets</a></li>
        </ul>
        <h1>Condition</h1>
        <ul>
            <li><a href="#">New</a></li>
            <li><a href="#">Barely-Used</a></li>
            <li><a href="#">Used</a></li>
            <li><a href="#">Damaged</a></li>
        </ul>
        <h1>Size</h1>
        <ul>
            <li><a href="#">S</a></li>
            <li><a href="#">M</a></li>
            <li><a href="#">L</a></li>
            <li><a href="#">XL</a></li>
        </ul>
    </section>
<?php } ?>
