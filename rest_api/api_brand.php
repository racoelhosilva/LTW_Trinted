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
        if (preg_match('/^\/api\/brand\/?$/', $endpoint, $matches)) {
            $brands = parseBrands(Brand::getAll($db));
            sendOk(['brands' => $brands]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/brand\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!userLoggedIn($request))
                sendUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                sendForbidden('User must be admin to create a brand');
            if (!$request->paramsExist(['name']))
                sendMissingFields();

            try {
                $brand = storeBrand($request, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated([
                'links' => [
                    [
                        'rel' => 'brands',
                        'href' => $request->getServerHost() . '/api/brand/',
                    ]
                ]
            ]);
        } else {
            sendNotFound();
        }
        break;

    default:
        sendMethodNotAllowed();
}

