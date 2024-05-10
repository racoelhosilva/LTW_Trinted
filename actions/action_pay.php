<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Post.class.php');
include_once(__DIR__ . '/../db/classes/Payment.class.php');

function validate(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getSubtotal(array $cart): float {
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price;
    }
    return $subtotal;
}

function parsePayment(array $cart): Payment {
    $firstName = validate($_POST['first-name']);
    $lastName = validate($_POST['last-name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $address = validate($_POST['address']);
    $zipCode = validate($_POST['zip']);
    $town = validate($_POST['town']);
    $country = validate($_POST['country']);
    $shipping = validate($_POST['shipping']);
    $paymentDatetime = time();
    return new Payment(getSubtotal($cart), $shipping, $firstName, $lastName, $email, $phone, $address, $zipCode, $town, $country, $paymentDatetime);
}

function submitPaymentToDb(Payment $payment, PDO $db, array $cart): void {
    $payment->upload($db);
    foreach ($cart as $item) {
        $post = Post::getPostByID($db, (int)$item->id);
        $post->associateToPayment($db, (int)$payment->id);
    }
}

session_start();

if (!isset($_POST['first-name']) || !isset($_POST['last-name']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['zip']) || !isset($_POST['town']) || !isset($_POST['country']) || !isset($_POST['shipping'])) {
    die(json_encode(array('success' => false, 'error' => 'Missing fields')));
}

if (!isset($_SESSION['user_id'])) {
    die(json_encode(array('success' => false, 'error' => 'User not logged in')));
}

$cart = json_decode($_COOKIE['cart'] ?? '[]');
if ($cart == []) {
    die(json_encode(array('success' => false, 'error' => 'Shopping cart empty')));
}

try {
    $payment = parsePayment($cart);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    submitPaymentToDb($payment, $db, $cart);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}

setcookie('cart', '[]', ['samesite' => 'strict', 'expires' => 0, 'path' => '/']);
header('Location: /');
