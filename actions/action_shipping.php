<?php

include_once(__DIR__ . '/utils.php');

session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_POST['address']) || !isset($_POST['zip']) || !isset($_POST['town']) || !isset($_POST['country']))
    die(json_encode(['success' => false, 'error' => 'Missing fields']));

$town = validate($_POST['town']);
$country = validate($_POST['country']);

srand(crc32($town . $country));
die(['success' => true, 'shipping' => rand(1, 200) / 20 - 0.01]);