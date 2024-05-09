<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');

session_start();

function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo json_encode(array('cart' => $_SESSION['cart']));
