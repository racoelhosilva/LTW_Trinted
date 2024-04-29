<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/profile_page.tpl.php');
?>

<?php function drawProfilePageContent() { ?>
    <?php $num_products = 10 ?>
    <main id="profile-page">
        <section id="profile-section">
            <?php drawProfileImage("") ?>
            <?php drawUserInfo() ?>
        </section>
        <!-- TODO: Check if user is seller -->
        <?php drawProductSection("Products by the seller ($num_products)") ?>
    </main>
<?php } ?>

<?php
function drawProfilePage(Request $request) {
    createPage(function () {
        drawMainHeader();
        drawProfilePageContent();
        drawFooter();
    });
}
?>