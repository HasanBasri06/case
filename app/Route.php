<?php

namespace App;

use App\Enum\NotFoundTypeEnum;
use Http\Request;
use IntlBreakIterator;
use ReflectionClass;
use stdClass;

use function PHPSTORM_META\type;

class Route
{
    protected $routeCollect = [];

    public function get(string $url, array $class, string $middleware = null) {
        $routeTemplate = $this->routeTemplate($url, $class, 'GET', $middleware);
        array_push($this->routeCollect, $routeTemplate);
    }

    public function post(string $url, array $class, string $middleware = null) {
        $routeTemplate = $this->routeTemplate($url, $class, 'POST', $middleware);
        array_push($this->routeCollect, $routeTemplate);
    }

    public function routeTemplate(string $url, array $class, string $type, string $middleware = null) {
        $template = ['url' => $url, 'controller' => $class, 'type' => $type, 'middleware' => $middleware];

        return $template;
    }

    public function run() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];


        if ($requestMethod == 'GET') {
            $getRoutes = array_filter($this->routeCollect, fn ($query) => $query['type'] == 'GET');
            $this->match($getRoutes);

            return [];
        }

        if ($requestMethod == 'POST') {
            $getRoutes = array_filter($this->routeCollect, fn ($query) => $query['type'] == 'POST');
            $this->match($getRoutes);

            return [];
        }
    }

    public function match(array $routes) {
        $requestURI = trim($_SERVER['REQUEST_URI'], '/');
        $routeFound = false;

        foreach ($routes as $route) {
            $url = trim($route['url'], '/');
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $url);

            if (preg_match("#^$pattern$#", $requestURI, $matches)) {
                array_shift($matches);
                $class = $route['controller'][0];
                $method = $route['controller'][1];
                $isNullMiddleware = !is_null($route['middleware']);

                if ($isNullMiddleware) {
                    $middlewareClass = $route['middleware'];

                    (new $middlewareClass)->handle();
                }

               
                $reflectionClass = new ReflectionClass($class);
                $getMethodType = $reflectionClass->getMethod($method);
                $returnType = $getMethodType->getReturnType();

                try {
                    if (!$getMethodType->hasReturnType()) {
                        throw new \Exception($class.'::'.$method . " methodunuz bir dönüş tipi belirtilmemiş");
                    }
                } catch (\Throwable $th) {
                    die($th->getMessage());
                }
                
                if ($returnType == 'string' || $returnType == 'integer') {
                    (new Kernel)->startTextMode($class, $method, $matches);

                    $routeFound = true;
                    break;
                }

                if ($returnType == 'array' || $returnType == 'object') {
                    (new Kernel)->startArrayMode($class, $method, $matches);
                    $routeFound = true;
                    break;
                }

                $routeFound = true;
                break;
            } 
        }

        if (!$routeFound) {
            echo json_encode($this->notFoundPage());
            exit();
        }
    }

    public function notFoundPage() {
        if (NotFoundTypeEnum::ARRAY->value == notFoundPageConfig()['type']) {
            return [
                "code" => 404,
                "message" => notFoundPageConfig()['message'],
                "data" => []
            ];
        }

        if (NotFoundTypeEnum::STRING->value == notFoundPageConfig()['type']) {
            return notFoundPageConfig()['message'];
        }
    }
}