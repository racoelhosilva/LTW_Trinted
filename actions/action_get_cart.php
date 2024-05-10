<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');
include_once(__DIR__ . '/utils.php');

session_start();

echo json_encode(array('success' => true, 'cart' => getCookie('cart') ?? []));
