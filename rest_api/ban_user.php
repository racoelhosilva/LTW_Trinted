<?php
session_start();

require_once '../db/classes/User.class.php';
require_once '../template/profile_page.tpl.php';

if ($_SESSION['user']['type'] != "admin") {
    die(json_encode(array('status' => 'error', 'message' => 'Access denied')));
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user']['id']);

if ($user->getType() == "admin") {
    die(json_encode(array('status' => 'error', 'message' => "Can't ban an admin user!")));
}

if ($user->isBanned($db)) {
    die(json_encode(array('status' => 'error', 'message' => "User is already banned")));
}

$user->ban($db);

die(json_encode(array('status' => 'success', 'message' => "User banned successfully")));