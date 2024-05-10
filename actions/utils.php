<?php
declare(strict_types=1);

function validate(string $data): string {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function putCookie(string $name, array $data): void {
    setcookie($name, json_encode($data), ['samesite' => 'strict', 'expires' => 0, 'path' => '/']);
}

function getCookie(string $name): mixed {
    return isset($_COOKIE[$name]) ? json_decode($_COOKIE[$name]) : null;
}
