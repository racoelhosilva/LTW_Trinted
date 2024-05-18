<?php

declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('template/profile_page.tpl.php');
include_once('pages/404_page.php');
?>

<?php function drawProfilePageContent(int $userId)
{ ?>
    <?php
    $db = new PDO("sqlite:" . DB_PATH);
    $user = User::getUserByID($db, $userId);
    if (!isset($user)) {
        draw404PageContent();
        return;
    }

    $profilePictureUrl = $user->getProfilePicture()->url;
    ?>
    <main id="profile-page">
        <section id="profile-section">
            <?php drawProfileImage($profilePictureUrl) ?>
            <?php drawUserInfo($user); ?>
            <?php drawUserButtons($user); ?>
        </section>
        <!-- TODO: Check if user is seller -->
        <?php if (in_array($user->type, ['seller', 'admin']))
            drawUserProductSection($user); ?>
        <?php if ($_SESSION['user']['id'] == $user->getId()) {
            drawWishlist($user);
            drawSoldItems($user);
        } ?>
    </main>
    <?php } ?>
    
    <?php
function drawProfilePage(Request $request, int $userId)
{
    createPage(function () use ($userId) {
        drawMainHeader();
        drawProfilePageContent($userId);
        drawFooter();
    });
}
?>