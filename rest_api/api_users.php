<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function userIsBeingPrivileged(User $user, string $newType, $request): bool
{
    return $user->getType() == 'buyer' && $newType != 'buyer'
        || $user->getType() == 'seller' && $newType == 'admin';
}


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

            $user = parseUser($user, $request);
            sendOk(['users' => $user]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/user\/?$/', $endpoint, $matches)) {
            if (!$request->paramsExist(['email', 'name', 'password']))
                sendMissingFields();
            if (!filter_var($request->post('email'), FILTER_VALIDATE_EMAIL))
                sendBadRequest('Invalid email format');

            $user = User::getUserByEmail($db, $request->post('email'));
            if ($user != null)
                sendConflict();

            try {
                $user = createUser($request, $db);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated(['links' => getUserLinks($user, $request)]);
        } else {
            sendNotFound();
        }
    
    case 'PUT':
        if (preg_match('/^\/api\/user\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);

            if ($user != null) {
                if (!$request->paramsExist(['email', 'name', 'password', 'type', 'profile_picture']))
                    sendMissingFields();
                if (!filter_var($request->put('email'), FILTER_VALIDATE_EMAIL))
                    sendBadRequest('Invalid email format');
                if (!in_array($request->put('type'), ['buyer', 'seller', 'admin']))
                    sendBadRequest('Invalid user type');

                if (!$request->verifyCsrf())
                    sendCrsfMismatch();

                $sessionUser = getSessionUser($request);
                if ($sessionUser['id'] != $user->getId() && $sessionUser['type'] != 'admin')
                    sendUnauthorized('User must be admin to update other users');
                if ($sessionUser['type'] != 'admin' && userIsBeingPrivileged($user, $request->put('type'), $request))
                    sendForbidden('User cannot be privileged by non-admin');
                if ($request->put('is_banned') != null && $sessionUser['type'] != 'admin')
                    sendForbidden('User must be admin to ban users');

                try {
                    updateUser($user, $request, $db);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    sendInternalServerError();
                }

                sendOk(['links' => getUserLinks($user, $request)]);
            } else {
                if (!$request->paramsExist(['email', 'name', 'password', 'profile_picture']))
                    sendMissingFields();
                if (!filter_var($request->put('email'), FILTER_VALIDATE_EMAIL))
                    sendBadRequest('Invalid email format');

                try {
                    $user = createUserWithId($request, $db, $userId);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    sendInternalServerError();
                }

                sendCreated(['links' => getUserLinks($user, $request)]);
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
            if ($sessionUser['id'] != $user->getId() && $sessionUser['type'] != 'admin')
                sendUnauthorized('User must be admin to update other users');
            if ($sessionUser['type'] != 'admin' && $request->put('type') != null && userIsBeingPrivileged($user, $request->put('type'), $request))
                sendForbidden('User cannot be privileged by non-admin');
            if ($request->patch('is_banned') != null && $sessionUser['type'] != 'admin')
                sendForbidden('User must be admin to ban users');

            try {
                modifyUser($user, $request, $db);
            } catch (PDOException $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getUserLinks($user, $request)]);
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
        
    default:
        sendMethodNotAllowed();
}
