<?php

namespace App\Router;

use App\Controllers\Controller;
use App\Router\Request;
use App\Router\Routes;

class Router 
{
    private $controller;
    private $routes;
    private $request;
    private $httpMethods = [
        'get' => 'App\Router\Router::get', 
        'post' => 'App\Router\Router::post', 
        'delete' => 'App\Router\Router::delete',
        'put' => 'App\Router\Router::put'
    ];

    public function __construct()
    {
        $this->controller = new Controller();
        $this->routes = new Routes(); 
        $this->request = new Request();
    }

    public function get() 
    {   
        if (! array_key_exists($this->request->route(), $this->routes->get_routes)) {
            echo "Route not found!";
        }
        call_user_func($this->routes->get_routes[$this->request->route()], $this->request->param());
    }

    public function post()
    {
        if (! array_key_exists($this->request->route(), $this->routes->post_routes)) {
            echo "Route not found!";
        }
        call_user_func($this->routes->post_routes[$this->request->route()], $this->request->param());
    }

    public function delete()
    {
        if (! array_key_exists($this->request->route(), $this->routes->delete_routes)) {
            echo "Route not found!";
        }
        call_user_func($this->routes->delete_routes[$this->request->route()], $this->request->param());
    }

    public function put()
    {
        if (! array_key_exists($this->request->route(), $this->routes->put_routes)) {
            echo "Route not found!";
        }
        call_user_func($this->routes->put_routes[$this->request->route()], $this->request->param());
    }

    public function dispatch()
    {
        if (! array_key_exists($this->request->method(), $this->httpMethods)) {
            echo "ERROR: HTTP method not supported!";
        }
        call_user_func($this->httpMethods[$this->request->method()], $this->request->param());
    }

   
}