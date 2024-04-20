<?php
require_once __DIR__ . "/Middleware.php";

function isLoggedIn(){
    return isset($_SESSION['user_id']);
}

class AuthenticationMiddleware implements Middleware{
    public function handle($request, $next)
    {
        if (!isLoggedIn()) {
            header("Location: /login");
            exit();
        }
        return $next($request);
    }
}
