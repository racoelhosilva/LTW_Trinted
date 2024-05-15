<?php
declare(strict_types=1);

include_once(__DIR__ . '/utils.php');
include_once(__DIR__ . '/../db/classes/Post.class.php');
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/../db/classes/Size.class.php');
include_once(__DIR__ . '/../db/classes/Condition.class.php');
include_once(__DIR__ . '/../db/classes/Category.class.php');

$filterTypes = ['category', 'size', 'condition'];

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
            ORDER BY publishDatetime;';
    
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    
    $posts = [];
    foreach ($stmt->fetchAll() as $row) {
        $post = Post::getPostByID($db, $row['id']);
        $posts[] = parsePost($post, $db);
    }
    return $posts;
}

function getFilters(): array {
    global $filterTypes;
    $filters = [];
    foreach ($filterTypes as $filterType) {
        $filters[$filterType] = $_GET[$filterType] ?? [];
    }
    return $filters;
}

function matchesFilters(array $post, array $filters): bool {
    global $filterTypes;

    foreach ($filterTypes as $filterType) {
        if ($filters[$filterType] != [] && !in_array($post[$filterType], $filters[$filterType])) {
            return false;
        }
    }

    return true;
}

function filterResults(PDO $db, array $posts, array $filters): array {
    return array_filter($posts, function($post) use ($filters) {
        return matchesFilters($post, $filters);
    });
}

function limitResults(array $posts, int $start, int $limit): array {
    return array_slice($posts, $start, $limit);
}

// const filterTypes = ['condition', 'category', 'size'];

// function matchesFilters(post: {[key: string]: string}, searchFilters: {[key: string]: Array<string>}): boolean {
//     return filterTypes.every(filterType => {
//         if (searchFilters[filterType].length === 0 || searchFilters[filterType].includes(post[filterType])) {
//             return true;
//         }
//     });
// }

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!paramsExist('GET', ['query']))
    die(['success' => false, 'error' => 'Missing fields']);

try {
    $query = validate($_GET['query']);
    $start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : PHP_INT_MAX;

    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $filters = getFilters();
    $posts = searchPosts($db, $query, $start, $limit);
    $posts = filterResults($db, $posts, $filters);
    $posts = limitResults($posts, $start, $limit);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'posts' => $posts]));

