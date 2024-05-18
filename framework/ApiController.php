<?php
declare(strict_types=1);

require_once __DIR__ .'/Request.php';
require_once __DIR__ .'/../rest_api/utils.php';

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
            'condition' => 'conditions',
            'category' => 'categories',
        ];

        $resource = $args[0];
        $subroute = $subroutes[$resource];

        if ($subroute)
            $this->$subroute($args);
        else
            sendNotFound();
    }

    private function products(array $args) {
        require_once __DIR__ . '/../rest_api/api_product.php';
    }

    private function sizes(array $args) {
        require_once __DIR__ . '/../rest_api/api_size.php';
    }

    private function conditions(array $args) {
        require_once __DIR__ . '/../rest_api/api_condition.php';
    }

    private function categories(array $args) {
        require_once __DIR__ . '/../rest_api/api_category.php';
    }
}