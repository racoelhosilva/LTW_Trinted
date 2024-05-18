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
                $user = createUser($request, $db);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated(['links' => getUserLinks($user)]);
        } else {
            sendNotFound();
        }
    
    case 'PUT':
        if (preg_match('/^\/api\/user\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);
            if ($user != null) {
                if (!$request->verifyCsrf())
                    sendCrsfMismatch();

                $sessionUser = getSessionUser($request);
                if ($sessionUser['id'] != $user->getId() || $sessionUser['type'] != 'admin')
                    sendUnauthorized('User must be admin to update other users');

                try {
                    updateUser($user, $request, $db);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    sendInternalServerError();
                }

                sendOk(['links' => getUserLinks($user)]);
            } else {
                try {
                    $user = createUserWithId($request, $db, $userId);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    sendInternalServerError();
                }

                sendCreated(['links' => getUserLinks($user)]);
            }
        } else {
            sendNotFound();
        }

    case 'PATCH':
        if (preg_match('/^\/api\/user\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();

            $sessionUser = getSessionUser($request);
            if ($sessionUser['id'] != $user->getId() || $sessionUser['type'] != 'admin')
                sendUnauthorized('User must be admin to update other users');

            try {
                updateUser($user, $request, $db);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getUserLinks($user)]);
        } else {
            sendNotFound();
        }
        
    case 'DELETE':
        if (preg_match('/^\/api\/user\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            $sessionUser = getSessionUser($request);
            if ($sessionUser['type'] != 'admin')
                sendUnauthorized('User must be admin to delete other users');
            if ($sessionUser['id'] == $user->getId())
                sendForbidden('User cannot delete itself');

            try {
                $user->delete($db);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk([]);
        } else {
            sendNotFound();
        }
}
