<?php

if (!isset($_GET["post_id"]))
    exit();

session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$post_id = validate($_GET["post_id"]);

$db = new PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
$post = Post::getPostByID($db, $post_id);

if (isset($post))
    $_SESSION['items'][] = $post;

echo json_encode(array("success" => isset($post)));