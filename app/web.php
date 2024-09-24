<?php

use App\Controller\HomeController;
use App\Route;

require_once __DIR__ . '/../vendor/autoload.php';

$route = new Route();

$route->get('/', [HomeController::class, 'index']);
$route->get('/users', [HomeController::class, 'deneme']);
$route->get('/users/{id}', [HomeController::class, 'userDetail']);
$route->get('/users/{id}/about', [HomeController::class, 'userDetailAbout']);
$route->get('/users/{id}/about/{detail}', [HomeController::class, 'userDetailAboutDetail']);
$route->post('/save-user', [HomeController::class, 'saveUser']);

$route->run();
