<?php
session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$userID = validate($_GET['id']);

if (empty($userID)) {
    header("Location: /profile?id=" . $_SESSION['user_id']);
    exit();
} else {
    header("Location: /profile?id=" . $userID);
    exit();
}
