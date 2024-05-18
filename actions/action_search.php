<?php
declare(strict_types=1);

include_once(__DIR__ . '/utils.php');
include_once(__DIR__ . '/../db/classes/Product.class.php');
include_once(__DIR__ . '/../db/classes/User.class.php');
include_once(__DIR__ . '/../db/classes/Size.class.php');
include_once(__DIR__ . '/../db/classes/Condition.class.php');
include_once(__DIR__ . '/../db/classes/Category.class.php');

$filterTypes = ['category', 'size', 'condition'];

function searchProducts(PDO $db, string $search): array {
    $query = '
        SELECT id
        FROM Product
        WHERE title LIKE :search
        OR description LIKE :search
        OR price LIKE :search
        OR (category LIKE :search OR size LIKE :search OR condition LIKE :search)
        OR id IN (SELECT product
            FROM ProductBrand
            WHERE brand LIKE :search)
        OR seller IN (SELECT id
            FROM User
            WHERE name LIKE :search)
        ORDER BY publishDatetime;';
    
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    
    $products = [];
    foreach ($stmt->fetchAll() as $row) {
        $product = Product::getProductByID($db, $row['id']);
        $products[] = parseProduct($db, $product);
    }
    return $products;
}

function getFilters(): array {
    global $filterTypes;
    $filters = [];
    foreach ($filterTypes as $filterType) {
        $filters[$filterType] = $_GET[$filterType] ?? [];
    }
    return $filters;
}

function matchesFilters(array $product, array $filters): bool {
    global $filterTypes;

    foreach ($filterTypes as $filterType) {
        if ($filters[$filterType] != [] && !in_array($product[$filterType], $filters[$filterType])) {
            return false;
        }
    }

    return true;
}

function filterResults(PDO $db, array $products, array $filters): array {
    return array_filter($products, function($product) use ($filters) {
        return matchesFilters($product, $filters);
    });
}

function limitResults(array $products, int $start, int $limit): array {
    return array_slice($products, $start, $limit);
}

function countProducts(PDO $db, string $search, array $filters): int {
    return count(array_filter(searchProducts($db, $search), function($product) use ($filters) {
        return matchesFilters($product, $filters);
    }));
}

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET')
    die(json_encode(['success' => false, 'error' => 'Invalid request method']));

$request = new Request();
if (!$request->paramsExist(['query']))
    die(['success' => false, 'error' => 'Missing fields']);

try {
    $query = sanitize($_GET['query']);
    $count = isset($_GET['count']) && $_GET['count'] === 'true';
    $start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : PHP_INT_MAX;

    $db = new PDO('sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
    $filters = getFilters();

    if (!$count) {
        $products = searchProducts($db, $query);
        $products = filterResults($db, $products, $filters);
        $products = limitResults($products, $start, $limit);

        die(json_encode(['success' => true, 'products' => $products]));
    } else {
        $count = countProducts($db, $query, $filters);

        die(json_encode(['success' => true, 'count' => $count]));
    }
        
} catch (Exception $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

