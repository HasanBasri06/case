<?php

use App\Controller\HomeController;
use App\Route;
use Http\Middleware\Auth;

require_once __DIR__ . '/../vendor/autoload.php';

$route = new Route();

$route->get('/', [HomeController::class, 'index']);
$route->get('/users', [HomeController::class, 'users']);
$route->get('/admin', [HomeController::class, 'adminPage'], Auth::class);

$route->run();
