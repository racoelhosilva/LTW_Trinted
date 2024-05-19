<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


$db = getDatabaseConnection();
$request = new Request();
$session = new Session();

$method = $request->getMethod();
$endpoint = $request->getEndpoint();

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (preg_match('/^\/api\/size\/?$/', $endpoint, $matches)) {
            $sizes = parseSizes(Size::getAll($db));
            sendOk(['sizes' => $sizes]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/size\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!userLoggedIn($request))
                sendUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                sendForbidden('User must be admin to create a size');
            if (!$request->paramsExist(['name']))
                sendMissingFields();

            try {
                $size = storeSize($request, $db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendCreated([
                'links' => [
                    [
                        'rel' => 'sizes',
                        'href' => $request->getServerHost() . '/api/size/',
                    ]
                ]
            ]);
        } else {
            sendNotFound();
        }

    default:
        sendMethodNotAllowed();
}

