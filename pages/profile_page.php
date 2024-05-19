<?php

declare(strict_types=1);

require_once __DIR__ . '/../template/common.tpl.php';
require_once __DIR__ . '/../template/profile_page.tpl.php';
require_once __DIR__ . '/404_page.php';
?>

<?php function drawProfilePageContent(Request $request, int $userId)
{ ?>
    <?php
    $db = new PDO("sqlite:" . DB_PATH);
    $user = User::getUserByID($db, $userId);
    if (!isset($user)) {
        draw404PageContent();
        return;
    }

    $profilePictureUrl = $user->getProfilePicture()->getUrl();
    ?>
    <main id="profile-page">
        <section id="profile-section">
            <?php drawProfileImage($profilePictureUrl) ?>
            <?php drawUserInfo($user); ?>
            <?php drawUserButtons($request, $user); ?>
        </section>
        <?php if (in_array($user->getType(), ['seller', 'admin']))
            drawUserProductSection($user, $request); ?>
        <?php if (getSessionUser($request)['id'] == $user->getId()) {
            drawWishlist($user, $request);
            drawSoldItems($user, $request);
        } ?>
    </main>
    <?php } ?>
    
    <?php
function drawProfilePage(Request $request, int $userId)
{
    createPage(function () use (&$request, $userId) {
        drawMainHeader();
        drawProfilePageContent($request, $userId);
        drawFooter();
    }, $request);
}
?>