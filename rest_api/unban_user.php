
<?php
session_start();

require_once __DIR__ . '/../db/classes/User.class.php';
require_once __DIR__ . '/../template/profile_page.tpl.php';

if ($_SESSION['user']['type'] != "admin") {
    die(json_encode(array('status' => 'error', 'message' => 'Access denied')));
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user']['id']);

if ($user->getType() == "admin") {
    die(json_encode(array('status' => 'error', 'message' => "Can't unban an admin user!")));
}

if (!$user->isBanned($db)) {
    die(json_encode(array('status' => 'error', 'message' => "User is not banned")));
}

$user->unban($db);
die(json_encode(array('status' => 'success', 'message' => "User unbanned successfully")));