<?php

require_once '../framework/Autoload.php';
require_once '../rest_api/utils.php';

$request = new Request();
$db = getDatabaseConnection();

if ($request->getMethod() != 'POST') {
    die(header("Location: /login?loginerror=Invalid request method"));
}
if ($request->verifyCsrf()) {
    die(header("Location: /login?loginerror=CSRF token is invalid"));
}
if (!$request->paramsExist(['register_name', 'register_email', 'register_password'])) {
    die(header("Location: /login?loginerror=Name, email and password are required"));
}

$name = $request->post('register_name');
$email = $request->post('register_email');
$password = $request->post('register_password');

if (empty($name)) {
    die(header("Location: /login?loginerror=Username is required"));
} else if (empty($email)) {
    die(header("Location: /login?loginerror=Email is required"));
} else if (empty($password)) {
    die(header("Location: /login?loginerror=Password is required"));
}

try {
    $user = new User(null, $email, $name, $password, time(), new Image('https://wallpapers.com/images/high/basic-default-pfp-pxi77qv5o0zuz8j3.webp'), 'buyer');
    $user->hashPassword();
    $user->upload($db);
} catch (Exception $e) {
    die(header("Location: /login?loginerror=Email already in use"));
}

$request->getSession()->set('user', [
    'id' => $user->getId(),
    'email' => $email,
    'name' => $name,
    'type' => $user->getType(),
]);

die(header("Location: /profile"));