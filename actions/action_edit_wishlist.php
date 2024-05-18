<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';

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
    $product = Product::getProductById($db, (int)$product_id);
    if ($product === null)
        die(json_encode(['success' => false, 'error' => 'Product not found']));
    
    $remove = $remove === 'true';
    $user = User::getUserByID($db, (int)$_SESSION['user']['id']);

    if (!$remove)
        $user->addToWishlist($db, $product);
    else
        $user->removeFromWishlist($db, $product);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'remove' => gettype($remove)]));