<?php
declare(strict_types=1);

include_once(__DIR__ . '/../framework/Request.php');

function sanitize(string $data): string {
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

function getUrl(Image $img): string {
    return $img->url;
}

function dateFormat(int $datetime): string {
    $timestamp = new DateTime(date('Y-m-d h:i:s', $datetime));
    $current = new DateTime(date('Y-m-d h:i:s'));
    $timediff = $current->diff($timestamp);

    if ($timediff->y > 0) {
        return $timediff->y === 1 ? $timediff->y . " year" : $timediff->y . " years";
    } elseif ($timediff->m > 0) {
        return $timediff->m === 1 ? $timediff->m . " month" : $timediff->m . " months";
    } elseif ($timediff->d > 0) {
        return $timediff->d === 1 ? $timediff->d . " day" : $timediff->d . " days";
    } elseif ($timediff->h > 0) {
        return $timediff->h === 1 ? $timediff->h . " hour" : $timediff->h . " hours";
    } elseif ($timediff->i > 0) {
        return $timediff->i === 1 ? $timediff->i . " minute" : $timediff->i . " minutes";
    } else {
        return "Just now";
    }
}

function parseProduct(PDO $db, Product $product): array {
    return [
        'id' => $product->id,
        'title' => $product->title,
        'description' => $product->description,
        'price' => $product->price,
        'publishDatetime' => $product->publishDateTime,
        'seller' => $product->seller->id,
        'username' => $product->seller->name,
        'category' => $product->category->name,
        'size' => $product->condition->name,
        'condition' => $product->condition->name,
        'images' => array_map('getUrl', $product->getAllImages($db)),
        'inWishlist' => isset($_SESSION['user']) ? User::getUserByID($db, $_SESSION['user']['id'])->isInWishlist($db, (int)$product->id) : false
    ];
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
