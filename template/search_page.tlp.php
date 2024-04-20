<?php
declare(strict_types=1);

include_once('template/product.tlp.php');
?>

<?php function drawProducts() { ?>
    <div id="searched-products">
        <?php
        for ($i = 0; $i < 10; $i++) {
            drawProductCard((string)$i);
        }
        ?>
    </div>
<?php } ?>