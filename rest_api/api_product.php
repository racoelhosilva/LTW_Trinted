<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function getProductBrandLinks(Product $product, Request $request): array
{
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

function updateProductBrands(Product $product, array $brands, PDO $db): void
{
    $product->removeBrands($db);

    foreach ($brands as $brandName) {
        $brand = Brand::getBrand($db, urlencode($brandName));
        if ($brand !== null) {
            $product->addBrand($db, $brand);
        }
    }
}

function modifyProductBrands(Product $product, array $add, array $remove, PDO $db): void
{
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

function addProductImages(Request $request, Product $product, array $images, PDO $db): void
{
    foreach ($images as $imageUrl) {
        $product->addImage($db, new Image($imageUrl));
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
            sendOk(['products' => parseProducts(Product::getAllProducts($db), $request, $db)]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            sendOk(['product' => $product ? parseProduct($product, $request, $db) : null]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/brands\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            $brands = parseBrands($product->getBrands($db));

            sendOk([
                'brands' => $brands,
                'links' => getProductBrandLinks($product, $request),
            ]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/images\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            $images = $product->getAllImages($db);
            $images = array_map(function ($image) {
                return $image->getUrl();
            }, $images);

            sendOk([
                'images' => $images,
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/images/'
                    ],
                    [
                        'rel' => 'product',
                        'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/'
                    ]
                ]
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
            if (!$request->paramsExist(['title', 'description', 'price', 'image']))
                sendMissingFields();
            if (!filter_var($request->post('price'), FILTER_VALIDATE_FLOAT) || (int)$request->post('price') < 0)
                sendBadRequest('Invalid price value');

            try {
                $user = User::getUserByID($db, $user['id']);
                if ($user->getType() === 'buyer')
                    $user->setType($db, 'seller');
                $product = createProduct($request, $user, $db);

                
                
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated([
                'product' => parseProduct($product, $request, $db),
                'links' => getProductLinks($product, $request), 
            ]);

        } elseif (preg_match('/^\/api\/product\/(\d+)\/images\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
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
                $images = $request->post('images') ?? [];
                addProductImages($request, $product, $images, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendCreated([
                'links' => [
                    [
                        'rel' => 'self',
                        'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/images/'
                    ],
                    [
                        'rel' => 'product',
                        'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/'
                    ]
                ]
            ]);
        } else {
            sendNotFound();
        }

    case 'PUT':
        if (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
            $product = Product::getProductByID($db, $productId);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request))
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to edit a product');
            if (!$request->paramsExist(['title', 'description', 'price']))
                sendMissingFields();
            if (!filter_var($request->post('price'), FILTER_VALIDATE_FLOAT) || (int)$request->post('price') < 0)
                sendBadRequest('Invalid price value');

            try {
                updateProduct($product, $request, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getProductLinks($product, $request)]);

        } elseif (preg_match('/^\/api\/product\/(\d+)\/brands\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
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
                $brands = $request->put('brands', []);
                updateProductBrands($product, $brands, $db);
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
            $product = Product::getProductByID($db, (int) $matches[1]);

            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                sendCrsfMismatch();
            if (!isLoggedIn($request))
                sendUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->getId() && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to edit a product');
            if ($request->post('price') != null && (!filter_var($request->post('price'), FILTER_VALIDATE_FLOAT) || (int)$request->post('price') < 0))
                sendBadRequest('Invalid price value');

            try {
                modifyProduct($product, $request, $db);
            } catch (Exception $e) {
                error_log($e->getMessage());
                sendInternalServerError();
            }

            sendOk(['links' => getProductLinks($product, $request)]);
        } elseif (preg_match('/^\/api\/product\/(\d+)\/brands\/?$/', $endpoint, $matches)) {
            $productId = (int) $matches[1];
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
                modifyProductBrands($product, $add, $remove, $db);
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
            $product = Product::getProductByID($db, (int) $matches[1]);
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
