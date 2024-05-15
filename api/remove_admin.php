<?php
session_start();

require_once '../db/classes/User.class.php';

if ($_SESSION['type'] != "admin") {
    echo json_encode(array('status' => 'error', 'message' => 'Access denied'));
    exit();
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user_id']);

if ($user->type != "admin") {
    echo json_encode(array('status' => 'error', 'message' => "User is not admin"));

    exit();
}

$user->setType($db, "seller");

echo json_encode(array('status' => 'success', 'message' => "User is no longer an admin"));
exit();