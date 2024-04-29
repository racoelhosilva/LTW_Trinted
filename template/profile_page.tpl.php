<?php include_once('template/product.tpl.php'); ?>

<?php function drawProfileImage(String $url)
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
        ?> <h2>Joined less than a year ago</h2>
        <?php
        } elseif ($timeDifference == 1) {
        ?><h2>Joined one year ago</h2>
        <?php
        } else {
        ?> <h2>Joined <?= $timeDifference ?> years ago</h2>
        <?php
        }
        ?>

    </div>
<?php } ?>