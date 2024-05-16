<?php
require_once __DIR__ . "/Middleware.php";



class BannedMiddleware implements Middleware
{
    public function handle($request, $next)
    {
        $db = new PDO("sqlite:" . DB_PATH);
        $user = User::getUserByID($db, $request->session('user_id'));
        $isBanned = $user->isBanned($db);
        if ($isBanned) {
            header("Location: /banned");
            return $next($request);
        }
        return $next($request);
    }
}