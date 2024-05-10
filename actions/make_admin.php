<?php
session_start();

require_once '../db/classes/User.class.php';

if ($_SESSION['type'] != "admin") {
    header("Location: /404");
    exit();
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

$user = User::getUserByID($db, $_POST['user_id']);

if ($user->type == "admin") {
    header("Location: /404");
    exit();
}

$user->setType($db, "admin");

header("Location: /actions/go_to_profile.php?id=" . $user->id);
exit();