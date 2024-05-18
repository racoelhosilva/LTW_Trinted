<?php
declare(strict_types=1);

require_once __DIR__ . '/product.tpl.php';
?>

<?php function drawProfileImage(string $url)
{ ?>
    <img src="<?= $url ?>" class="profile-image" alt="Profile Picture">
<?php } ?>

<?php function drawUserInfo(User $user)
{ ?>
    <div id="user-info">
        <h1><?= $user->getName() ?></h1>
        <?php
        $currentDate = new DateTime(date('Y-m-d', time()));
        $joinDate = new DateTime(date('Y-m-d', $user->getRegisterDatetime()));
        $timeDifference = $joinDate->diff($currentDate)->y;
        if ($timeDifference == 0) {
            ?>
            <h2>Joined less than a year ago</h2>
            <?php
        } elseif ($timeDifference == 1) {
            ?>
            <h2>Joined one year ago</h2>
            <?php
        } else {
            ?>
            <h2>Joined <?= $timeDifference ?> years ago</h2>
            <?php
        }
        ?>
    </div>
<?php } ?>

<?php function drawUserButtons(Request $request, User $user)
{ ?>
    <div id="user-buttons">
        <?php if (getSessionUser($request)['id'] == $user->getId()){ ?>
            <button class="blue-button" id="add-button">
                <label class="material-symbols-outlined">post_add</label>
            </button>
            <form method="post" action="/actions/action_logout.php">
                
        <?php } else { ?>

            <button class="blue-button" id="message-button" data-user-id="<?= $user->getId() ?>">
                <label class="material-symbols-outlined">message</label>
            </button>

            <?php
            if (getSessionUser($request)['type'] == 'admin' && $user->getType() != 'admin') {

                if (!$user->isBanned(new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db'))) { ?>
                    <button type="submit" class="blue-button" id="make-admin-button">Make Admin</button>
                    <button type="submit" class="blue-button" id="ban-button">Ban</button>
            <?php } else { ?>
                    <button type="submit" class="blue-button" id="unban-button">Unban</button>
            <?php } 
            }
        }

        if ($user->getType() == "admin") { ?>
            <!-- User is admin -->
            <button disabled class="blue-button" id="is-admin-button">User is <?php echo $user->getType() ?></button>
        <?php } ?>

    </div> <?php
}?>

<?php function drawUserProductSection(User $user, Request $request)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $products = $user->getUserProducts($db);
    drawProductSection($products, $request, "Products by the seller" . (count($products) != 0 ? " (" . count($products) . ")" : ""));
} ?>

<?php function drawWishlist(User $user, Request $request)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $wishlist = $user->getWishlist($db);
    drawProductSection($wishlist, $request, "Wishlist");
} ?>

<?php function drawSoldItems(User $user, Request $request)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $posts = $user->getSoldItems($db);
    drawProductSection($posts, $request, "Products sold" . (count($posts) != 0 ? " (" . count($posts) . ")" : ""));
} ?>
