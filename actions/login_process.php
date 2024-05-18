<?php

// Start session
session_start();

require_once __DIR__ . '/../db/classes/User.class.php';

if (isset($_POST['loginemail']) && isset($_POST["loginpassword"])) {

    function sanitize($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$email = sanitize($_POST['loginemail']);
$password = sanitize($_POST['loginpassword']);

if (empty($email)) {
    header("Location: /login?loginerror=Email is required");
    exit();
} else if (empty($password)) {
    header("Location: /login?loginerror=Password is required");
    exit();
}

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
try {
    $user = User::getUserByEmail($db, $email);
} catch (Exception $e) {
    header("Location: /login?loginerror=User not found");
    exit();
}

$isPasswordCorrect = $user->validatePassword($password);
if (!$isPasswordCorrect) {
    header("Location: /login?loginerror=Invalid password");
    exit();
}

$_SESSION['user'] = [
    'id' => $user->getId(),
    'email' => $email,
    'name' => $user->getName(),
    'type' => $user->getType(),
];

header("Location: /actions/go_to_profile.php?id=" . $user->getId());
exit();