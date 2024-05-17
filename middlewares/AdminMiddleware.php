<?php
require_once __DIR__ . "/Middleware.php";

class AdminMiddleware implements Middleware
{
    public function handle($request, $next)
    {
        $db = new PDO("sqlite:" . DB_PATH);
        $user = User::getUserByID($db, $request->session('user_id'));
        if ($user->type != 'admin') {
            header("Location: /404");
            return $next($request);
        }
        return $next($request);
    }
}