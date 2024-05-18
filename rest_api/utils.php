<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Request.php';

function userLoggedIn(Request $request): bool {
    return $request->getSession()->get('user') !== null;
}


function sendOk(mixed $data): void {
    http_response_code(200);
    die(json_encode(['success' => true, 'data' => $data]));
}

function sendCreated(mixed $data): void {
    http_response_code(201);
    die(json_encode(['success' => true, 'data' => $data]));
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


function returnUserNotLoggedIn(): void {
    sendUnauthorized('User not logged in');
}

function returnCrsfMismatch(): void {
    sendForbidden('CSRF token missing or invalid');
}

function returnMissingFields(): void {
    sendBadRequest('Missing fields');
}

function getSessionUser(Request $request): array {
    return $request->getSession()->get('user');
}