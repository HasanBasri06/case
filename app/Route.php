<?php

namespace App;
class Route
{
    protected $routeCollect = [];

    public function get(string $url, array $class) {
        $routeTemplate = ['url' => $url, 'controller' => $class, 'type' => 'GET'];
        array_push($this->routeCollect, $routeTemplate);

        return $this;
    }

    public function post(string $url, array $class) {
        $routeTemplate = ['url' => $url, 'controller' => $class, 'type' => 'POST'];
        array_push($this->routeCollect, $routeTemplate);

        return $this;
    }

    public function middleware(string $name) {
        var_dump("Hello middleware");
    }

    public function run() {
        echo "<pre>";
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
        $requestURI = $_SERVER['REQUEST_URI'];

        foreach ($routes as $route) {
            $matchUrl = preg_match_all('/({.*?})/', $route['url'], $regexRoute);

            var_dump($matchUrl);
        }
    }
}