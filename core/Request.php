<?php

class Request
{
    private $path;
    private $method;

    public function __construct()
    {
        $this->path = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function path()
    {
        return $this->path;
    }

    public function body()
    {
        if (!in_array($this->method, ['POST', 'PUT', 'PATCH'])) {
            return $_GET;
        }

        if ($_SERVER['CONTENT_TYPE'] === 'application/json')
            return json_decode(file_get_contents('php://input'), true);

        return $_POST;
    }
}
