<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function parseSizes(array $sizes, PDO $db): array {
    return array_map(function ($size) {
        return $size->getName();
    }, $sizes);
}

function storeSize(Request $request, PDO $db): Size {
    $size = $request->post('name');
    $size = new Size($size);
    $size->upload($db);
    return $size;
}


$db = getDatabaseConnection();
$request = new Request();
$session = new Session();

$method = $request->getMethod();
$endpoint = $request->getEndpoint();

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (preg_match('/^\/api\/size\/?$/', $endpoint, $matches)) {
            $sizes = parseSizes(Size::getAll($db), $db);
            sendOk($sizes);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/size\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!userLoggedIn($request))
                returnUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                sendForbidden('User must be admin to create a size');
            if (!$request->paramsExist(['name']))
                returnMissingFields();

            try {
                $size = storeSize($request, $db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendCreated([
                'success' => true,
                'links' => [
                    'sizes' => '/api/size/'
                ]
            ]);
        } else {
            sendNotFound();
        }

    default:
        sendNotFound();
}

