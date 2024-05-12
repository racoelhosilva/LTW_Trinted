<?php
declare(strict_types=1);

include_once(__DIR__ . '/utils.php');
include_once(__DIR__ . '/../db/classes/Post.class.php');
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/../db/classes/Size.class.php');
include_once(__DIR__ . '/../db/classes/Condition.class.php');
include_once(__DIR__ . '/../db/classes/Category.class.php');

function searchPosts(PDO $db, string $search): array {
    $query = '
        SELECT id
        FROM Post
        WHERE title LIKE :search
            OR EXISTS (SELECT *
            FROM Item
            WHERE Item.id = Post.item
            AND ((category LIKE :search OR size LIKE :search OR condition LIKE :search
            OR EXISTS (SELECT *
                FROM ItemBrand
                WHERE ItemBrand.item = Item.id AND brand LIKE :search)
            OR EXISTS (SELECT *
                FROM User
                WHERE User.id = Post.seller AND name LIKE :search))))';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    
    $posts = [];
    foreach ($stmt->fetchAll() as $row) {
        $post = Post::getPostByID($db, $row['id']);
        $posts[] = [
            'id' => $post->id,
            'title' => $post->title,
            'description' => $post->description,
            'price' => $post->price,
            'publishDatetime' => $post->publishDateTime,
            'seller' => $post->seller,
            'username' => $post->seller->name,
            'category' => $post->item->category,
            'size' => $post->item->size,
            'condition' => $post->item->condition,
            'images' => array_map('getUrl', $post->getAllImages($db))
        ];
    }
    return $posts;
}

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_GET['search']))
    die(['success' => false, 'error' => 'Missing fields']);

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $posts = searchPosts($db, validate($_GET['search']));
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'posts' => $posts]));

