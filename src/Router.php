<?php

namespace App;

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method, $isLoggedIn = false, $requiredProperty = '')
    {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'isLoggedIn' => $isLoggedIn, 'requiredProperty' => $requiredProperty];
    }

    public function get($route, $controller, $action, $isLoggedIn = false, $requiredProperty = '')
    {
        $this->addRoute($route, $controller, $action, "GET", $isLoggedIn, $requiredProperty);
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch()
    {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method =  $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($uri, $this->routes[$method])) {
            $controller = $this->routes[$method][$uri]['controller'];
            $action = $this->routes[$method][$uri]['action'];
            $isLoggedIn = $this->routes[$method][$uri]['isLoggedIn'];
            $requiredProperty = $this->routes[$method][$uri]['requiredProperty'];
            if ($requiredProperty != '' && $requiredProperty && $isLoggedIn && isset($_SESSION['gebruiker'])) {
                // Administrator of de organisator van het event
                $userModel = unserialize($_SESSION['gebruiker']);
                $roles = $userModel->getRoles();
                $bevoegd = false;
                foreach($roles as $role)
                {
                    if ($role->getName() == 'Admin' || $role->getName() == 'Organisator')
                    {
                        $bevoegd = true;
                    }
                }
                if (!$bevoegd)
                {
                    // TODO give an error message.
                    header('Location: http://' . $_SERVER["HTTP_HOST"] . "/login");
                }
                if (!$userModel->checkAccess($method, $requiredProperty, $userModel))
                {
                    $message = "U kan dit event niet bewerken";
                    echo "
                    <script type='text/javascript'>
                        alert('$message');
                        window.location.href = 'http://' + window.location.host + '/beheer/event';
                    </script>
                    ";
                }
                $controller = new $controller();
                $controller->$action();
            } else if ($isLoggedIn && isset($_SESSION['Gebruikersnaam']) && isset($_SESSION['GebruikersID']) ) {
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