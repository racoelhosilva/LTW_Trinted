<?php
define('DB_PATH', $_SERVER['DOCUMENT_ROOT'] . '/db/database.db');
// Load the autoloader
require_once __DIR__ . '/framework/Autoload.php';

// Define the existing website routes
$routes = [
    '/' => [
        'controller' => 'Controller@index',
        'middlewares' => []
    ],
    '/login' => [
        'controller' => 'Controller@login',
        'middlewares' => []
    ],
    '/messages' => [
        'controller' => 'Controller@messages',
        'middlewares' => [new AuthenticationMiddleware(), new BannedMiddleware()]
    ],
    '/search' => [
        'controller' => 'Controller@search',
        'middlewares' => []
    ],
    '/profile' => [
        'controller' => 'Controller@profile',
        'middlewares' => [new AuthenticationMiddleware(), new BannedMiddleware()]
    ],
    '/product' => [
        'controller' => 'Controller@product',
        'middlewares' => []
    ],
    '/banned' => [
        'controller' => 'Controller@banned',
        'middlewares' => []
    ],
    '/settings' => [
        'controller' => 'Controller@settings',
        'middlewares' => [new AuthenticationMiddleware(), new BannedMiddleware()]
    ],
    '/checkout' => [
        'controller' => 'Controller@checkout',
        'middlewares' => [new AuthenticationMiddleware(), new BannedMiddleware()]
    ],
    '/help' => [
        'controller' => 'Controller@help',
        'middlewares' => []
    ],
    '/about' => [
        'controller' => 'Controller@about',
        'middlewares' => []
    ],
    '/cookie-policy' => [
        'controller' => 'Controller@cookiePolicy',
        'middlewares' => []
    ],
    '/privacy-policy' => [
        'controller' => 'Controller@privacyPolicy',
        'middlewares' => []
    ],
    '/terms-and-conditions' => [
        'controller' => 'Controller@termsAndConditions',
        'middlewares' => []
    ],
    '/api' => [
        'controller' => 'ApiController@handle',
        'middlewares' => []
    ],
    '/dashboard' => [
        'controller' => 'Controller@dashboard',
        'middlewares' => [new AdminMiddleware(), new AuthenticationMiddleware(), new BannedMiddleware()]
    ],
    '/new-product' => [
        'controller' => 'Controller@newProduct',
        'middlewares' => [new AuthenticationMiddleware(), new BannedMiddleware()]
    ]
];

// Extract the path from the URL and compare it to the defined routes
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
[ , $location, $args[] ] = explode('/', $path);
$route = $routes['/' . $location] ?? null;

// Create the Request object associated
$request = new Request();

if ($route) {
    // Select which controller and action to load
    list($controllerName, $actionName) = explode('@', $route['controller']);

    // Process the middleware chain (if it exists)
    foreach ($route['middlewares'] as $middleware) {
        $request = $middleware->handle($request, function ($request) {
            return $request;
        });
    }

    // Create the controller and generate page
    $controller = new $controllerName($request);
    echo $controller->$actionName($args);
} else {
    // Display 404 page if route is not defined
    require_once __DIR__ . '/pages/404_page.php';
    draw404Page($request);
}
