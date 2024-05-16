<?php
declare(strict_types=1);

include_once('Request.php');

/**
 * @brief Controlls and handles calls to the API
 */
class ApiController {
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function handle(array $args) {
        $subroutes = [
            'post' => 'posts'
        ];

        $resource = $args[0];
        $subroute = $subroutes[$resource];

        if ($subroute)
            $this->$subroute($args);
        else
            $this->notFound();
    }

    private function posts(array $args) {
        require_once('rest_api/api_posts.php');
    }

    private function notFound() {
        header('HTTP/1.1 404 Not Found');
    }
}