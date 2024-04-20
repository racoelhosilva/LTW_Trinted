<?php
class Request {
    private $getParams;
    private $postParams;
    private $cookies;
    private $headers;
    private $files;

    public function __construct() {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->cookies = $_COOKIE;
        $this->headers = $_SERVER;
        $this->files = $_FILES;
    }

    public function get($key, $default = null) {
        return isset($this->getParams[$key]) ? $this->getParams[$key] : $default;
    }

    public function post($key, $default = null){
        return isset($this->postParams[$key]) ? $this->postParams[$key] : $default;
    }

    public function cookie($key, $default = null) {
        return isset($this->cookies[$key]) ? $this->cookies[$key] : $default;
    }

    public function header($key) {
        return isset($this->headers[$key]) ? $this->headers[$key] : null;
    }

    public function files($key) {
        return isset($this->files[$key]) ? $this->files[$key] : null;
    }
}