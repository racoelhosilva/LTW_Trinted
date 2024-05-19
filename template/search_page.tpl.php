<?php
declare(strict_types=1);

require_once __DIR__ . '/common.tpl.php';
require_once __DIR__ . '/product.tpl.php';
?>

<?php function drawSearchedProducts(array $products, int $page) {
    drawProductSection([], "No results found");
} ?>

<?php function drawSearchFilter(string $text, string $type) { ?>
    <li class="search-filter" data-type="<?= $type ?>" data-value="<?= $text ?>">
        <label>
            <?= $text ?>
            <input type="checkbox">
        </label>
    </li>
<?php } ?>

<?php function drawSearchDrawer() { ?>
    <?php
    $db = new PDO('sqlite:' . DB_PATH);
    $categories = Category::getAll($db);
    $conditions = Condition::getAll($db);
    $sizes = Size::getAll($db);
    ?>
    <section id="search-drawer">
        <h1>Category</h1>
        <ul>
            <?php foreach ($categories as $category) {
                drawSearchFilter($category->getName(), 'category');
            } ?>
        </ul>
        <h1>Condition</h1>
        <ul>
            <?php foreach ($conditions as $condition) {
                drawSearchFilter($condition->getName(), 'condition');
            } ?>
        </ul>
        <h1>Size</h1>
        <ul>
            <?php foreach ($sizes as $size) {
                drawSearchFilter($size->getName(), 'size');
            } ?>
        </ul>
    </section>
<?php } ?>
