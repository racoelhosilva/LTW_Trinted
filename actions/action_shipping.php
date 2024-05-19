<?php

require_once __DIR__ . '/utils.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_GET['address']) || !isset($_GET['zip']) || !isset($_GET['town']) || !isset($_GET['country']))
    die(json_encode(['success' => false, 'error' => 'Missing fields']));

$town = sanitize($_GET['town']);
$country = sanitize($_GET['country']);

srand(crc32($town . $country));
die(json_encode(['success' => true, 'shipping' => mt_rand(1, 40) / 2 - 0.01]));