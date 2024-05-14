<?php
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die(json_encode(['success' => false, 'known' => true, 'error' => 'Invalid request method']));


$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
try {
    $user = User::getUserByID($db, $_SESSION['user_id']);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'known' => true, 'error' => 'User not found']));
}

$newusername = validate($_POST['username']);
$newemail = validate($_POST['email']);
$newpassword = validate($_POST['new']);
$currentpassword = validate($_POST['old']);

if (!$user->validatePassword($currentpassword)){
    die(json_encode(['success' => false, 'known' => true, 'error' => 'Incorrect password']));
}

if (empty($newusername) && empty($newemail) && empty($newpassword)) {
    die(json_encode(['success' => false, 'known' => true, 'error' => 'No fields to change']));
}

if (!empty($newusername)) {
    try {
        $user->setName($db, $newusername);
    } catch (Exception $e) {
        die(json_encode(['success' => false, 'error' => $e->getMessage()]));
    }
} 
if (!empty($newemail)) {
    try {
        $user->setEmail($db, $newemail);
    } catch (Exception $e) {
        die(json_encode(['success' => false, 'error' => $e->getMessage()]));
    }
} 
if (!empty($newpassword)) {
    try {
        $user->setPassword($db, $newpassword);
    } catch (Exception $e) {
        die(json_encode(['success' => false, 'error' => $e->getMessage()]));
    }
}

die(json_encode(['success' => true]));