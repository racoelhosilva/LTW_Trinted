<?php
declare(strict_types=1);

require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/../db/classes/Post.class.php';
require_once __DIR__ . '/../framework/Request.php';
require_once __DIR__ . '/utils.php';


function parseProduct(Post $product, PDO $db): array {
    return array(
        'id' => $product->id,
        'title' => $product->title,
        'description' => $product->description,
        'price' => $product->price,
        'publishDatetime' => $product->publishDateTime,
        'category' => $product->item->category->category,
        'size' => $product->item->size->size,
        'condition' => $product->item->condition->condition,
        'images' => $_SERVER['HTTP_HOST'] . '/api/post/' . $product->id . '/images',
        'links' => [
            [
                'rel' => 'self',
                'href' => $_SERVER['HTTP_HOST'] . '/api/post/' . $product->id,
            ],
            [
                'rel' => 'seller',
                'href' => $_SERVER['HTTP_HOST'] . '/api/user/' . $product->seller->id,
            ]
        ]
    );
}

function parseProducts(array $product, PDO $db): array {
    return array_map(function ($post) use ($db) {
        return parseProduct($post, $db);
    }, $product);
}


$db = getDatabaseConnection();
$request = new Request();
$method = getMethod($request);
$endpoint = getEndpoint($request);

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if ($endpoint === '/api/product') {
            die(json_encode(parseProducts(Post::getAllPosts($db), $db)));
        } elseif (preg_match('/^\/api\/product\/(\d+)$/', $endpoint, $matches)) {
            $post = Post::getPostByID($db, (int)$matches[1]);
            die(json_encode(['success' => true, 'post' => $post ? parseProduct($post, $db) : null]));
        }
        break;

    
}
