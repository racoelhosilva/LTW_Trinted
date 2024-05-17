<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';


function parseProduct(Product $product, PDO $db): array {
    return array(
        'id' => $product->id,
        'title' => $product->title,
        'description' => $product->description,
        'price' => $product->price,
        'publishDatetime' => $product->publishDateTime,
        'category' => $product->category->name,
        'size' => $product->size->name,
        'condition' => $product->condition->name,
        'links' => [
            [
                'rel' => 'self',
                'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->id,
            ],
            [
                'rel' => 'seller',
                'href' => $_SERVER['HTTP_HOST'] . '/api/user/' . $product->seller->id,
            ],
            [
                'rel' => 'images',
                'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $product->id . '/images',
            ]
        ]
    );
}

function parseProducts(array $product, PDO $db): array {
    return array_map(function ($product) use ($db) {
        return parseProduct($product, $db);
    }, $product);
}

function storeProduct(Request $request, PDO $db): int {
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

    $image = new Image('https://thumbs.dreamstime.com/b/telefone-nokia-do-vintage-isolada-no-branco-106323077.jpg');
    $image->upload($db);
    $productImage = new ProductImage($product, $image);
    $productImage->upload($db);

    return (int)$product->id;
}


$db = getDatabaseConnection();
$request = new Request();
$session = $request->getSession();

$method = getMethod($request);
$endpoint = getEndpoint($request);

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if (preg_match('/^\/api\/product\/?$/', $endpoint, $matches)) {
            die(json_encode(parseProducts(Product::getAllProducts($db), $db)));
        } elseif (preg_match('/^\/api\/product\/(\d+)\/?$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);
            if ($product === null)
                die(header('HTTP/1.0 404 Not Found'));
            die(json_encode(['success' => true, 'product' => $product ? parseProduct($product, $db) : null]));
        }
        break;

    case 'POST':
        if (preg_match('/^\/api\/product\/?$/', $endpoint, $matches)) {
            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!isLoggedIn($request)) 
                returnUserNotLoggedIn();

            $user = getSessionUser($request);
            if (!in_array($user['type'], ['admin', 'seller']))
                die(json_encode(['success' => false, 'error' => 'User must be seller or admin to create a post']));
            if (!$request->paramsExist('POST', ['title', 'description', 'price']))
                returnMissingFields();
            if ($request->files('image') == null)
                die(json_encode(['success' => false, 'error' => 'Missing product image']));

            try {
                $productId = storeProduct($request, $db);
            } catch (Exception $e) {
                die(json_encode(['success' => false, 'error' => $e->getMessage()]));
            }

            die(json_encode([
                'success' => true,
                'links' => [
                    'rel' => 'product',
                    'href' => $_SERVER['HTTP_HOST'] . '/api/product/' . $productId
                ]
            ]));
        }
        break;
}
