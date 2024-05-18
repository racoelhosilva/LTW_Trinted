<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function parseBrands(array $brands): array {
    return array_map(function ($brand) {
        return $brand->getName();
    }, $brands);
}

function storeBrand(Request $request, PDO $db): Brand {
    $brand = $request->post('name');
    $brand = new Brand($brand);
    $brand->upload($db);
    return $brand;
}


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
                returnCrsfMismatch();
            if (!userLoggedIn($request))
                returnUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                sendForbidden('User must be admin to create a brand');
            if (!$request->paramsExist(['name']))
                returnMissingFields();

            try {
                $brand = storeBrand($request, $db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendCreated([
                'brand' => $brand->getName()
            ]);
        } else {
            sendNotFound();
        }
        break;

    default:
        sendNotFound();
        break;
}

