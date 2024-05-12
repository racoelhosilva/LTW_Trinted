<?php
declare(strict_types=1);

include_once(__DIR__ . '/utils.php');
include_once(__DIR__ . '/db/Post.class.php');
include_once(__DIR__ . '/db/User.class.php');

function parseFilters(): array {
    $filters = [
        'category' => [],
        'size' => [],
        'condition' => [],
    ];
    foreach ($_GET['filters'] as $filter) {
        $filter_info = explode('-', $_GET[$filter]);
        if (isset($filter_info[0])) {
            $filters[$filter_info[0]][] = validate($filter_info[1]);
        }
    }
    foreach ($filters as $type => $_) {
        if (empty($filters[$type])) {
            $filters[$type] = array_map(function ($item) use ($type) {
                return $item->$type;
            }, $type::getAll());
        }
    }
    return $filters;
}

function searchPosts(PDO $db, string $search, array $filters): array {
    $query = '
        SELECT *
        FROM Post
        WHERE title LIKE :search
            OR EXISTS (SELECT *
            FROM Item
            WHERE Item.id = Post.item
            AND (category IN :categories) AND (size IN :sizes) AND (condition IN :conditions)
            AND ((category LIKE :search OR size LIKE :search OR condition LIKE :search
            OR EXISTS (SELECT *
                FROM BrandItem
                WHERE BrandItem.item = Item.id AND brand LIKE :search)
            OR EXISTS (SELECT *
                FROM User
                WHERE User.id = Post.user AND username LIKE :search))))';
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->bindValue(':categories', "'" . implode("', '", $filters['category']) - "'");
    $stmt->bindValue(':sizes', "'" . implode("', '", $filters['size']) - "'");
    $stmt->bindValue(':conditions', "'" . implode("', '", $filters['condition']) - "'");
    $stmt->execute();
    
    $posts = [];
    foreach ($stmt->fetchAll() as $row) {
        $posts[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'price' => $row['price'],
            'date' => $row['date'],
            'item' => $row['item'],
            'user' => $row['user'],
            'username' => User::getUserByID($db, $row['user'])->name,
        ];
    }
    return $posts;
}

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

if (!isset($_GET['search']) || !isset($_GET['filters']))
    die(['success' => false, 'error' => 'Missing fields']);

try {
    $db = new PDO('sqlite:' . $DB_PATH);
    $filters = parseFilters();
    $posts = searchPosts($db, validate($_GET['search']), $filters);
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

die(json_encode(['success' => true, 'posts' => $posts]));

