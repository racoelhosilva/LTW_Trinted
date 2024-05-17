<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

function parseWishlist(PDO $db, array $wishlist): array {
    return array_map(function ($product) use ($db) {
        return parseProduct($db, $product);
    }, $wishlist);
}

session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_SESSION['user']['id']))
    die(json_encode(['success' => false, 'error' => 'User not logged in']));

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $user = User::getUserByID($db, (int)$_SESSION['user']['id']);
    $wishlist = parseWishlist($db, $user->getWishlist($db));
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'wishlist' => $wishlist]));