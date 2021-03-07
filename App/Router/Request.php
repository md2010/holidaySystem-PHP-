<?php 

namespace App\Router;

class Request
{
    private $request;
    private $route;
    private $method;
    private $param = null;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_URI'];
        $this->path();
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function path()
    {
        if (strpos($this->request, '?')) {
            $this->route = strtok($this->request, '?');
        } else {
            $this->route = $this->request;
        } 
    }

    public function route()
    {   
        return $this->route;
    }

    public function request()
    {
        return $this->request;
    }

    public function method()
    {
        return $this->method;
    }

    public function param()
    {
        $this->checkForParams();
        return $this->param;
    }

    public function checkForParams()
    {
        if (strpos($this->request, '?')) {
            $this->param = substr($this->request, strpos($this->request, '?') + 1); 
        }
    }
}