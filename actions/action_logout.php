<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';

$request = new Request();
$request->getSession()->destroy();

header("Location: /");
exit;
