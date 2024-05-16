<?php
session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (!isset($_GET['id'])) {
    header("Location: /profile/" . $_SESSION['user_id']);
    exit();
}

$userID = validate($_GET['id']);

if (empty($userID)) {
    header("Location: /profile/" . $_SESSION['user_id']);
    exit();
} else {
    header("Location: /profile/" . $userID);
    exit();
}
