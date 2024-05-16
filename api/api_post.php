<?php
declare(strict_types=1);

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../db/classes/Post.class.php';
require_once __DIR__ . '/../framework/Request.php';
require_once __DIR__ . '/utils.php';


function parsePost(Post $post, PDO $db): array {
    return array(
        'id' => $post->id,
        'title' => $post->title,
        'description' => $post->description,
        'price' => $post->price,
        'publishDatetime' => $post->publishDateTime,
        'sellerId' => $post->seller->id,
        'seller' => $_SERVER['HTTP_HOST'] . '/api/user/' . $post->seller->id,
        'username' => $post->seller->name,
        'category' => $post->item->category->category,
        'size' => $post->item->size->size,
        'condition' => $post->item->condition->condition,
        'images' => $_SERVER['HTTP_HOST'] . '/api/post/' . $post->id . '/images',
        'links' => [
            [
                'rel' => 'self',
                'href' => $_SERVER['HTTP_HOST'] . '/api/post/' . $post->id,
                'action' => 'GET'
            ]
        ]
    );
}

function parsePosts(array $posts, PDO $db): array {
    return array_map(function ($post) use ($db) {
        return parsePost($post, $db);
    }, $posts);
}


$db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/../db/database.db');
$request = new Request();
$method = getMethod($request);
$endpoint = getEndpoint($request);

header('Content-Type: application/json');

switch ($method) {
    case 'GET':
        if ($endpoint === '/api/post') {
            die(json_encode(parsePosts(Post::getAllPosts($db), $db)));
        } elseif (preg_match('/^\/api\/post\/(\d+)$/', $endpoint, $matches)) {
            $post = Post::getPostByID($db, (int)$matches[1]);
            die(json_encode(['success' => true, 'post' => $post ? parsePost($post, $db) : null]));
        }
        break;
}
