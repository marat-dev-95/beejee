<?php
namespace Libraries\Router;

class Router
{
    private $routeCollection;
    private $modelRepository;

    public function __construct($modelRepository) {
        $this->routeCollection = new RouteCollection();
        $this->modelRepository = $modelRepository;
    }

    public function post($routePath, $closure) {
        $this->routeCollection->add('POST', $routePath, $closure);
    }

    public function get($routePath, $closure) {
        $this->routeCollection->add('GET', $routePath, $closure);
    }

    public function dispatch() {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = $this->routeCollection->find($_SERVER['REQUEST_METHOD'],$urlPath);
        if(is_null($route)) {
            header('HTTP/1.1 404 Not Found');
        } else {
            $route->run($this->modelRepository);
        }
    }
}