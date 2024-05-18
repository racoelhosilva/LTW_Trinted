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
        if (preg_match('/^\/api\/wishlist\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            if (!userLoggedIn($request))
                sendUserNotLoggedIn();

            $sessionUser = getSessionUser($request);
            if ($sessionUser['id'] != $userId)
                sendUnauthorized('Only the owner can see the wishlist');

            $products = parseProducts($user->getWishlist($db), $request);
            sendOk([
                'products' => $products,
                'links' => [
                    'rel' => 'self',
                    'href' => $request->getServerHost() . '/api/wishlist/' . $userId . '/',
                ],
                [
                    'rel' => 'user',
                    'href' => $request->getServerHost() . '/api/user/' . $userId . '/',
                ]
            ]);

        } elseif (preg_match('/^\/api\/wishlist\/(\d+)\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $productId = (int)$matches[2];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            $product = Product::getProductById($db, $productId);
            if ($product == null)
                sendNotFound();

            if (!userLoggedIn($request))
                sendUserNotLoggedIn();

            $sessionUser = getSessionUser($request);
            if ($sessionUser['id'] != $userId)
                sendUnauthorized('Only the owner can see the wishlist');

            if (!$user->isInWishlist($db, $product))
                sendNotFound();

            sendOk([
                'product' => parseProduct($product, $request),
                'links' => [
                    'rel' => 'self',
                    'href' => $request->getServerHost() . '/api/wishlist/' . $userId . '/' . $productId . '/',
                ],
                [
                    'rel' => 'user',
                    'href' => $request->getServerHost() . '/api/user/' . $userId . '/',
                ]
            ]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/wishlist\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!userLoggedIn($request))
                sendUserNotLoggedIn();

            $sessionUser = getSessionUser($request);
            if ($sessionUser['id'] != $userId)
                sendUnauthorized('Only the owner can add a product to the wishlist');
            if (!$request->paramsExist(['product']))
                sendMissingFields();

            $productId = (int)$request->post('product');
            $product = Product::getProductById($db, $productId);
            if ($product == null)
                sendBadRequest('Product not found');

            if ($user->isInWishlist($db, $product))
                sendBadRequest('Product is already in the wishlist');

            try {
                $user->addToWishlist($db, $product);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated([
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => $request->getServerHost() . '/api/wishlist/' . $userId . '/',
                    ],
                    [
                        'rel' => 'wishlist_item',
                        'href' => $request->getServerHost() . '/api/wishlist/' . $userId . '/' . $productId . '/',
                    ],
                    [
                        'rel' => 'user',
                        'href' => $request->getServerHost() . '/api/user/' . $userId . '/',
                    ]
                ]
            ]);
        } else {
            sendNotFound();
        }

    case 'DELETE':
        if (preg_match('/^\/api\/wishlist\/(\d+)\/(\d+)\/?$/', $endpoint, $matches)) {
            $userId = (int)$matches[1];
            $productId = (int)$matches[2];
            $user = User::getUserById($db, $userId);
            if ($user == null)
                sendNotFound();

            $product = Product::getProductById($db, $productId);
            if ($product == null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!userLoggedIn($request))
                sendUserNotLoggedIn();

            $sessionUser = getSessionUser($request);
            if ($sessionUser['id'] != $userId)
                sendUnauthorized('Only the owner can remove a product from the wishlist');


            if (!$user->isInWishlist($db, $product))
                sendNotFound();

            try {
                $user->removeFromWishlist($db, $product);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk([]);
            
        } else {
            sendNotFound();
        }

    default:
        sendMethodNotAllowed();
        break;
}