<?php
declare(strict_types = 1);

include_once('template/main_header.tpl.php');
include_once('template/common.tpl.php');
include_once('db/classes/Brand.class.php');
include_once('db/classes/Category.class.php');
include_once('db/classes/Condition.class.php');
include_once('db/classes/Size.class.php');
?>

<?php function drawNewProductPageContent() { 
    $db = new PDO("sqlite:" . DB_PATH);
    ?>
    
    <main id="new-product">
        <section id="add-product">
            <h2>Add new product</h2>
            <div class="information-field">
                <h3>Product Name</h3>
                <input type="text" id="product-name" name="product-name" placeholder="Product Name" required>
            </div>
            <div class="information-field">
                <h3>Product Description</h3>
                <input type="text" id="product-description" name="product-description" placeholder="Product Description" required>
            </div>
            <div class="information-field">
                <h3>Target Price</h3>
                <input type="text" id="target-price" name="target-price" placeholder="Target Price" required>
            </div>

            <div class="information-field">
                <h3>Add Product Images</h3>
                <input type="file" id="image-input" name="image" multiple required>

                <input type="submit" id="clear-profile-picture" value="Clear">
            </div>

            <div class="information-field">
                <h3>Brand</h3>
                <select id="brand-select" name="brand">
                    <option value="">Select a Brand</option>
                    <?php
                        $brands = Brand::getAll($db);
                        foreach ($brands as $brand) { ?>
                            <option value="<?= $brand->name ?>"><?= $brand->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Category</h3>
                <select id="category-select" name="category">
                    <option value="">Select a Category</option>
                    <?php
                    $categories = Category::getAll($db);
                    foreach ($categories as $category) { ?>
                        <option value="<?= $category->category ?>"> <?= $category->category ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Condition</h3>
                <select id="condition-select" name="condition">
                    <option value="">Select a Condition</option>
                    <?php
                    $conditions = Condition::getAll($db);
                    foreach ($conditions as $condition) { ?>
                        <option value="<?= $condition->condition ?>"> <?= $condition->condition ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Size</h3>
                <select id="size-select" name="size">
                    <option value="">Select a Size</option>
                    <?php
                    $sizes = Size::getAll($db);
                    foreach ($sizes as $size) { ?>
                        <option value="<?= $size->size ?>"> <?= $size->size ?> </option>
                    <?php } ?>
                </select>
            </div>

            <input type="button" id="settings-button" value="Publish">
        </section>
    </main>
<?php } ?>

<?php function drawNewProductPage(Request $request) {
    createPage(function () {
        drawMainHeader();
        drawNewProductPageContent();
        drawFooter();
    });
} ?>
