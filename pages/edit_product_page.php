<?php
declare(strict_types = 1);

require_once __DIR__ . '/../template/main_header.tpl.php';
require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../pages/404_page.php';
require_once __DIR__ . '/../framework/Controller.php';
?>

<?php function drawEditProductPageContent(Request $request, int $productId) { 
    $db = new PDO("sqlite:" . DB_PATH);
    $product = Product::getProductByID($db, $productId);
    if (!isset($product)) {
        draw404PageContent();
        return;
    }

    if (!($request->session('user')['id'] == $product->getSeller()->getId() || $request->session('user')['type'] == 'admin')) {
        draw404PageContent();
        return;
    }
    ?>
    
    <main id="edit-product" data-product-id="<?= $productId ?>">
        <section>
            <form id="edit-product-form"></form>
            <h2>Edit product</h2>
            <div class="information-field">
                <h3>Product Name</h3>
                <input type="text" id="product-name" form="edit-product-form" name="title" value="<?= $product->getTitle() ?>" placeholder="Product Title" required>
            </div>
            <div class="information-field">
                <h3>Product Description</h3>
                <input type="text" id="product-description" form="edit-product-form" name="description" 
                value="<?= $product->getDescription() ?>" placeholder="Product Description" required>
            </div>
            <div class="information-field">
                <h3>Target Price</h3>
                <input type="text" id="target-price" form="edit-product-form" name="price" 
                value="<?= $product->getPrice() ?>" placeholder="Target Price" required>
            </div>

            <div class="information-field">
                <h3>Add Product Images</h3>
                <input type="file" id="edit-product-image-input" form="edit-product-form" name="image" multiple>

                <input type="submit" id="clear-edit-product-images" value="Clear">
            </div>

            <div class="information-field">
                <h3>Brand</h3>
                <select id="brand-select" form="edit-product-form" name="brands" multiple>
                    <option value="">Select a Brand</option>
                    <?php
                        $brands = Brand::getAll($db);
                        $productBrands = $product->getBrands($db);
                        foreach ($brands as $brand) { ?>
                            <option value="<?= $brand->getName() ?>" <?php if (in_array($brand, $productBrands)) echo 'selected' ?> >
                                <?= $brand->getName() ?>
                            </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Category</h3>
                <select id="category-select" form="edit-product-form" name="category">
                    <option value="">Select a Category</option>
                    <?php
                    $categories = Category::getAll($db);
                    foreach ($categories as $category) { ?>
                        <option value="<?= $category->getName() ?>" <?php if ($product->getCategory()?->getName() == $category->getName()) echo 'selected' ?> >
                            <?= $category->getName() ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Condition</h3>
                <select id="condition-select" form="edit-product-form" name="condition">
                    <option value="">Select a Condition</option>
                    <?php
                    $conditions = Condition::getAll($db);
                    foreach ($conditions as $condition) { ?>
                        <option value="<?= $condition->getName() ?>" <?php if ($product->getCondition()?->getName() == $condition->getName()) echo 'selected' ?> >
                            <?= $condition->getName() ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="information-field">
                <h3>Size</h3>
                <select id="size-select" form="edit-product-form" name="size">
                    <option value="">Select a Size</option>
                    <?php
                    $sizes = Size::getAll($db);
                    foreach ($sizes as $size) { ?>
                        <option value="<?= $size->getName() ?>" <?php if ($product->getSize()?->getName() == $size->getName()) echo 'selected' ?> >
                            <?= $size->getName() ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <input type="button" id="send-edit-product-button" form="edit-product-form" value="Publish">
            <input type="button" id="delete-product-button" form="edit-product-form" value="Delete">
        </section>
    </main>
<?php } ?>

<?php function drawEditProductPage(Request $request, int $productId)
{
    createPage(function () use ($request, $productId) {
        drawMainHeader($request);
        drawEditProductPageContent($request, $productId);
        drawFooter();
    }, $request);
} ?>
