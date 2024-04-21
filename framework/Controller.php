<?php
/**
 * @brief Receives requests and Generates pages
 */
class Controller {
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @brief Generates main page
     */
    public function index() {
        include_once('pages/main_page.php');
    }

    /**
     * @brief Generates login page
     */
    public function login() {
        include_once('pages/login_page.php');
    }
}
