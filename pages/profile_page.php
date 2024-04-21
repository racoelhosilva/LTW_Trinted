<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/profile_page.tpl.php');
?>

<?php function drawProfilePageContent() { ?>
    <main id="profile-page">
        <section id="profile-section">
            <?php drawProfileImage("") ?>
            <?php drawUserInfo() ?>
        </section>
    </div>
<?php } ?>

<?php
function drawProfilePage() {
    createPage(function () {
        drawMainHeader();
        drawProfilePageContent();
        drawFooter();
    });
}
?>

<?php drawProfilePage(); ?>