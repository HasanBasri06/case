<?php

use App\Controller\HomeController;
use App\Route;
use Http\Middleware\Auth;

require_once __DIR__ . '/../vendor/autoload.php';

$route = new Route();

$route->get('/', [HomeController::class, 'index']);

$route->run();
