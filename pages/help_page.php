<?php
declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/product_page.tpl.php';
?>

<?php function drawHelpPageContent(Request $request) { ?>
    <main id="help-page">
        <h1>Help Center</h1>

        <section>
            <h2>Frequently Asked Questions (FAQs)</h2>
            <dl>
                <dt>How do I register a new account?</dt>
                <dd>To register a new account, click on the "Register" button on the login page and fill out the required information.</dd>
                
                <dt>How do I list an item for sale?</dt>
                <dd>To list an item for sale, navigate to your account profile, click on "Add Item," and fill out the details of your item.</dd>
                
                <dt>How can I contact a seller?</dt>
                <dd>You can contact a seller by accessing their profile (for example, by clicking on the item you're interested in and then on the associated account) and using the provided contact or messaging feature.</dd>
                
            </dl>
        </section>

        <footer>
            <p>If you need further assistance, please contact our support team at support@trinted.com</p>
        </footer>
    </main> 
<?php } ?>

<?php
function drawHelpPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader($request);
        drawHelpPageContent($request);
        drawFooter();
    }, $request);
} ?>