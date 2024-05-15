<?php
session_start();

require_once '../db/classes/User.class.php';
require_once '../template/profile_page.tpl.php';

if ($_SESSION['type'] != "admin") {
    echo json_encode(array('status' => 'error', 'message' => 'Access denied'));
    exit();
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user_id']);

if ($user->type == "admin") {
    echo json_encode(array('status' => 'error', 'message' => "Can't unban an admin user!"));
    exit();
}

if (!$user->isBanned($db)) {
    echo json_encode(array('status' => 'error', 'message' => "User is not banned"));
    exit();
}

$user->unban($db);
echo json_encode(array('status' => 'success', 'message' => "User unbanned successfully"));


exit();