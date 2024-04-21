<?php
require_once __DIR__ . "/Middleware.php";

/**
 * @brief Helper function to check if user is logged in
 */
function isLoggedIn($request){
    return $request->session('user_id') != null;
}

/**
 * @brief Checks user authentication upon requests
 */
class AuthenticationMiddleware implements Middleware{
    public function handle($request, $next) {
        if (!isLoggedIn($request)) {
            header("Location: /login");
            exit();
        }
        return $next($request);
    }
}
