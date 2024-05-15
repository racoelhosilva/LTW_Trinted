<?php
session_start();

require_once '../db/classes/User.class.php';
require_once '../template/profile_page.tpl.php';

if ($_SESSION['type'] != "admin") {
    echo json_encode(array('error' => 'Access denied'));
    exit();
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user_id']);

if ($user->type == "admin") {
    echo json_encode(array('error' => "Can't unban an admin user!"));
    exit();
}

$user->unban($db);
echo json_encode(array('success' => "User unbanned successfully"));


exit();