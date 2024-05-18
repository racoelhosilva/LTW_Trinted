<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function getProductBrandLinks(Product $product, Request $request): array {
    return [
        [
            'rel' => 'self',
            'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/brand/',
        ],
        [
            'rel' => 'all_brands',
            'href' => $request->getServerHost() . '/api/brand/',
        ],
        [
            'rel' => 'product',
            'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/',
        ]
    ];
}

function updateProductBrands(Product $product, array $add, array $remove, PDO $db): void {
    foreach ($add as $brandName) {
        $brand = Brand::getBrand($db, urlencode($brandName));
        if ($brand !== null) {
            $product->addBrand($db, $brand);
        }
    }

    foreach ($remove as $brandName) {
        $brand = Brand::getBrand($db, urlencode($brandName));
        if ($brand !== null) {
            $product->removeBrand($db, $brand);
        }
    }
}


$db = getDatabaseConnection();
$request = new Request();
$session = $request->getSession();

$method = $request->getMethod();
$endpoint = $request->getEndpoint();

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (preg_match('/^\/api\/product\/?$/', $endpoint, $matches)) {
            sendOk(['products' => parseProducts(Product::getAllProducts($db), $request)]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $productId = (int)$matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            sendOk(['product' => $product ? parseProduct($product, $request) : null]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/brand\/?$/', $endpoint, $matches)) {
            $productId = (int)$matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            $brands = parseBrands($product->getBrands($db));

            sendOk([
                'brands' => $brands,
                'links' => getProductBrandLinks($product, $request),
            ]);
        } else {
            sendNotFound();
        }

    case 'POST':
        if (preg_match('/^\/api\/product\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request)) 
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if (!in_array($user['type'], ['admin', 'seller']))
                sendForbidden('User must be seller or admin to create a product');
            if (!$request->paramsExist(['title', 'description', 'price']))
                sendMissingFields();
            if ($request->files('image') == null)
                sendBadRequest('Image file missing');

            try {
                $user = User::getUserByID($db, $user['id']);
                $product = createProduct($request, $user, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated(['links' => getProductLinks($product, $request)]);
        } else {
            sendNotFound();
        }

    case 'PUT':
        if (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $productId = (int)$matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request)) 
                sendUserNotLoggedIn();

            $user = getSessionUser($request);

            if ($product !== null) {
                if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                    sendForbidden('User must be the original seller or admin to edit a product');
                if (!$request->paramsExist(['title', 'description', 'price']))
                    sendMissingFields();

                try {
                    updateProduct($product, $request, $db);
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    sendInternalServerError();
                }

                sendOk(['links' => getProductLinks($product, $request)]);

            } else {
                if (!in_array($user['type'], ['seller', 'admin']))
                    sendForbidden('User must be a seller or admin to create a product');

                try {
                    $user = User::getUserByID($db, $user['id']);
                    $product = createProductWithId($request, $user, $db, $productId);
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    sendInternalServerError();
                }

                sendCreated(['links' => getProductLinks($product, $request)]);
            }

        } elseif (preg_match('/^\/api\/product\/(\d+)\/brand\/?$/', $endpoint, $matches)) {
            $productId = (int)$matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request))
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to update brands');

            if (!$request->paramsExist(['add', 'remove']))
                sendMissingFields();

            try {
                $add = $request->put('add');
                $remove = $request->put('remove');
                updateProductBrands($product, $add, $remove, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getProductBrandLinks($product, $request)]);
        } else {
            sendNotFound();
        }

    case 'PATCH':
        if (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);

            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request)) 
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to edit a product');

            try {
                modifyProduct($product, $request, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getProductLinks($product, $request)]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/brand\/?$/', $endpoint, $matches)) {
            $productId = (int)$matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request))
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to update brands');

            try {
                $add = $request->patch('add', []);
                $remove = $request->patch('remove', []);
                updateProductBrands($product, $add, $remove, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getProductBrandLinks($product, $request)]);
        } else {
            sendNotFound();
        }

    case 'DELETE':
        if (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request))
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to delete a product');
            
            try {
                $product->delete($db);
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
}
