<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Autoload.php';

function getUrl(Image $img): string {
    return $img->getUrl();
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

function setCart(array $cart, Request $request): void {
    $request->setCookie('cart', array_map(function ($item) {
        return $item->getId();
    }, $cart));
}

function getCart(Request $request, PDO $db): array {
    $cart = array_map(function ($id) use ($db) {
        return Product::getProductByID($db, (int)$id);
    }, $request->cookie('cart', []));
    $cart = array_filter($cart, function ($item) {
        return isset($item);
    });
    return $cart;
}
