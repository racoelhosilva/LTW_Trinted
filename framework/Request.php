<?php
declare(strict_types=1);

require_once __DIR__ . '/Session.php';

/**
 * @brief Encapsulates superglobals when requests are created
 */
class Request
{
    private array $getParams;
    private array $postParams;
    private array $cookies;
    private array $headers;
    private array $files;
    private Session $session;

    public function __construct()
    {
        $this->getParams = $_GET;
        $this->postParams = $_POST;
        $this->cookies = $_COOKIE;
        $this->headers = $_SERVER;
        $this->files = $_FILES;
        $this->session = new Session();
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

    public function getSession() : Session
    {
        return $this->session;
    }
}
