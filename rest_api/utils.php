<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Request.php';

function userLoggedIn(Request $request): bool {
    return $request->session('user') !== null;
}


function sendOk(mixed $data): void {
    http_response_code(200);
    die(json_encode(['success' => true, ...$data]));
}

function sendCreated(mixed $data): void {
    http_response_code(201);
    die(json_encode(['success' => true, ...$data]));
}

function sendBadRequest(string $message): void {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => $message]));
}

function sendUnauthorized(string $message): void {
    http_response_code(401);
    die(json_encode(['success' => false, 'error' => $message]));
}

function sendForbidden(string $message): void {
    http_response_code(403);
    die(json_encode(['success' => false, 'error' => $message]));
}

function sendNotFound(): void {
    http_response_code(404);
    die(json_encode(['success' => false, 'error' => 'Resource not found']));
}

function sendMethodNotAllowed(): void {
    http_response_code(405);
    die(json_encode(['success' => false, 'error' => 'Method not allowed']));
}

function sendInternalServerError(): void {
    http_response_code(500);
    die(json_encode(['success' => false, 'error' => 'Internal server error']));
}


function sendUserNotLoggedIn(): void {
    sendUnauthorized('User not logged in');
}

function sendCrsfMismatch(): void {
    sendForbidden('CSRF token missing or invalid');
}

function sendMissingFields(): void {
    sendBadRequest('One or more fields missing');
}

function sendInvalidFields(): void {
    sendBadRequest('One or more fields invalid');
}

function getSessionUser(Request $request): array {
    return $request->session('user');
}

function getProductLinks(Product $product, Request $request): array {
    return [
        [
            'rel' => 'self',
            'href' => $request->getServerHost() . '/api/product/' . $product->getId(),
        ],
        [
            'rel' => 'seller',
            'href' => $request->getServerHost() . '/api/user/' . $product->getSeller()->id,
        ],
        [
            'rel' => 'images',
            'href' => $request->getServerHost() . '/api/product/' . $product->getId() . '/images',
        ]
    ];
}

function parseProduct(Product $product, Request $request): array {
    return [
        'id' => $product->getId(),
        'title' => $product->getTitle(),
        'description' => $product->getDescription(),
        'price' => $product->getPrice(),
        'publishDatetime' => $product->getPublishDatetime(),
        'category' => $product->getCategory()?->getName(),
        'size' => $product->getSize()?->getName(),
        'condition' => $product->getCondition()?->getName(),
        'links' => getProductLinks($product, $request),
    ];
}

function parseProducts(array $products, Request $request): array {
    return array_map(function ($product) use ($request) {
        return parseProduct($product, $request);
    }, $products);
}

function createProduct(Request $request, User $seller, PDO $db): Product {
    $title = $request->post('title');
    $price = (float)$request->post('price');
    $description = $request->post('description');

    $sellerId = $request->session('user')['id'];
    $seller = User::getUserByID($db, $sellerId);

    $size = $request->post('size') != null ? Size::getSize($db, $request->post('size')) : null;
    $category = $request->post('category') != null ? Category::getCategory($db, $request->post('category')) : null;
    $condition = $request->post('condition') != null ? Condition::getCondition($db, $request->post('condition')) : null;

    $product = new Product(null, $title, $price, $description, time(), $seller, $size, $category, $condition);
    $product->upload($db);

    $image = new Image('https://thumbs.dreamstime.com/b/telefone-nokia-do-vintage-isolada-no-branco-106323077.jpg');  // TODO: change image
    $image->upload($db);
    $productImage = new ProductImage($product, $image);
    $productImage->upload($db);

    return $product;
}

function createProductWithId(Request $request, User $seller, PDO $db, int $id): Product {
    $title = $request->put('title');
    $price = (float)$request->put('price');
    $description = $request->put('description');

    $size = $request->put('size') != null ? Size::getSize($db, $request->put('size')) : null;
    $category = $request->put('category') != null ? Category::getCategory($db, $request->put('category')) : null;
    $condition = $request->put('condition') != null ? Condition::getCondition($db, $request->put('condition')) : null;

    $product = new Product($id, $title, $price, $description, time(), $seller, $size, $category, $condition);
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

function modifyProduct(Product $product, Request $request, PDO $db): void {
    $title = $request->patch('title');
    $price = (float)$request->patch('price');
    $description = $request->patch('description');
    $size = $request->patch('size') ? Size::getSize($db, $request->patch('size')) : null;
    $category = $request->patch('category') ? Category::getCategory($db, $request->patch('category')) : null;
    $condition = $request->patch('condition') ? Condition::getCondition($db, $request->patch('condition')) : null;

    if ($title) $product->setTitle($title, $db);
    if ($price) $product->setPrice($price, $db);
    if ($description) $product->setDescription($description, $db);
    if ($size) $product->setSize($size, $db);
    if ($category) $product->setCategory($category, $db);
    if ($condition) $product->setCondition($condition, $db);
}

function parseCategories(array $categories): array {
    return array_map(function ($category) {
        return $category->getName();
    }, $categories);
}

function storeCategory(Request $request, PDO $db): Category {
    $category = $request->post('name');
    $category = new Category($category);
    $category->upload($db);
    return $category;
}

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

function parseSizes(array $sizes): array {
    return array_map(function ($size) {
        return $size->getName();
    }, $sizes);
}

function storeSize(Request $request, PDO $db): Size {
    $size = $request->post('name');
    $size = new Size($size);
    $size->upload($db);
    return $size;
}

function parseBrands(array $brands): array {
    return array_map(function ($brand) {
        return $brand->getName();
    }, $brands);
}

function storeBrand(Request $request, PDO $db): Brand {
    $brand = $request->post('name');
    $brand = new Brand($brand);
    $brand->upload($db);
    return $brand;
}

