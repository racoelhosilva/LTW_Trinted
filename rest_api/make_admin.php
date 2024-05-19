<?php
session_start();

require_once __DIR__ . '/../db/classes/User.class.php';

if ($_SESSION['user']['type'] != "admin") {
    die(json_encode(array('status' => 'error', 'message' => 'Access denied')));
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, (int)($_POST['user']['id']));

if ($user->getType() == "admin") {
    die(json_encode(array('status' => 'error', 'message' => "User is already admin")));
}

if ($user->isBanned($db)) {
    die(json_encode(array('status' => 'error', 'message' => "A banned user can't be made admin")));
}

$user->setType($db, "admin");

die(json_encode(array('status' => 'success', 'message' => "User has been made admin")));