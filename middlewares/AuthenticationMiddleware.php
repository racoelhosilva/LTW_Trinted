<?php
require_once __DIR__ . "/Middleware.php";
require_once __DIR__ . "/../framework/Request.php";

/**
 * @brief Helper function to check if user is logged in
 */
function isLoggedIn(Request $request) {
    return $request->getSession()->get('user')['id'] != null;
}

/**
 * @brief Checks user authentication upon requests
 */
class AuthenticationMiddleware implements Middleware {
    public function handle(Request $request, callable $next) {
        if (!isLoggedIn($request)) {
            header("Location: /login");
            return $next($request);
        }
        return $next($request);
    }
}
