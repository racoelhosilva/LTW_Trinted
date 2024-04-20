<?php
declare(strict_types=1);

include_once('template/product.tlp.php');
?>

<?php function drawProducts(array $products) { ?>
    <div id="searched-products">
        <?php
        foreach ($products as $product) {
            drawProductCard((string)$product);
        }
        ?>
    </div>
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
