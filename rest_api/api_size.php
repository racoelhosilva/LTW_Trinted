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
            $sizes = Size::getAll($db);
            die(json_encode(parseSizes($sizes, $db)));
        } else {
            die(header('HTTP/1.1 404 Not Found'));
        }

    case 'POST':
        if (preg_match('/^\/api\/size\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!userLoggedIn($request))
                returnUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                die(json_encode(['success' => false, 'error' => 'User must be admin to create a size']));
            if (!$request->paramsExist(['name']))
                returnMissingFields();

            $size = storeSize($request, $db);
            die(json_encode(['success' => true, 'size' => $size->getName()]));
        } else {
            die(header('HTTP/1.1 404 Not Found'));
        }

    default:
        die(header('HTTP/1.1 404 Not Found'));
}

