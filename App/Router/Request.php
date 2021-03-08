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
        $this->checkForParams();
        echo "Request: ";
        var_dump($this->request);
    }

    public function path()
    {
        if (strpos($this->request, 'logOut')) {
            echo "im here";
            $this->route = '/logOut';
        } else if (strpos($this->request, '?')) {
            $this->route = strtok($this->request, '?');
        } else if (strrpos($this->request, '/')) {
            $this->route = preg_replace('/(\d+)/', ':id', $this->request);
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
        return $this->param;
    }

    public function checkForParams()
    {
        if (strrpos($this->request, '?')) {
            $this->param = substr($this->request, strrpos($this->request, '?') + 1); 
        } else if (strrpos($this->request, '/')) {
            $r = substr($this->request, strrpos($this->request, '/') + 1); 
            $this->param = preg_replace('/\D/', '', $r);
        } 
    }

}

/*else {
    echo "preg replace: ";
    var_dump(preg_replace('/\\\[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)',$this->request));
} */