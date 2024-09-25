<?php

use App\Enum\NotFoundTypeEnum;

function redirect($route = '/') {
    $route = trim($route, '/');
    $path = $route;

    header('Location: ' . $path);
}

function view(string $view, array $data = null) {
    if (!is_null($data)) {
        extract($data);
    }
    
    return include './app/view/'.$view.".php";
}

function notFoundPageConfig() {
    return [
        'type' => NotFoundTypeEnum::ARRAY->value,
        'message' => '404 Not Found',
    ];
}

function dbConfig() {
    return [
        'host' => 'localhost',
        'nickname' => 'root',
        'password' => '',
        'dbname' => 'case'
    ];
}