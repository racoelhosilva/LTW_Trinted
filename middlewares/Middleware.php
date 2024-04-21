<?php
/**
 * @brief Defines the middleware interface with the handle method
 */
interface Middleware {
    public function handle($request, $next);
}
