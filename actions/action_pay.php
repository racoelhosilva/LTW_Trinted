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

function parsePayment(array $cart, Request $request): Payment {
    $firstName = sanitize($request->post('first-name'));
    $lastName = sanitize($request->post('last-name'));
    $email = sanitize($request->post('email'));
    $phone = sanitize($request->post('phone'));
    $address = sanitize($request->post('address'));
    $zipCode = sanitize($request->post('zip'));
    $town = sanitize($request->post('town'));
    $country = sanitize($request->post('country'));
    $shipping = sanitize($request->post('shipping'));
    $paymentDatetime = time();
    return new Payment(getSubtotal($cart), $shipping, $firstName, $lastName, $email, $phone, $address, $zipCode, $town, $country, $paymentDatetime);
}

function submitPaymentToDb(Payment $payment, PDO $db, array $cart): void {
    $payment->upload($db);
    foreach ($cart as $item) {
        $product = Product::getProductByID($db, (int)$item->getId());
        $product->associateToPayment($db, $payment);
    }
}

$request = new Request();
$db = getDatabaseConnection();

header('Content-Type: application/json');

if (!$request->getMethod() !== 'POST') {
    sendMethodNotAllowed();
}
if (!$request->paramsExist(['first-name', 'last-name', 'email', 'phone', 'address', 'zip', 'town', 'country', 'shipping'])) {
    sendMissingFields();
}

if (!$request->verifyCsrf()) {
    sendCrsfMismatch();
}
if (!userLoggedIn($request)) {
    sendUserNotLoggedIn();
}

$cart = $request->cookie('cart', []);
if ($cart == [])
    sendUnprocessableEntity('Shopping cart empty');

try {
    $payment = parsePayment($cart, $request);
    submitPaymentToDb($payment, $db, $cart);
    $request->setCookie('cart', []);
} catch (Exception $e) {
    error_log($e->getMessage());
    sendInternalServerError();
}

sendOk(['payment' => $payment]);
