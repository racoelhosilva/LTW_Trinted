<?php
declare(strict_types=1);

include_once(__DIR__ . '/../framework/Request.php');

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

function parseProduct(PDO $db, Post $post): array {
    return [
        'id' => $post->id,
        'title' => $post->title,
        'description' => $post->description,
        'price' => $post->price,
        'publishDatetime' => $post->publishDateTime,
        'seller' => $post->seller->id,
        'username' => $post->seller->name,
        'category' => $post->item->category->category,
        'size' => $post->item->size->size,
        'condition' => $post->item->condition->condition,
        'images' => array_map('getUrl', $post->getAllImages($db)),
        'inWishlist' => isset($_SESSION['user_id']) ? User::getUserByID($db, $_SESSION['user_id'])->isInWishlist($db, (int)$post->id) : false
    ];
}

function paramsExist(string $method, array $params): bool {
    foreach ($params as $param) {
        switch ($method) {
            case 'GET':
                if (!isset($_GET[$param]))
                    return false;
                break;
            case 'POST':
                if (!isset($_POST[$param]))
                    return false;
                break;
        }
    }
    return true;
}

function userLoggedIn(Request $request): bool {
    return $request->getSession()->get('user_id') !== null;
}
