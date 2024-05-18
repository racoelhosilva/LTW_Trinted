<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function parseCategories(array $categories): array {
    return array_map(function ($category) {
        return $category->getName();
    }, $categories);
}

function storeCategory(Request $request, PDO $db): Category {
    $category = $request->post('name');
    $category = new Category($category);
    $category->upload($db);
    return $category;
}


$db = getDatabaseConnection();
$request = new Request();
$session = new Session();

$method = $request->getMethod();
$endpoint = $request->getEndpoint();

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (preg_match('/^\/api\/category\/?$/', $endpoint, $matches)) {
            $categories = parseCategories(Category::getAll($db));
            sendOk(['categories' => $categories]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/category\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!userLoggedIn($request))
                returnUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                sendForbidden('User must be admin to create a category');
            if (!$request->paramsExist(['name']))
                returnMissingFields();

            try {
                $category = storeCategory($request, $db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendCreated([
                'category' => $category->getName()
            ]);
        } else {
            sendNotFound();
        }

    default:
        sendNotFound();
}