<?php
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));


$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
try {
    $user = User::getUserByID($db, $_SESSION['user_id']);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => 'User not found']));
}

$newUsername = validate($_POST['username']);
$newEmail = validate($_POST['email']);
$newPassword = validate($_POST['new']);
$currentPassword = validate($_POST['old']);
$newProfilePicture = validate($_POST['profile_picture']);

if (!$user->validatePassword($currentPassword)) {
    die(json_encode(['success' => false, 'error' => 'Incorrect password']));
}

if (empty($newUsername) && empty($newEmail) && empty($newPassword) && empty($newProfilePicture)) {
    die(json_encode(['success' => false, 'error' => 'No fields to change']));
}

try {
    if (!empty($newUsername))
        $user->setName($db, $newUsername);
    if (!empty($newEmail))
        $user->setEmail($db, $newEmail);
    if (!empty($newPassword))
        $user->setPassword($db, $newPassword);
    if (!empty($newProfilePicture)) {
        $user->setProfilePicture($db, $newProfilePicture);

    }
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true]));