<?php
namespace Libraries\Router;

class RouteCollection
{
    private array $routes;

    public function find($method, $path) {
        foreach($this->routes as $route) {
            if($route->getMethod() === $method && $route->getRoutePath() == $path) {
                return $route;
            }
        }
    }

    public function add($method, $path, $closure) {
        $this->routes[] = new Route($method, $path, $closure);
    }
}