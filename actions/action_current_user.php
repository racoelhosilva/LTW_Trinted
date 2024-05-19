<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/utils.php';

$request = new Request();

if ($request->getMethod() !== 'GET')
    sendMethodNotAllowed();

$sessionUser = getSessionUser($request);

sendOk(['user-id' => $sessionUser['id']]);
