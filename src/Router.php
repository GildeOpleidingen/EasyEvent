<?php

namespace App;

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method, $isLoggedIn = false)
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'isLoggedIn' => $isLoggedIn];
    }

    public function get($route, $controller, $action, $isLoggedIn = false)
    {
        $this->addRoute($route, $controller, $action, "GET", $isLoggedIn);
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }


    public function delete($route, $controller, $action, $isLoggedIn = false)
    {
        $this->addRoute($route, $controller, $action, `DELETE`, $isLoggedIn);
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];
            $isLoggedIn = $this->routes[$method][$uri]['isLoggedIn'];
            if ($isLoggedIn && isset($_SESSION['GebruikerEmail']) && isset($_SESSION['GebruikersID']) ) {
                $controller = new $controller();
                $controller->$action();
            } else if (!$isLoggedIn) {
                $controller = new $controller();
                $controller->$action();
            } else {
                header('Location: http://' . $_SERVER["HTTP_HOST"] . "/login");
            }
        } else {
            throw new \Exception("No route found for URI: $uri");
        }
    }
}