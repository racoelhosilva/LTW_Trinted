<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/utils.php';

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
        $product = Product::getProductByID($db, (int)$item->getId());
        $product->associateToPayment($db, (int)$payment->getId());
    }
}

$request = new Request();
$db = getDatabaseConnection();

header('Content-Type: application/json');

if (!$request->getMethod() != 'POST') {
    sendMethodNotAllowed();
}

if (!$request->paramsExist(['first-name', 'last-name', 'email', 'phone', 'address', 'zip', 'town', 'country', 'shipping'])) {
    sendMissingFields();
}

$request = new Request();
$session = $request->getSession();

if (!$request->verifyCsrf()) {
    sendCrsfMismatch();
}
if (!userLoggedIn($request)) {
    sendUserNotLoggedIn();
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
