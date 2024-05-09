<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');

if (!isset($_POST["post_id"]))
    exit();

session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$post_id = validate($_POST["post_id"]);
$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
$post = null;

$post = Post::getPostByID($db, (int)$post_id);

if (isset($post))
    $_SESSION['items'][] = $post;

echo json_encode(array("success" => isset($post), "post_id" => $post_id));