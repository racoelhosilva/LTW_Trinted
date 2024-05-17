<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');
include_once(__DIR__ . '/utils.php');

function setCart(array $cart): void {
    putCookie('cart', $cart);
}

function getCart(): array {
    return getCookie('cart') ?? [];
}

function addToCart(Post $post, PDO $db): bool {
    $cart = getCart();
    foreach ($cart as $cart_item) {
        if ($cart_item->id == $post->id) {
            return false;
        }
    }

    $cart[] = parseProduct($db, $post);
    setCart($cart);
    return true;
}

function removeFromCart(Post $post): bool {
    $cart = getCart();
    foreach ($cart as $index => $cart_item) {
        if ($cart_item->id == $post->id) {
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
$remove = validate($_POST['remove']) === 'true';
$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $post_id = (int)$post_id;
    $post = Post::getPostByID($db, (int)$post_id);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}

$success = isset($post) && ((!$remove && addToCart($post, $db)) || ($remove && removeFromCart($post)));
echo json_encode(array('success' => $success));
