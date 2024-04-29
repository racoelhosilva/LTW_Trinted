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

    /**
     * @brief Generates login page
     */
    public function profile() {
        include_once('pages/profile_page.php');
        return drawProfilePage($this->request);
    }

    /**
     * @brief Generates product page
     */
    public function product() {
        include_once('pages/product_page.php');
        return drawProductPage($this->request);
    }

    /**
     * @brief Generates messages page
     */
    public function messages() {
        include_once('pages/messages_page.php');
    }
}
