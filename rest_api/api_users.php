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
        if (preg_match('/^\/api\/user\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            sendOk(['users' => $users]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/user\/?$/', $endpoint, $matches)) {
            $user = User::getUserByEmail($db, $request->post('email'));
            if ($user != null)
                sendConflict();

            try {
                
            } catch (PDOException $e) {
                sendInternalServerError();
            }

            sendCreated(['user' => $user]);
        } else {
            sendNotFound();
        }
}
