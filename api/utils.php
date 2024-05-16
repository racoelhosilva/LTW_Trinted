<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Request.php';

function getMethod(Request $request): string {
    return $request->header('REQUEST_METHOD');
}

function getEndpoint(Request $request): string {
    return $request->header('PATH_INFO');
}
