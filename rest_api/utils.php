<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Request.php';

function getMethod(Request $request): string {
    return $request->header('REQUEST_METHOD');
}

function getEndpoint(Request $request): string {
    return $request->header('PATH_INFO');
}

function userLoggedIn(Request $request): bool {
    return $request->getSession()->get('user') !== null;
}

function returnUserNotLoggedIn(): void {
    die(json_encode(array('success' => false, 'error' => 'User not logged in')));
}

function returnCrsfMismatch(): void {
    die(json_encode(array('success' => false, 'error' => 'CSRF token missing or invalid')));
}

function returnMissingFields(): void {
    die(json_encode(array('success' => false, 'error' => 'Missing fields')));
}

function getSessionUser(Request $request): array {
    return $request->getSession()->get('user');
}