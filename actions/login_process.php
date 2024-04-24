<?php

// Start session
session_start();

require_once '../db/classes/User.class.php';

if (isset($_POST['loginemail']) && isset($_POST["loginpassword"])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$email = validate($_POST['loginemail']);
$password = validate($_POST['loginpassword']);

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
$_SESSION['user_id'] = $user->username;
$_SESSION['email'] = $email;
$_SESSION['name'] = $user->name;
header("Location: /profile");
exit();

// Check if the form is submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get username and password from the form
//     $email = $_POST['loginemail'];
//     $password = $_POST['loginpassword'];
//     $db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
//     try {
//         $user = User::getUserByEmail($db, $email);
//     } catch (Exception $e) {
//         echo '<script>alert("User not found")</script>';
//         sleep(2);
//         header("Location: /login");
//     }
//     $isPasswordCorrect = $user->validatePassword($password);
//     if (!$isPasswordCorrect) {
//         print("Invalid password");
//     } else {
//         print("Login successful");
//     }

//     // Perform authentication (you can include your authentication code here)

//     // For demonstration purposes, let's assume the user is authenticated
//     // Set session variables
//     $_SESSION['user_id'] = $email;
//     header("Location: /");
// }
