<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/utils.php');

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_SESSION['user_id']))
    die(json_encode(['success' => false, 'error' => 'User not logged in']));

if (!isset($_POST['post_id']) || !isset($_POST['remove']))
    die(json_encode(['success' => false, 'error' => 'Missing fields']));

$post_id = validate($_POST['post_id']);
$remove = $_POST['remove'];

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $post_id = (int)$post_id;
    $user = User::getUserByID($db, (int)$_SESSION['user_id']);
    if (!$remove)
        $user->addToWishlist($db, $post_id);
    else
        $user->removeFromWishlist($db, $post_id);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true]));