<?php
namespace src\Routes;

class Route
{
    protected static $instance;
    protected $routes = [];
    protected $verbs = ['GET','POST','PUT','PATCH','DELETE'];
    protected $routeMap = [];

    protected function __construct()
    {
        $this->routeMap = [
            'http' => app()->getBasePath().'/route/http.php',
        ];

        foreach ($this->routeMap as $key => $path) {
            require_once $path;
        }
        return $this;

    }

    public static function getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance = new static;
        }
        return self::$instance;
    }

    public function get($uri, $action)
    {
        return $this->addRoute(['GET'], $uri, $action);
    }

    public function post($uri, $action)
    {
        return $this->addRoute(['POST'], $uri, $action);
    }

    public function any($uri, $action)
    {
        return $this->addRoute(self::$verbs, $uri, $action);
    }

    protected function addRoute($methods,$uri,$action)
    {
        foreach($methods as $method){
            $this->routes[$method][$uri] = $action;
        }
        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

}