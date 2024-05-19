<?php
declare(strict_types=1);

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';

$request = new Request();

sendOk(['cart' => getCart($request)]);
