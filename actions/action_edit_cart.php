<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');

function validate(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getCart(): array {
    return json_decode($_COOKIE['cart'] ?? '[]');
}

function setCart(array $cart): void {
    setcookie('cart', json_encode($cart), ['samesite' => 'strict', 'expires' => 0, 'path' => '/']);
}

function addToCart(int $post_id): bool {
    $cart = getCart();
    foreach ($cart as $index => $cart_post_id) {
        if ($cart_post_id == $post_id) {
            return false;
        }
    }

    $cart[] = $post_id;
    setCart($cart);
    return true;
}

function removeFromCart(int $post_id): bool {
    $cart = getCart();
    foreach ($cart as $index => $cart_post_id) {
        if ($cart_post_id == $post_id) {
            array_splice($cart, $index, 1);
            setCart($cart);
            return true;
        }
    }

    return false;
}

if (!isset($_POST['post_id']) || !in_array($_POST['remove'], [true, false]))
    die("Invalid request");

session_start();

$post_id = validate($_POST['post_id']);
$remove = validate($_POST['remove']);
$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $post_id = (int)$post_id;
    $post = Post::getPostByID($db, (int)$post_id);
} catch (Exception $e) {
    die("Error fetching post with id " . $post_id);
}

$success = isset($post) && (($remove && addToCart($post_id)) || ($remove && removeFromCart($post_id)));
echo json_encode(array('success' => $success));
