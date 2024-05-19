<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/main_header.tpl.php';
require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../pages/404_page.php';
require_once __DIR__ . '/../framework/Controller.php';
?>

<?php function drawEditProductPageContent(Request $request) { 
    $db = new PDO("sqlite:" . DB_PATH);
    $product = Product::getProductByID($db, intval($request->get('id')));
    if (!isset($post)) {
        draw404PageContent();
        return;
    }

    if ($request->session('user_id') != $product->getSeller()->getId() && $request->session('user')['type'] != 'admin') {
        draw404PageContent();
        return;
    }
    ?>
    
    <main id="edit-product">
        <section>
            <h2>Edit product</h2>
            <div class="information-field">
                <h3>Product Name</h3>
                <input type="text" id="product-name" name="product-name" value="<?= $product->getTitle() ?>" placeholder="Product Name" required>
            </div>
            <div class="information-field">
                <h3>Product Description</h3>
                <input type="text" id="product-description" name="product-description" 
                value="<?= $post->getDescription() ?>" placeholder="Product Description" required>
            </div>
            <div class="information-field">
                <h3>Target Price</h3>
                <input type="text" id="target-price" name="target-price" 
                value="<?= $post->getPrice() ?>" placeholder="Target Price" required>
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
                            <option value="<?= $brand->getName() ?>"><?= $brand->getName() ?></option>
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
                        <option value="<?= $category->getCategory() ?>"> <?= $category->getCategory() ?> </option>
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
                        <option value="<?= $condition->getCondition() ?>"> <?= $condition->getCondition() ?> </option>
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
                        <option value="<?= $size->getSize() ?>"> <?= $size->getSize() ?> </option>
                    <?php } ?>
                </select>
            </div>

            <input type="button" id="publish-button" value="Publish">
            <input type="button" id="delete-button" value="Delete">
        </section>
    </main>
<?php } ?>

<?php function drawEditProductPage(Request $request)
{
    createPage(function () use (&$request) {
        drawMainHeader($request);
        drawEditProductPageContent($request);
        drawFooter();
    }, $request);
} ?>
