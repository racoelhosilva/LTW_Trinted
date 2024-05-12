<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/product.tpl.php');
?>

<?php function drawSearchedProducts(array $posts, int $page) {
    drawProductSection([], "No results found");
} ?>

<?php function drawPagination(int $pages, int $current) { ?>
    <?php if ($pages == 0) return; ?>
    <div id="pagination">
        <?php if ($current > 1) { ?>
            <a href="?page=<?= $current - 1 ?>">&lt;</a>
        <?php } else { ?>
            <a class="blocked">&lt;</a>
        <?php } ?>
        <?php if ($current == 1) { ?>
            <a href="" onclick="return false;" class="active">1</a>  <!-- TODO: Remove onclick -->
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
        <?php if ($pages > 1 && $current == $pages) { ?>
            <a href="" onclick="return false;" class="active"><?= $pages ?></a>
        <?php } else if ($pages > 1) { ?>
            <a href="?page=<?= $pages ?>"><?=$pages ?></a>
        <?php } ?>
        <?php if ($current < $pages) { ?>
            <a href="?page=<?= $current + 1 ?>">&gt;</a>
        <?php } else { ?>
            <a class="blocked">&gt;</a>
        <?php } ?>
    </div>
<?php } ?>

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
                drawSearchFilter($category->category, 'category');
            } ?>
        </ul>
        <h1>Condition</h1>
        <ul>
            <?php foreach ($conditions as $condition) {
                drawSearchFilter($condition->condition, 'condition');
            } ?>
        </ul>
        <h1>Size</h1>
        <ul>
            <?php foreach ($sizes as $size) {
                drawSearchFilter($size->size, 'size');
            } ?>
        </ul>
    </section>
<?php } ?>
