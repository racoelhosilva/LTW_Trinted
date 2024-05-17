<?php
session_start();

require_once '../db/classes/User.class.php';

if ($_SESSION['user']['type'] != "admin") {
    die(json_encode(array('status' => 'error', 'message' => 'Access denied')));
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user']['id']);

if ($user->type != "admin") {
    die(json_encode(array('status' => 'error', 'message' => "User is not admin")));
}

$user->setType($db, "seller");

die(json_encode(array('status' => 'success', 'message' => "User is no longer an admin")));