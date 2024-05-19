<?php
declare(strict_types=1);

require_once __DIR__ . '/../framework/Request.php';

/**
 * @brief Defines the middleware interface with the handle method
 */
interface Middleware {
    public function handle(Request $request, callable $next);
}
