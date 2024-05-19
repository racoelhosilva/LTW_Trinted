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
            <div class="dashboard-row">
                <div class="stat-card">
                    <h3><?= Product::getNumberOfProducts($db) ?></h3>
                    <p>Total Posts</p> 
                </div>
                <div class="stat-card">
                    <h3><?= Product::getNumberOfActiveProducts($db) ?></h3>
                    <p>Active Posts</p>
                </div>
                
                <div class="stat-card">
                    <h3><?= Product::getNumberOfClosedProducts($db) ?></h3>
                    <p>Closed Posts</p>
                </div>
            </div>
        </section>

        <section id="dashboard-details">
            <h2>Details Information</h2>
            
            <div class="listable-detail-section">

                <div class="detailed-card">
                        <?php $brands = Brand::getAll($db); ?>
                        <h3>
                        Brands <span class="detail-count"><?= sizeof($brands) ?></span>
                    </h3>
                    <ul>
                    <?php
                    foreach ($brands as $brand) { ?>
                        <li> <?= $brand->getName() ?> </li>
                        <?php } ?>
                    </ul>
                    <div id="writing-space">
                        <input type="text" class="new-detail" id="new brand" name="newbrand" placeholder="Write here...">
                        <input type="button" class="sendbutton" value="Add">
                    </div>
                </div>
                <div class="detailed-card">
                    <?php $categories = Category::getAll($db); ?>
                    <h3>
                        Categories <span class="detail-count"><?= sizeof($categories) ?></span>
                    </h3>
                    <ul>
                        <?php
                    foreach ($categories as $category) { ?>
                        <li> <?= $category->getName() ?> </li>
                    <?php } ?>
                    </ul>
                    <div id="writing-space">
                        <input type="text" class="new-detail" id="newcategory" name="newcategory" placeholder="Write here...">
                        <input type="button" class="sendbutton" value="Add">
                    </div>
                </div>
                <div class="detailed-card">
                    <?php $conditions = Condition::getAll($db); ?>
                    <h3>
                        Conditions <span class="detail-count"><?= sizeof($conditions) ?></span>
                    </h3>
                    <ul>
                        <?php
                    foreach ($conditions as $condition) { ?>
                        <li> <?= $condition->getName() ?> </li>
                        <?php } ?>
                    </ul>
                    <div id="writing-space">
                        <input type="text" class="new-detail" id="newcondition" name="newcondition" placeholder="Write here...">
                        <input type="button" class="sendbutton" value="Add">
                    </div>
                </div>
                <div class="detailed-card">
                    <?php $sizes = Size::getAll($db); ?>
                    <h3>
                        Sizes <span class="detail-count"><?= sizeof($sizes) ?></span>
                    </h3>
                    <ul>
                        <?php
                    foreach ($sizes as $size) { ?>
                        <li> <?= $size->getName() ?> </li>
                        <?php } ?>
                    </ul>
                    <div id="writing-space">
                        <input type="text" class="new-detail" id="newsize" name="newsize" placeholder="Write here...">
                        <input type="button" class="sendbutton" value="Add">
                    </div>
                </div>        
            </div>
        </section>

        <section id="dashboard-users">
            <h2>User Information</h2>

            <div class="dashboard-row">
                <div class="stat-card">
                    <h3><?= User::getNumberOfUsers($db) ?></h3>
                    <p>Total Users</p>
                </div>
                
                <div class="stat-card">
                    <h3><?= User::getNumberOfActiveUsers($db) ?></h3>
                    <p>Active Users</p>
                </div>

                <div class="stat-card">
                    <h3><?= User::getNumberOfBannedUsers($db) ?></h3>
                    <p>Banned Users</p>
                </div>
            </div>
            <div class="dashboard-row">
                <div class="stat-card">
                    <h3><?= User::getNumberOfAdmins($db) ?></h3>
                    <p>Admins</p>
                </div>
                
                <div class="stat-card">
                    <h3><?= User::getNumberOfSellers($db) ?></h3>
                    <p>Sellers</p>
                </div>
                
                <div class="stat-card">
                    <h3><?= User::getNumberOfBuyers($db) ?></h3>
                    <p>Buyers</p>
                </div>
                
                <div class="stat-card">
                    <h3><?= Message::getNumberOfMessages($db) ?></h3>
                    <p>Messages</p>
                </div>
            </div>
            
        </section>

    </main> 
<?php } ?>

<?php
function drawDashboardPage(Request $request) {
    createPage(function () use (&$request) {
        drawMainHeader();
        drawDashboardPageContent();
        drawFooter();
    }, $request);
} ?>