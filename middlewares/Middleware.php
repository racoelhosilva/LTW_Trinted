<?php
interface Middleware {
    public function handle($request, $next);
}
