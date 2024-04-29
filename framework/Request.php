<?php
session_start();
/**
 * @brief Encapsulates superglobals when requests are created
 */
class Request
{
    private $getParams;
    private $postParams;
    private $cookies;
    private $headers;
    private $files;
    private $session;

    public function __construct()
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->cookies = $_COOKIE;
        $this->headers = $_SERVER;
        $this->files = $_FILES;
        $this->session = $_SESSION;
    }

    public function get($key, $default = null)
    {
        return $this->getParams[$key] ?? $default;
    }

    public function post($key, $default = null)
    {
        return $this->postParams[$key] ?? $default;
    }

    public function cookie($key, $default = null)
    {
        return $this->cookies[$key] ?? $default;
    }

    public function header($key)
    {
        return $this->headers[$key] ?? null;
    }

    public function files($key)
    {
        return $this->files[$key] ?? null;
    }

    public function session($key)
    {
        return $this->session[$key] ?? null;
    }
}
