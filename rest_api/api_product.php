<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function parseProduct(Product $product, PDO $db): array {
    return array(
        'id' => $product->getId(),
        'title' => $product->getTitle(),
        'description' => $product->getDescription(),
        'price' => $product->getPrice(),
        'publishDatetime' => $product->getPublishDatetime(),
        'category' => $product->getCategory()->getName(),
        'size' => $product->getSize()->getName(),
        'condition' => $product->getCondition()->getName(),
        'links' => [
            [
                'rel' => 'self',
                'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->getId(),
            ],
            [
                'rel' => 'seller',
                'href' => $_SERVER['HTTP_HOST'] . '/api/user/' . $product->getSeller()->id,
            ],
            [
                'rel' => 'images',
                'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->getId() . '/images',
            ]
        ]
    );
}

function parseProducts(array $product, PDO $db): array {
    return array_map(function ($product) use ($db) {
        return parseProduct($product, $db);
    }, $product);
}

function storeProduct(Request $request, PDO $db): Product {
    $title = $request->post('title');
    $price = (float)$request->post('price');
    $description = $request->post('description');

    $sellerId = $request->getSession()->get('user')['id'];
    $seller = User::getUserByID($db, $sellerId);

    $size = $request->post('size') != null ? Size::getSize($db, $request->post('size')) : null;
    $category = $request->post('category') != null ? Category::getCategory($db, $request->post('category')) : null;
    $condition = $request->post('condition') != null ? Condition::getCondition($db, $request->post('condition')) : null;

    $product = new Product(0, $title, $price, $description, time(), $seller, $size, $category, $condition);
    $product->upload($db);

    $image = new Image('https://thumbs.dreamstime.com/b/telefone-nokia-do-vintage-isolada-no-branco-106323077.jpg');  // TODO: change image
    $image->upload($db);
    $productImage = new ProductImage($product, $image);
    $productImage->upload($db);

    return $product;
}

function updateProduct(Product $product, Request $request, PDO $db): void {
    $title = $request->put('title');
    $price = (float)$request->put('price');
    $description = $request->put('description');
    $size = $request->put('size') ? Size::getSize($db, $request->put('size')) : null;
    $category = $request->put('category') ? Category::getCategory($db, $request->put('category')) : null;
    $condition = $request->put('condition') ? Condition::getCondition($db, $request->put('condition')) : null;

    $product->setTitle($title, $db);
    $product->setPrice($price, $db);
    $product->setDescription($description, $db);
    $product->setSize($size, $db);
    $product->setCategory($category, $db);
    $product->setCondition($condition, $db);
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
            sendOk(parseProducts(Product::getAllProducts($db), $db));
        } elseif (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);
            if ($product === null)
                sendNotFound();

            sendOk($product ? parseProduct($product, $db) : null);
        }

    case 'POST':
        if (preg_match('/^\/api\/product\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!isLoggedIn($request)) 
                returnUserNotLoggedIn();

            $user = getSessionUser($request);
            if (!in_array($user['type'], ['admin', 'seller']))
                sendForbidden('User must be seller or admin to create a product');
            if (!$request->paramsExist(['title', 'description', 'price']))
                returnMissingFields();
            if ($request->files('image') == null)
                sendBadRequest('Image file missing');

            try {
                $product = storeProduct($request, $db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendCreated([
                'success' => true,
                'links' => [
                    'rel' => 'self',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->getId()
                ],
                [
                    'rel' => 'seller',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/user/' . $product->getSeller()->id,
                ],
                [
                    'rel' => 'images',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->getId() . '/images',
                ]
            ]);
        } else {
            sendNotFound();
        }

    case 'PUT':
        if (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!isLoggedIn($request)) 
                returnUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->id && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to edit a product');
            if (!$request->paramsExist(['title', 'description', 'price']))
                returnMissingFields();

            try {
                updateProduct($product, $request, $db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendOk([
                'success' => true,
                'links' => [
                    'rel' => 'self',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $productId
                ],
                [
                    'rel' => 'seller',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/user/' . $product->getSeller()->id,
                ],
                [
                    'rel' => 'images',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->getId() . '/images',
                ]
            ]);
        } else {
            sendNotFound();
        }

    case 'DELETE':
        if (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);
            if ($product === null)
                sendNotFound();

            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!isLoggedIn($request))
                returnUserNotLoggedIn();

            $user = getSessionUser($request);
            if ($user['id'] !== $product->getSeller()->id && $user['type'] !== 'admin')
                sendForbidden('User must be the original seller or admin to delete a product');
            
            try {
                $product->delete($db);
            } catch (Exception $e) {
                sendInternalServerError();
            }

            sendOk(['success' => true]);
        } else {
            sendNotFound();
        }
    
    default:
        sendMethodNotAllowed();
}
