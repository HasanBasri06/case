<?php

use App\Enum\NotFoundTypeEnum;

function redirect($route = '/') {
    $route = trim($route, '/');
    $path = $route;

    header('Location: ' . $path);
}

function view(string $view, array $data = null) {
    return [
        'template' => './app/view/'.$view.".php",
        'type' => 'view',
        'data' => $data
    ];
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

function dd($value, ...$values) {
    echo "<pre>";
        var_dump($value);
    echo "</pre>";
    foreach ($values as $val) {
        echo "<pre>";
            var_dump($val);
        echo "</pre>";
    }
}

