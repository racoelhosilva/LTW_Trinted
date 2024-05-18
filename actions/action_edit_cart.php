<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
include_once(__DIR__ . '/utils.php');

function setCart(array $cart): void {
    putCookie('cart', $cart);
}

function getCart(): array {
    return getCookie('cart') ?? [];
}

function addToCart(Product $product, PDO $db): bool {
    $cart = getCart();
    foreach ($cart as $cart_item) {
        if ($cart_item->getId() == $product->getId()) {
            return false;
        }
    }

    $cart[] = parseProduct($db, $product);
    setCart($cart);
    return true;
}

function removeFromCart(Product $product): bool {
    $cart = getCart();
    foreach ($cart as $index => $cart_item) {
        if ($cart_item->getId() == $product->getId()) {
            array_splice($cart, $index, 1);
            setCart($cart);
            return true;
        }
    }

    return false;
}

if (!isset($_POST['product_id']) || !in_array($_POST['remove'], [true, false]))
    sendMissingFields();

session_start();

$product_id = sanitize($_POST['product_id']);
$remove = sanitize($_POST['remove']) === 'true';
$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $product_id = (int)$product_id;
    $product = Product::getProductByID($db, (int)$product_id);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}

$success = isset($product) && ((!$remove && addToCart($product, $db)) || ($remove && removeFromCart($product)));
echo json_encode(array('success' => $success));
