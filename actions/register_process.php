<?php

// registername
// registeremail
// registerpassword

// Start session
session_start();

require_once '../db/classes/User.class.php';

if (isset($_POST['registername']) && isset($_POST["registeremail"]) && isset($_POST["registerpassword"])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$name = validate($_POST['registername']);
$email = validate($_POST['registeremail']);
$password = validate($_POST['registerpassword']);

if (empty($name)) {
    header("Location: /login?loginerror=Username is required");
    exit();
} else if (empty($email)) {
    header("Location: /login?loginerror=Email is required");
    exit();
} else if (empty($password)) {
    header("Location: /login?loginerror=Password is required");
    exit();
}

$user = new User(73, $email, $name, $password, time(), new Image("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGt4iF5y8eiMnD87lrrXEwzvKIXSfPgGpjtiTEm5yOAA&s"), "buyer");
$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $user->hashPassword();
    $user->upload($db);
} catch (Exception $e) {
    header("Location: /login?loginerror=Email already in use");
    exit();
}

$_SESSION['user_id'] = $user->id;
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;
header("Location: /profile");
exit();