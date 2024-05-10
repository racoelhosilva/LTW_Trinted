<?php

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

function parsePayment(): Payment {
    $firstName = validate($_POST['firstName']);
    $lastName = validate($_POST['lastName']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $address = validate($_POST['address']);
    $zipCode = validate($_POST['zipCode']);
    $city = validate($_POST['city']);
    $country = validate($_POST['country']);
    $shipping = validate($_POST['shipping']);
    $paymentDatetime = time();
    return new Payment(getSubtotal(json_decode($_COOKIE['cart'])), $shipping, $firstName, $lastName, $email, $phone, $address, $zipCode, $city, $country, $paymentDatetime);
}

function submitPaymentToDb(Payment $payment, PDO $db): void {
    $payment->upload($db);
    foreach ($_COOKIE['cart'] as $item) {
        $post = Post::getPostByID($db, $item->id);
        $post->associateToPayment($db, $payment->id);
        $post->upload($db);
    }
}

session_start();

if (!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['zipCode']) || !isset($_POST['city']) || !isset($_POST['country']) || !isset($_POST['shipping'])) {
    die(json_encode(array('success' => false, 'error' => 'Missing fields')));
}

$cart = json_decode($_COOKIE['cart'] ?? '[]');
if ($cart == []) {
    die(json_encode(array('success' => false, 'error' => 'Shopping cart empty')));
}

try {
    $payment = parsePayment();
} catch (PDOException $e) {
    die(json_encode(array('success' => false, 'error' => 'Error while parsing payment')));
}

try {
    submitPaymentToDb($payment, $db);
} catch (PDOException $e) {
    die(json_encode(array('success' => false, 'error' => 'Database error')));
}

die(json_encode(array('success' => true)));
