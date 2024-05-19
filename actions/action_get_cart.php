<?php
declare(strict_types=1);

require_once __DIR__ . '/utils.php';

session_start();

echo json_encode(array('success' => true, 'cart' => getCookie('cart') ?? []));
