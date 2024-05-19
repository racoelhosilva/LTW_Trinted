<?php
require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/utils.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));


$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
try {
    $user = User::getUserByID($db, $_SESSION['user']['id']);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => 'User not found']));
}

$newUsername = sanitize($_POST['username']);
$newEmail = sanitize($_POST['email']);
$newPassword = sanitize($_POST['new']);
$currentPassword = sanitize($_POST['old']);
$newProfilePicture = sanitize($_POST['profile_picture']);

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
        $user->setProfilePicture($db, new Image($newProfilePicture));

    }
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true]));