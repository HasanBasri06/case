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

function str_random($maxLength = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $maxLength; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }

    return $randomString;
}

function csrf() {
    if (isset($_SESSION['X-CSRF-TOKEN'])) {
        return $_SESSION['X-CSRF-TOKEN'];
    }
    
    return $_SESSION['X-CSRF-TOKEN'] = str_random(16);
}