<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function parseConditions(array $conditions): array {
    return array_map(function ($condition) {
        return $condition->getName();
    }, $conditions);
}

function storeCondition(Request $request, PDO $db): Condition {
    $condition = $request->post('name');
    $condition = new Condition($condition);
    $condition->upload($db);
    return $condition;
}


$db = getDatabaseConnection();
$request = new Request();
$session = new Session();

$method = $request->getMethod();
$endpoint = $request->getEndpoint();

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (preg_match('/^\/api\/condition\/?$/', $endpoint, $matches)) {
            $conditions = parseConditions(Condition::getAll($db));
            sendOk(['condtions' => $conditions]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/condition\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!userLoggedIn($request))
                sendUserNotLoggedIn();
            
            $user = getSessionUser($request);
            if ($user['type'] !== 'admin')
                sendForbidden('User must be admin to create a condition');
            if (!$request->paramsExist(['name']))
                sendMissingFields();

            try {
                $condition = storeCondition($request, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated([
                'links' => [
                    [
                        'rel' => 'conditions',
                        'href' => $request->getServerHost() . '/api/condition/',
                    ],
                ],
            ]);
        } else {
            sendNotFound();
        }

    default:
        sendMethodNotAllowed();
}