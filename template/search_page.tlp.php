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
        <?php for ($i = 1; $i <= $pages; $i++) { ?>
            <?php if ($i === $current) { ?>
                <a href="" onclick="return false;" class="active"><?= $i ?></a>
            <?php } else { ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php } ?>
        <?php } ?>
        <?php if ($current < $pages) { ?>
            <a href="?page=<?= $current + 1 ?>">&gt;</a>
        <?php } else { ?>
            <a class="blocked">&gt;</a>
        <?php } ?>
    </div>
<?php } ?>
