<?php
require_once __DIR__ . '/utils/Autoload.php';

$routes = [
    '/' => 'Controller@index',
    '/login' => 'Controller@login',
];

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

$route = $routes[$path] ?? null;

if ($route) {
    
    list($controllerName, $actionName) = explode('@', $route);
    
    $request = new Request();

    $controller = new $controllerName($request);
    $controller->$actionName();

} else {
    header("HTTP/1.0 404 Not Found");
    echo '404 - Page Not Found';
}
?>