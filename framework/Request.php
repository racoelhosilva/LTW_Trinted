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

    private function sanitize(?string $data): string {
        if ($data === null)
            return '';
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function get($key, $default = null)
    {
        return sanitize($this->getParams[$key]) ?? $default;
    }

    public function post($key, $default = null)
    {
        return sanitize($this->postParams[$key]) ?? $default;
    }

    public function cookie($key, $default = null)
    {
        return sanitize($this->cookies[$key]) ?? $default;
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

    public function verifyCsrf() : bool
    {
        return $this->post('csrf') === $this->session->getCsrf();
    }

    public function paramsExist(string $method, array $params) : bool
    {
        $arrayName = '_' . $method;
        $array = $$arrayName;
        if (!isset($array))
            return false;

        foreach ($params as $param) {
            if (!isset($array[$param]))
                return false;
        }
        return true;
    }
}
