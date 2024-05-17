<?php
declare(strict_types=1);

include_once(__DIR__ . '/../db/classes/Product.class.php');
include_once(__DIR__ . '/../db/classes/Payment.class.php');
include_once(__DIR__ . '/../framework/Session.class.php');
include_once(__DIR__ . '/utils.php');

function getSubtotal(array $cart): float {
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price;
    }
    return $subtotal;
}

function parsePayment(array $cart): Payment {
    $firstName = sanitize($_POST['first-name']);
    $lastName = sanitize($_POST['last-name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);
    $zipCode = sanitize($_POST['zip']);
    $town = sanitize($_POST['town']);
    $country = sanitize($_POST['country']);
    $shipping = sanitize($_POST['shipping']);
    $paymentDatetime = time();
    return new Payment(getSubtotal($cart), $shipping, $firstName, $lastName, $email, $phone, $address, $zipCode, $town, $country, $paymentDatetime);
}

function submitPaymentToDb(Payment $payment, PDO $db, array $cart): void {
    $payment->upload($db);
    foreach ($cart as $item) {
        $product = Product::getProductByID($db, (int)$item->id);
        $product->associateToPayment($db, (int)$payment->id);
    }
}


header('Content-Type: application/json');

if (!isset($_POST['first-name']) || !isset($_POST['last-name']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['address']) || !isset($_POST['zip']) || !isset($_POST['town']) || !isset($_POST['country']) || !isset($_POST['shipping'])) {
    returnMissingFields();
}

$request = new Request();
$session = $request->getSession();

if (!$request->verifyCsrf()) {
    returnCrsfMismatch();
}
if (!userLoggedIn($request)) {
    returnUserNotLoggedIn();
}

$cart = getCookie('cart') ?? [];
if ($cart == []) {
    die(json_encode(array('success' => false, 'error' => 'Shopping cart empty')));
}

try {
    $payment = parsePayment($cart);

    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    submitPaymentToDb($payment, $db, $cart);
    putCookie('cart', []);
} catch (Exception $e) {
    die(json_encode(array('success' => false, 'error' => $e->getMessage())));
}
die(json_encode(array('success' => true)));
