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

function getUrl(Image $img): string {
    return $img->url;
}

function parsePost(Post $post, PDO $db): array {
    $parsedPost = array(
        'id' => $post->id,
        'title' => $post->title,
        'price' => $post->price,
        'size' => $post->item->size->size,
        'condition' => $post->item->condition->condition,
        'seller' => $post->seller->id,
        'description' => $post->description,
        'images' => array_map('getUrl', $post->getAllImages($db))
    );
    return $parsedPost;
}

function addToCart(Post $post, PDO $db): bool {
    $cart = getCart();
    foreach ($cart as $cart_item) {
        if ($cart_item->id == $post->id) {
            return false;
        }
    }

    $cart[] = parsePost($post, $db);
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
$remove = validate($_POST['remove']);
$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $post_id = (int)$post_id;
    $post = Post::getPostByID($db, (int)$post_id);
} catch (Exception $e) {
    die("Error fetching post with id " . $post_id);
}

$success = isset($post) && (($remove && addToCart($post, $db)) || ($remove && removeFromCart($post)));
echo json_encode(array('success' => $success));
