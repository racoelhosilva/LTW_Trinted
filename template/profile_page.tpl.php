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

<?php function drawUserButtons(User $user)
{ ?>
    <div id="user-buttons">
        <?php if ($_SESSION['user']['id'] == $user->getId()){ ?>
            <form method="post" action="/actions/logout.php">
                <button type="submit" class="red-button" id="logout-button">Logout</button>
            </form>
        <?php } else { ?>

            <button class="blue-button" id="message-button" data-user-id="<?= $user->getId() ?>">
                <label class="material-symbols-outlined">message</label>
            </button>

            <?php
            if ($_SESSION['user']['type'] == 'admin' && $user->getType() != 'admin') {

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

<?php function drawUserProductSection(User $user)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $products = $user->getUserProducts($db);
    drawProductSection($products, "Products by the seller" . (count($products) != 0 ? " (" . count($products) . ")" : ""));
} ?>

<?php function drawWishlist(User $user)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $wishlist = $user->getWishlist($db);
    drawProductSection($wishlist, "Wishlist");
} ?>

<?php function drawSoldItems(User $user)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $posts = $user->getSoldItems($db);
    drawProductSection($posts, "Products sold" . (count($posts) != 0 ? " (" . count($posts) . ")" : ""));
} ?>
