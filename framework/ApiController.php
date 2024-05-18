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
            'product' => 'products',
            'size' => 'sizes',
        ];

        $resource = $args[0];
        $subroute = $subroutes[$resource];

        if ($subroute)
            $this->$subroute($args);
        else
            die(header('HTTP/1.1 404 Not Found'));
    }

    private function products(array $args) {
        require_once __DIR__ . '/../rest_api/api_product.php';
    }

    private function sizes(array $args) {
        require_once __DIR__ . '/../rest_api/api_size.php';
    }
}