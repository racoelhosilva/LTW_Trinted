<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
include_once('db/classes/Post.class.php');
include_once('db/classes/User.class.php');
include_once('db/classes/Message.class.php');
include_once('db/classes/Brand.class.php');
include_once('db/classes/Category.class.php');
include_once('db/classes/Condition.class.php');
include_once('db/classes/Size.class.php');
?>

<?php function drawDashboardPageContent() { 
    $db = new PDO("sqlite:" . DB_PATH);?>

    <main id="dashboard-page">
        <h1>Admin Dashboard</h1>

        <section id="dashboard-posts">
            <h2>Post Information</h2>
            Total Number of Posts: <?= Post::getNumberOfPosts($db) ?>
            Number of Active Posts: <?= Post::getNumberOfActivePosts($db) ?>
            Number of Closed Posts: <?= Post::getNumberOfClosedPosts($db) ?>
        </section>

        <section id="dashboard-details">
            <h2>Details Information</h2>

            Number of Brands: <?= Brand::getNumberOfBrands($db) ?>
            Number of Categories: <?= Category::getNumberOfCategories($db) ?>
            Number of Conditions: <?= Condition::getNumberOfConditions($db) ?>
            Number of Sizes: <?= Size::getNumberOfSizes($db) ?>            
        </section>

        <section id="dashboard-users">
            <h2>User Information</h2>
            Total Number of User: <?= User::getNumberOfUsers($db) ?>
            Number of Active Users: <?= User::getNumberOfActiveUsers($db) ?>
            Number of Banned Users: <?= User::getNumberOfBannedUsers($db) ?>
            Number of Admins: <?= User::getNumberOfAdmins($db) ?>
            Number of Sellers: <?= User::getNumberOfSellers($db) ?>
            Number of Buyers: <?= User::getNumberOfBuyers($db) ?>
            
            Number of Messages: <?= Message::getNumberOfMessages($db) ?>
        </section>

    </main> 
<?php } ?>

<?php
function drawDashboardPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader();
        drawDashboardPageContent();
        drawFooter();
    });
} ?>