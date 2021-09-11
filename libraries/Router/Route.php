<?php
namespace Libraries\Router;

class Route
{
    private $httpMethod;

    private $closure;

    private $routePath;

    private $acceptMethods = ['POST', 'GET'];

    public function __construct(string $method, string $routePath, array $closure) {
        if(in_array($method, $this->acceptMethods)) {
            $this->httpMethod = $method;
        } else {
            $this->httpMethod = 'GET';
        }
        $this->routePath = $routePath;
        $this->closure = $closure;
    }

    public function run($modelRepository) {
        $controller = new $this->closure[0]($modelRepository);
        call_user_func([$controller, $this->closure[1]]);
    }

    public function getMethod() {
        return $this->httpMethod;
    }

    public function getRoutePath() {
        return $this->routePath;
    }
}