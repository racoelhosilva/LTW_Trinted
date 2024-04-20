<?php
class Controller {
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function index() {
        include_once('pages/main_page.php');
    }

    public function login() {
        include_once('pages/login_page.php');
    }
}
