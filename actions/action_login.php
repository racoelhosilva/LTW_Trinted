<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/../db/utils.php';

$request = new Request();

$db = getDatabaseConnection();

if ($request->getMethod() != 'POST') {
    die(header("Location: /login?loginerror=Invalid request method"));
}

if ($request->verifyCsrf()) {
    die(header("Location: /login?loginerror=CSRF token is invalid"));
}

if (!$request->paramsExist(['login_email', 'login_password'])) {
    die(header("Location: /login?loginerror=Email and password are required"));
}

$email = $request->post('login_email');
$password = $request->post('login_password');

if (empty($email)) {
    die(header("Location: /login?loginerror=Email is required"));
} else if (empty($password)) {
    die(header("Location: /login?loginerror=Password is required"));
}

$user = User::getUserByEmail($db, $email);
if ($user == null)
    die(header("Location: /login?loginerror=User not found"));

$isPasswordCorrect = $user->validatePassword($password);
if (!$isPasswordCorrect) {
    die(header("Location: /login?loginerror=Invalid password"));
}

$request->getSession()->set('user', [
    'id' => $user->getId(),
    'email' => $email,
    'name' => $user->getName(),
    'type' => $user->getType(),
]);

die(header("Location: /actions/go_to_profile.php?id=" . $user->getId()));