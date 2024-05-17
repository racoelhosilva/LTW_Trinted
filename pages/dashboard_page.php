<?php
declare(strict_types=1);

include_once('template/common.tpl.php');
?>

<?php function drawDashboardPageContent() { ?>
    <main id="dashboard-page">
        <h1>Admin Dashboard</h1>
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