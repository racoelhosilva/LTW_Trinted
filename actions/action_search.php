<?php
declare(strict_types=1);

include_once(__DIR__ . '/utils.php');
include_once(__DIR__ . '/../db/classes/Post.class.php');
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/../db/classes/Size.class.php');
include_once(__DIR__ . '/../db/classes/Condition.class.php');
include_once(__DIR__ . '/../db/classes/Category.class.php');

function searchPosts(PDO $db, string $search, int $start, int $limit): array {
    $query = '
        SELECT id
        FROM Post
        WHERE title LIKE :search
        OR description LIKE :search
        OR price LIKE :search
        OR EXISTS (SELECT *
            FROM Item
            WHERE Item.id = Post.item
            AND ((category LIKE :search OR size LIKE :search OR condition LIKE :search
            OR EXISTS (SELECT *
                FROM ItemBrand
                WHERE ItemBrand.item = Item.id AND brand LIKE :search)
            OR EXISTS (SELECT *
                FROM User
                WHERE User.id = Post.seller AND name LIKE :search))))
            ORDER BY publishDatetime
            LIMIT :limit OFFSET :start';
    
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->bindValue(':limit', $limit);
    $stmt->bindValue(':start', $start);
    $stmt->execute();
    
    $posts = [];
    foreach ($stmt->fetchAll() as $row) {
        $post = Post::getPostByID($db, $row['id']);
        $posts[] = parsePost($post, $db);
    }
    return $posts;
}

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!paramsExist('GET', ['query']))
    die(['success' => false, 'error' => 'Missing fields']);

$query = validate($_GET['query']);
$start = $_GET['start'] ?? 0;
$limit = $_GET['limit'] ?? PHP_INT_MAX;

try {
    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $posts = searchPosts($db, $query, $start, $limit);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'posts' => $posts]));

