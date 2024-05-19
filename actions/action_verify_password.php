<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/utils.php';

$request = new Request();
$db = getDatabaseConnection();

if ($request->getMethod() !== 'POST')
    sendMethodNotAllowed();

if (!$request->verifyCsrf())
    sendCrsfMismatch();

$sessionUser = getSessionUser($request);
if ($sessionUser === null)
    sendUserNotLoggedIn();
$user = User::getUserByID($db, $sessionUser['id']);

if (!$request->paramsExist(['password']))
    sendMissingFields();

$password = $request->post('password');

sendOk(['valid' => $user->validatePassword($password)]);
