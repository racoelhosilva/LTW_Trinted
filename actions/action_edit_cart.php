<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/utils.php';

function addToCart(Product $product, Request $request, PDO $db): void {
    $cart = getCart($request, $db);
    foreach ($cart as $cartProduct) {
        if ($cartProduct->getId() == $product->getId()) {
            return;
        }
    }

    $cart[] = $product;
    setCart($cart, $request);
}

function removeFromCart(Product $product, Request $request, PDO $db): void {
    $cart = getCart($request, $db);
    foreach ($cart as $index => $cartProduct) {
        if ($cartProduct->getId() == $product->getId()) {
            array_splice($cart, $index, 1);
            setCart($cart, $request);
            return;
        }
    }
}

$request = new Request();
$db = getDatabaseConnection();

header('Content-Type: application/json');

if (!$request->paramsExist(['product-id', 'remove']))
    sendMissingFields();
if (!in_array($request->post('remove'), ['true', 'false']))
    sendBadRequest('Invalid remove flag');

if (!$request->verifyCsrf())
    sendCrsfMismatch();

$productId = $request->post('product-id');
$remove = $request->post('remove') === 'true';

try {
    $product = Product::getProductByID($db, (int)$productId);

    if (!$remove)
        addToCart($product, $request, $db);
    else
        removeFromCart($product, $request, $db);
} catch (Exception $e) {
    error_log($e->getMessage());
    sendInternalServerError();
}

sendOk(['success' => true]);

