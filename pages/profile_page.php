<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/profile_page.tpl.php');
?>

<?php function drawProfilePageContent(User $user)
{ ?>
    <?php
    ?>
    <main id="profile-page">
        <section id="profile-section">
            <?php
            $db = new PDO("sqlite:" . DB_PATH);
            drawProfileImage($user->getProfilePicture($db)->url);
            ?>
            <?php drawUserInfo($user); ?>
            <?php drawUserButtons($user); ?>
        </section>
        <!-- TODO: Check if user is seller -->
        <?php if (in_array($user->type, ['seller', 'admin']))
            drawUserProductSection($user); ?>
        <?php if ($_SESSION['user_id'] == $user->id) {
            drawWishlist($user);
            drawSoldItems($user);
        } ?>
    </main>
    <?php } ?>
    
    <?php
function drawProfilePage(Request $request)
{
    createPage(function () {
        drawMainHeader();
        session_start();

        $db = new PDO("sqlite:" . DB_PATH);
        drawProfilePageContent(User::getUserByID($db, intval($_GET['id'])));
        drawFooter();
    });
}
?>