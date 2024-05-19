<?php

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/../db/utils.php';

$request = new Request();
$db = getDatabaseConnection();

if ($request->getMethod() !== 'GET')
    sendMethodNotAllowed();

if (!$request->paramsExist(['address', 'zip', 'town', 'country']))
    sendMissingFields();

srand(crc32($request->get('address') . $request->get('country')));

sendOk(['shipping' => mt_rand(1, 40) / 2 - 0.01]);
