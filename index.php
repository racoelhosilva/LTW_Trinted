<?php
require_once __DIR__ . '/utils/Autoload.php';

$routes = [
    '/' => [
        'controller' => 'Controller@index',
        'middlewares' => []
    ],
    '/login' => [
        'controller' => 'Controller@login',
        'middlewares' => []
    ],
];

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

$route = $routes[$path] ?? null;

if ($route) {

    list($controllerName, $actionName) = explode('@', $route['controller']);

    $request = new Request();

    foreach ($route['middlewares'] as $middleware) {
        $request = $middleware->handle($request, function ($request) {
            return $request;
        });
    }

    $controller = new $controllerName($request);
    $controller->$actionName();

} else {
    header("HTTP/1.0 404 Not Found");
    echo '404 - Page Not Found';
}