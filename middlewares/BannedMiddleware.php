<?php
require_once __DIR__ . "/Middleware.php";



class BannedMiddleware implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        $db = new PDO("sqlite:" . DB_PATH);
        $userId = $request->session('user')['id'];
        $user = $userId ? User::getUserByID($db, $userId) : null;
        
        $isBanned = $user?->isBanned($db);
        if ($isBanned) {
            header("Location: /banned");
            return $next($request);
        }
        return $next($request);
    }
}