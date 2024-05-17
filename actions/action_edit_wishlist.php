<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_SESSION['user']['id']))
    die(json_encode(['success' => false, 'error' => 'User not logged in']));

if (!isset($_POST['product_id']) || !isset($_POST['remove']))
    die(json_encode(['success' => false, 'error' => 'Missing fields']));

$product_id = sanitize($_POST['product_id']);
$remove = $_POST['remove'];

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $product_id = (int)$product_id;
    $remove = $remove === 'true';
    $user = User::getUserByID($db, (int)$_SESSION['user']['id']);

    if (!$remove)
        $user->addToWishlist($db, $product_id);
    else
        $user->removeFromWishlist($db, $product_id);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'remove' => gettype($remove)]));