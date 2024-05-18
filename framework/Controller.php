<?php

/**
 * @brief Receives requests and Generates pages
 */
class Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @brief Generates main page
     */
    public function index(array $args) {
        require_once __DIR__ . '/../pages/main_page.php';
        return drawMainPage($this->request);
    }

    /**
     * @brief Generates login page
     */
    public function login(array $args) {
        require_once __DIR__ . '/../pages/login_page.php';
        return drawLoginPage($this->request);
    }

    /**
     * @brief Generates search page
     */
    public function search(array $args) {
        require_once __DIR__ . '/../pages/search_page.php';
        return drawSearchPage($this->request);
    }

    /**
     * @brief Generates profile page
     */
    public function profile(array $args) {
        require_once __DIR__ . '/../pages/profile_page.php';

        if (empty($args[0])) {
            $sessionUser = $this->request->getSession()->get('user');
            return drawProfilePage($this->request, (int)$sessionUser['id']);
        }
        return drawProfilePage($this->request, (int)$args[0]);
    }

    public function banned(array $args) {
        require_once __DIR__ . '/../pages/banned_page.php';
        return drawBannedPage($this->request);
    }

    /**
     * @brief Generates product page
     */
    public function product(array $args) {
        require_once __DIR__ . '/../pages/product_page.php';
        return drawProductPage($this->request, (int)$args[0]);
    }

    /**
     * @brief Generates settings page
     */
    public function settings() {
        require_once __DIR__ . '/../pages/settings_page.php';
        return drawSettingsPage($this->request);
    }

    /**
     * @brief Generates messages page
     */
    public function messages() {
        require_once __DIR__ . '/../pages/messages_page.php';
        return drawMessagePage($this->request);
    }

    /**
     * @brief Generates checkout page
     */
    public function checkout(array $args) {
        require_once __DIR__ . '/../pages/checkout_page.php';
        return drawCheckoutPage($this->request);
    }

    /**
     * @brief Generates help page
     */
    public function help(array $args) {
        require_once __DIR__ . '/../pages/help_page.php';
        return drawHelpPage($this->request);
    }

    /**
     * @brief Generates about page
     */
    public function about(array $args) {
        require_once __DIR__ . '/../pages/about_page.php';
        return drawAboutPage($this->request);
    }

    /**
     * @brief Generates cookie policy page
     */
    public function cookiePolicy(array $args)
    {
        require_once __DIR__ . '/../pages/cookie_policy.php';
        return drawCookiePolicyPage($this->request);
    }

    /**
     * @brief Generates privacy policy page
     */
    public function privacyPolicy(array $args)
    {
       require_once __DIR__ . '/../pages/privacy_policy.php';
        return drawPrivacyPolicyPage($this->request);
    }

    /**
     * @brief Generates terms and conditions page
     */
    public function termsAndConditions(array $args)
    {
        require_once __DIR__ . '/../pages/terms_and_conditions.php';
        return drawTermsAndConditionsPage($this->request);
    }

    /**
     * @brief Generates admin dashboard page
     */
    public function dashboard() {
        include_once('pages/dashboard_page.php');
        return drawDashboardPage($this->request);
    }

    /**
     * @brief Generates about page
     */
    public function newProduct() {
        include_once('pages/new_product_page.php');
        return drawNewProductPage($this->request);
    }

    /**
     * @brief Generates about page
     */
    public function editProduct() {
        include_once('pages/edit_product_page.php');
        return drawEditProductPage($this->request);
    }
}
