<?php
require_once __DIR__ . "/Middleware.php";



class BannedMiddleware implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        $db = new PDO("sqlite:" . DB_PATH);
        $user = User::getUserByID($db, $request->getSession()->get('user_id'));
        
        $isBanned = $user->isBanned($db);
        if ($isBanned) {
            header("Location: /banned");
            return $next($request);
        }
        return $next($request);
    }
}