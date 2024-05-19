<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/main_header.tpl.php';
require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../db/classes/Brand.class.php';
require_once __DIR__ . '/../db/classes/Category.class.php';
require_once __DIR__ . '/../db/classes/Condition.class.php';
require_once __DIR__ . '/../db/classes/Size.class.php';
?>

<?php function drawNewProductPageContent() { 
    $db = new PDO("sqlite:" . DB_PATH);
    ?>
    
    <main id="new-product">
        <section id="add-product">
            <form id="add-product-form"></form>
            <h2>Add new product</h2>
            <div class="information-field">
                <h3>Product Name</h3>
                <input type="text" id="product-name" form="add-product-form" name="title" placeholder="Product Title" required>
            </div>
            <div class="information-field">
                <h3>Product Description</h3>
                <input type="text" id="product-description" form="add-product-form" name="description" placeholder="Product Description" required>
            </div>
            <div class="information-field">
                <h3>Target Price</h3>
                <input type="text" id="target-price" form="add-product-form" name="price" placeholder="Target Price" required>
            </div>

            <div class="information-field">
                <h3>Add Product Images</h3>
                <input type="file" id="product-image-input" form="add-product-form" name="image" multiple required>

                <input type="submit" id="clear-product-picture" form="add-product-form" value="Clear">
            </div>

            <div class="information-field">
                <h3>Brand</h3>
                <select id="brand-select" form="add-product-form" name="brands" multiple>
                    <option value="">Select a Brand</option>
                    <?php
                        $brands = Brand::getAll($db);
                        foreach ($brands as $brand) { ?>
                            <option value="<?= $brand->getName() ?>"><?= $brand->getName() ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Category</h3>
                <select id="category-select" form="add-product-form" name="category">
                    <option value="">Select a Category</option>
                    <?php
                    $categories = Category::getAll($db);
                    foreach ($categories as $category) { ?>
                        <option value="<?= $category->getName() ?>"> <?= $category->getName() ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Condition</h3>
                <select id="condition-select" form="add-product-form" name="condition">
                    <option value="">Select a Condition</option>
                    <?php
                    $conditions = Condition::getAll($db);
                    foreach ($conditions as $condition) { ?>
                        <option value="<?= $condition->getName() ?>"> <?= $condition->getName() ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Size</h3>
                <select id="size-select" form="add-product-form" name="size">
                    <option value="">Select a Size</option>
                    <?php
                    $sizes = Size::getAll($db);
                    foreach ($sizes as $size) { ?>
                        <option value="<?= $size->getName() ?>"> <?= $size->getName() ?> </option>
                    <?php } ?>
                </select>
            </div>

            <input type="button" id="add-product-button" form="add-product-form" value="Publish">
        </section>
    </main>
<?php } ?>

<?php function drawNewProductPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader($request);
        drawNewProductPageContent();
        drawFooter();
    }, $request);
} ?>
