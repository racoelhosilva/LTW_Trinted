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
        return drawMainPage($this->request);
    }

    /**
     * @brief Generates login page
     */
    public function login() {
        include_once('pages/login_page.php');
        return drawLoginPage($this->request);
    }

    /**
     * @brief Generates search page
     */
    public function search() {
        include_once('pages/search_page.php');
        return drawSearchPage($this->request);
    }
}
