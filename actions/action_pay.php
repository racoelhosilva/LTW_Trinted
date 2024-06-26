<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/utils.php';

function getSubtotal(array $cart): float {
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->getPrice();
    }
    return $subtotal;
}

function parsePayment(array $cart, User $buyer, Request $request): Payment {
    $firstName = $request->post('first-name');
    $lastName = $request->post('last-name');
    $email = $request->post('email');
    $phone = $request->post('phone');
    $address = $request->post('address');
    $zipCode = $request->post('zip');
    $town = $request->post('town');
    $country = $request->post('country');
    $shipping = $request->post('shipping');
    $paymentDatetime = time();
    return new Payment(getSubtotal($cart), $shipping, $firstName, $lastName, $email, $phone, $address, $zipCode, $town, $country, $paymentDatetime, $buyer);
}

function submitPaymentToDb(Payment $payment, PDO $db, array $cart): void {
    $payment->upload($db);
    foreach ($cart as $item) {
        $product = Product::getProductByID($db, $item->getId());
        $product->associateToPayment($db, $payment);
    }
}

$request = new Request();
$db = getDatabaseConnection();

header('Content-Type: application/json');

if ($request->getMethod() !== 'POST')
    sendMethodNotAllowed();
if (!$request->verifyCsrf())
    sendCrsfMismatch();
if (!userLoggedIn($request)) 
    sendUserNotLoggedIn();


if (!$request->paramsExist(['first-name', 'last-name', 'email', 'phone', 'address', 'zip', 'town', 'country', 'shipping'])) {
    sendMissingFields();
}
if (!filter_var($request->post('email'), FILTER_VALIDATE_EMAIL))
    sendBadRequest('Invalid email address');
if (!filter_var($request->post('phone'), FILTER_VALIDATE_INT))
    sendBadRequest('Invalid phone number');
if (!preg_match('/^[0-9]{4}-[0-9]{3}$/', $request->post('zip')))
    sendBadRequest('Invalid zip code');
if (!filter_var($request->post('shipping'), FILTER_VALIDATE_FLOAT))
    sendBadRequest('Invalid shipping value');

$cart = getCart($request, $db);
if ($cart == [])
    sendUnprocessableEntity('Shopping cart empty');

try {
    $sessionUser = getSessionUser($request);
    $buyer = User::getUserByID($db, (int)$sessionUser['id']);

    $payment = parsePayment($cart, $buyer, $request);
    submitPaymentToDb($payment, $db, $cart);
    setCart([], $request);
} catch (Exception $e) {
    error_log($e->getMessage());
    sendInternalServerError();
}

sendOk(['payment' => $payment]);
