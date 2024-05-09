<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');

if (!isset($_POST['post_id']))
    exit();

session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$post_id = validate($_POST['post_id']);
$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');

try {
    $post = Post::getPostByID($db, (int)$post_id);
} catch (Exception $e) {
    $post = null;
}

if (isset($post))
    $_SESSION['cart'][] = $post->id;

echo json_encode(array('success' => isset($post)));