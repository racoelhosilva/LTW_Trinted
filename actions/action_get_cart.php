<?php
declare(strict_types=1);

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/../db/utils.php';

$request = new Request();
$db = getDatabaseConnection();

header('Content-Type: application/json');

sendOk(['cart' => parseProducts(getCart($request, $db), $request, $db)]);
