<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');

if (!isset($_POST['post_id']) || !in_array($_POST['remove'], [true, false]))
    die("Invalid request");

session_start();

function validate(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function addToCart(int $post_id): bool {
    foreach ($_SESSION['cart'] as $index => $cart_post_id) {
        if ($cart_post_id == $post_id) {
            return false;
        }
    }

    $_SESSION['cart'][] = $post_id;
    return true;
}

function removeFromCart(int $post_id): bool {
    foreach ($_SESSION['cart'] as $index => $cart_post_id) {
        if ($cart_post_id == $post_id) {
            array_splice($_SESSION['cart'], $index, 1);
            return true;
        }
    }

    return false;
}

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
