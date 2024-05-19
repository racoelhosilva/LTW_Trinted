<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/../db/utils.php';

$request = new Request();

$db = getDatabaseConnection();

if ($request->getMethod() != 'POST') {
    die(header("Location: /login?login-error=Invalid request method"));
}

if (!$request->verifyCsrf()) {
    die(header("Location: /login?login-error=CSRF token is invalid"));
}

if (!$request->paramsExist(['login-email', 'login-password'])) {
    die(header("Location: /login?login-error=Email and password are required"));
}

$email = $request->post('login-email');
$password = $request->post('login-password');

if (empty($email)) {
    die(header("Location: /login?login-error=Email is required"));
} else if (empty($password)) {
    die(header("Location: /login?login-error=Password is required"));
}

$user = User::getUserByEmail($db, $email);
if ($user == null)
    die(header("Location: /login?login-error=User not found"));

$isPasswordCorrect = $user->validatePassword($password);
if (!$isPasswordCorrect) {
    die(header("Location: /login?login-error=Invalid password"));
}

$request->getSession()->set('user', [
    'id' => $user->getId(),
    'email' => $email,
    'name' => $user->getName(),
    'type' => $user->getType(),
]);

die(header("Location: /profile?id=" . $user->getId()));