<?php
session_start();

require_once '../db/classes/User.class.php';

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $user = User::getUserByID($db, $_SESSION['user_id']);
} catch (Exception $e) {
    header("Location: /profile");
    exit();
}

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$newusername = validate($_POST['newusername']);
$newemail = validate($_POST['newemail']);
$newpassword = validate($_POST['newpassword']);
$currentpassword = validate($_POST['currentpassword']);

if ($user->validatePassword($currentpassword)){
    if (!empty($newusername)) {
        try {
            $user->setName($db, $newusername);
        } catch (Exception $e) {
            header("Location: /profile");
            exit();
        }
    } 
    if (!empty($newemail)) {
        try {
            $user->setEmail($db, $newemail);
        } catch (Exception $e) {
            header("Location: /profile");
            exit();
        }
    } 
    if (!empty($newpassword)) {
        try {
            $user->setPassword($db, $newpassword);
        } catch (Exception $e) {
            header("Location: /profile");
            exit();
        }
    }
}

$_SESSION['user_id'] = $user->id;
$_SESSION['email'] = $user->email;
$_SESSION['name'] = $user->name;
header("Location: /actions/go_to_profile.php");
exit();