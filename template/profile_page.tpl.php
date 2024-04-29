<?php include_once('template/product.tpl.php'); ?>

<?php function drawProfileImage(String $url) { ?>
    <img src="https://picsum.photos/seed/<?=$url?>/200/300" class="profile-image" alt="Profile Picture">
<?php } ?>

<?php function drawUserInfo() { ?>
    <div id="user-info">
        <h1>John Doe</h1>
        <h2>Joined 4 years ago</h2>
    </div>
<?php } ?>
