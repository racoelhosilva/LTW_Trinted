<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Request.php';

function userLoggedIn(Request $request): bool {
    return $request->session('user') !== null;
}


function sendOk(mixed $data): void {
    http_response_code(200);
    die(json_encode(['success' => true, ...$data]));
}

function sendCreated(mixed $data): void {
    http_response_code(201);
    die(json_encode(['success' => true, ...$data]));
}

function sendBadRequest(string $message): void {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => $message]));
}

function sendUnauthorized(string $message): void {
    http_response_code(401);
    die(json_encode(['success' => false, 'error' => $message]));
}

function sendForbidden(string $message): void {
    http_response_code(403);
    die(json_encode(['success' => false, 'error' => $message]));
}

function sendNotFound(): void {
    http_response_code(404);
    die(json_encode(['success' => false, 'error' => 'Resource not found']));
}

function sendMethodNotAllowed(): void {
    http_response_code(405);
    die(json_encode(['success' => false, 'error' => 'Method not allowed']));
}

function sendInternalServerError(): void {
    http_response_code(500);
    die(json_encode(['success' => false, 'error' => 'Internal server error']));
}


function sendUserNotLoggedIn(): void {
    sendUnauthorized('User not logged in');
}

function sendCrsfMismatch(): void {
    sendForbidden('CSRF token missing or invalid');
}

function sendMissingFields(): void {
    sendBadRequest('One or more fields missing');
}

function sendInvalidFields(): void {
    sendBadRequest('One or more fields invalid');
}

function getSessionUser(Request $request): array {
    return $request->session('user');
}