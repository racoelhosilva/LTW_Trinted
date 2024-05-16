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
    public function index(array $args) {
        include_once('pages/main_page.php');
        return drawMainPage($this->request);
    }

    /**
     * @brief Generates login page
     */
    public function login(array $args) {
        include_once('pages/login_page.php');
        return drawLoginPage($this->request);
    }

    /**
     * @brief Generates search page
     */
    public function search(array $args) {
        include_once('pages/search_page.php');
        return drawSearchPage($this->request);
    }

    /**
     * @brief Generates profile page
     */
    public function profile(array $args) {
        include_once('pages/profile_page.php');
        return drawProfilePage($this->request, $args[0]);
    }

    public function banned(array $args) {
        include_once('pages/banned_page.php');
        return drawBannedPage();
    }

    /**
     * @brief Generates product page
     */
    public function product(array $args) {
        include_once('pages/product_page.php');
        return drawProductPage($this->request, (int)$args[0]);
    }

    /**
     * @brief Generates settings page
     */
    public function settings() {
        include_once('pages/settings_page.php');
        return drawSettingsPage($this->request);
    }

    /**
     * @brief Generates messages page
     */
    public function messages() {
        include_once('pages/messages_page.php');
        return drawMessagePage($this->request);
    }
    /**
     * @brief Generates checkout page
     */
    public function checkout(array $args) {
        include_once('pages/checkout_page.php');
        return drawCheckoutPage($this->request);
    }

    /**
     * @brief Generates help page
     */
    public function help(array $args) {
        include_once('pages/help_page.php');
        return drawHelpPage($this->request);
    }

    /**
     * @brief Generates about page
     */
    public function about(array $args) {
        include_once('pages/about_page.php');
        return drawAboutPage($this->request);
    }
}
