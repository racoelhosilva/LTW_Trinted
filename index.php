<?php
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
        'middlewares' => []
    ],
];

// Extract the path from the URL and compare it to the defined routes
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$route = $routes[$path] ?? null;

if ($route) {
    // Select which controller and action to load
    list($controllerName, $actionName) = explode('@', $route['controller']);

    // Create the Request object associated
    $request = new Request();

    // Process the middleware chain (if it exists)
    foreach ($route['middlewares'] as $middleware) {
        $request = $middleware->handle($request, function ($request) {
            return $request;
        });
    }

    // Create the controller and generate page
    $controller = new $controllerName($request);
    $controller->$actionName();

} else {
    // Display 404 page if route is not defined
    include_once('pages/404_page.php');
}