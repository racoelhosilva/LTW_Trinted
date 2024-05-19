<?php
declare(strict_types=1);

require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/../db/utils.php';
require_once __DIR__ . '/../rest_api/utils.php';
require_once __DIR__ . '/../framework/Autoload.php';

$filterTypes = ['category', 'size', 'condition'];

function searchProducts(PDO $db, string $search, Request $request): array {
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
        ORDER BY publishDatetime ASC;';
    
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', '%' . $search . '%');
    $stmt->execute();
    
    $products = [];
    foreach ($stmt->fetchAll() as $row) {
        $product = Product::getProductByID($db, $row['id']);
        if (isset($product))
            $products[] = parseProduct($product, $request, $db);
    }
    return $products;
}

function getFilters(Request $request): array {
    global $filterTypes;
    $filters = [];
    foreach ($filterTypes as $filterType) {
        $filters[$filterType] = $request->get($filterType, []);
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

function countProducts(PDO $db, string $search, array $filters, Request $request): int {
    return count(array_filter(searchProducts($db, $search, $request), function($product) use ($filters) {
        return matchesFilters($product, $filters);
    }));
}

$request = new Request();
$db = getDatabaseConnection();

if ($request->getMethod() !== 'GET')
    sendMethodNotAllowed();

$request = new Request();
if (!$request->paramsExist(['query']))
    sendMissingFields();

try {
    $query = $request->get('query');
    $count = $request->get('count', 'false') === 'true';
    $start = (int)$request->get('start', 0);
    $limit = (int)$request->get('limit', PHP_INT_MAX);

    $filters = getFilters($request);

    if (!$count) {
        $products = searchProducts($db, $query, $request);
        $products = filterResults($db, $products, $filters);
        $products = limitResults($products, $start, $limit);

        sendOk(['products' => $products]);
    } else {
        $count = countProducts($db, $query, $filters, $request);

        sendOk(['count' => $count]);
    }
        
} catch (Exception $e) {
    error_log($e->getMessage());
    sendInternalServerError();
}

