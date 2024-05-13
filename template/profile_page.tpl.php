<?php include_once ('template/product.tpl.php'); ?>

<?php function drawProfileImage(string $url)
{ ?>
    <img src="<?= $url ?>" class="profile-image" alt="Profile Picture">
<?php } ?>

<?php function drawUserInfo(User $user)
{ ?>
    <div id="user-info">
        <h1><?= $user->name ?></h1>
        <?php
        $currentDate = new DateTime(date('Y-m-d', time()));
        $joinDate = new DateTime(date('Y-m-d', $user->registerDateTime));
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
        <?php
        if ($user->type == "admin") { ?>
            <!-- User is admin -->

            <button disabled id="is-admin-button">User is <?php echo $user->type ?></button>
        <?php }

        if ($_SESSION['user_id'] == $user->id) { ?>
            <!-- I'm on my profile -->

            <form method="post" action="/actions/logout.php">
                <button type="submit" id="logout-button">Logout</button>
            </form>

        <?php } else if ($_SESSION['type'] == "admin") { ?>
                <!-- I'm an admin on another profile -->
                <?php
                if ($user->type != "admin") { ?>
                    <?php
                    if (!$user->isBanned(new PDO("sqlite:" . DB_PATH))) { ?>
                        <form method="post" action="/actions/make_admin.php">
                            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                            <button type="submit" id="admin-button">Make Admin</button>
                        </form>
                        <form method="post" action="/actions/ban_user.php">
                            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                            <button type="submit" id="admin-button">Ban</button>
                        </form>

                <?php } else { ?>
                        <form method="post" action="/actions/unban_user.php">
                            <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">
                            <button type="submit" id="admin-button">Unban</button>
                        </form>
                <?php } ?>
                    <script>


                    <?php if (isset($_GET['unban_success']) && $_GET['unban_success'] == "true") { ?>

                            alert("User unbanned successfully!");
                    <?php }
                    if (isset($_GET['ban_success']) && $_GET['ban_success'] == "true") { ?>
                                alert("User banned successfully!");
                <?php } ?>                                        
                    </script>
                            <?php }
        }
        ?>
        </div> <?php
} ?>

<?php function drawUserProductSection(User $user)
{
    $db = new PDO("sqlite:" . DB_PATH);
    $posts = $user->getUserPosts($db);
    drawProductSection($posts, "Products by the seller (" . count($posts) . ")");
} ?>