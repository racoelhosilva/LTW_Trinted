<?php
declare(strict_types = 1);

include_once('template/main_header.tpl.php');
include_once('template/common.tpl.php');
?>

<?php function drawNewProductPageContent() { ?>
    <main id="new-product">
        <section id="account-settings">
            <h2>Add new product</h2>
            <div class="information-field">
                <h3>Product Name</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>
            <div class="information-field">
                <h3>Product Description</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>
            <div class="information-field">
                <h3>Target Price</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>

            <div class="information-field">
                <h3>Add Product Images</h3>
                <input type="file" id="image-input" name="image">

                <input type="submit" id="clear-profile-picture" value="Clear">
            </div>

            <div class="information-field">
                <h3>Brand</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>
            <div class="information-field">
                <h3>Category</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>
            <div class="information-field">
                <h3>Condition</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
            </div>
            <div class="information-field">
                <h3>Size</h3>
                <input type="text" id="new-username" name="newusername" placeholder="New Username">
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
