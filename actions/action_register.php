<?php

require_once '../framework/Autoload.php';
require_once '../db/utils.php';
require_once '../rest_api/utils.php';

$request = new Request();
$db = getDatabaseConnection();

if ($request->getMethod() != 'POST') {
    die(header("Location: /login?register-error=Invalid request method"));
}

if (!$request->verifyCsrf()) {
    die(header("Location: /login?login-error=CSRF token is invalid"));
}

if (!$request->paramsExist(['register-name', 'register-email', 'register-password'])) {
    die(header("Location: /login?register-error=Name, email and password are required"));
}

$name = $request->post('register-name');
$email = $request->post('register-email');
$password = $request->post('register-password');

if (empty($name)) {
    die(header("Location: /login?register-error=Username is required"));
} else if (empty($email)) {
    die(header("Location: /login?register-error=Email is required"));
} else if (empty($password)) {
    die(header("Location: /login?register-error=Password is required"));
}

try {
    $user = new User(null, $email, $name, $password, time(), new Image('https://wallpapers.com/images/high/basic-default-pfp-pxi77qv5o0zuz8j3.webp'), 'buyer');
    $user->hashPassword();
    $user->upload($db);
} catch (Exception $e) {
    die(header("Location: /login?register-error=Email already in use"));
}

$request->getSession()->set('user', [
    'id' => $user->getId(),
    'email' => $email,
    'name' => $name,
    'type' => $user->getType(),
]);

die(header("Location: /profile"));