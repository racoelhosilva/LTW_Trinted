<?php
declare(strict_types=1);

require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/../db/classes/Product.class.php';
require_once __DIR__ . '/../framework/Request.php';
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

function storeProduct(Request $request, PDO $db): array {
    $item = new Item(
        0,
        "",
        $request->post('item_id'),
        $request->post('size_id'),
        $request->post('condition_id'),
    );
    $product = new Product(
        0,
        $request->post('title'),
        (float)$request->post('price'),
        $request->post('description'),
        time(),
        $request->getSession()->get('user_id'),
        
    );
}


$db = getDatabaseConnection();
$request = new Request();
$session = $request->getSession();

$method = getMethod($request);
$endpoint = getEndpoint($request);

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if ($endpoint === '/api/product') {
            die(json_encode(parseProducts(Product::getAllProducts($db), $db)));
        } elseif (preg_match('/^\/api\/product\/(\d+)$/', $endpoint, $matches)) {
            $product = Product::getProductByID($db, (int)$matches[1]);
            die(json_encode(['success' => true, 'product' => $product ? parseProduct($product, $db) : null]));
        }
        break;

    case 'POST':
        if ($endpoint == '/api/product') {
            if (!$request->verifyCsrf())
                returnCrsfMismatch();
            if (!isLoggedIn($request)) 
                returnUserNotLoggedIn();
            if (!$request->paramsExist('POST', ['title', 'description', 'price', 'condition_id']))
                returnMissingFields();
            $product = new Product(
                $request->post('title'),
                $request->post('description'),
                $request->post('price'),
                $session->get('user_id'),
                $request->post('item_id'),
                $request->post('condition_id'),

            );
            $product->upload($db);
            die(json_encode(['success' => true, 'product' => parseProduct($product, $db)]));
        }
        break;
}
