<?php

use App\Controller\BasketController;
use App\Controller\HomeController;
use App\Route;
use Http\Middleware\Auth;

require_once __DIR__ . '/../vendor/autoload.php';

$route = new Route();

$route->get('/sepetim', [BasketController::class, 'myBasket']);
$route->post('/save-basket', [BasketController::class, 'saveBasket']);
$route->get('/user/{id}/detay/{deneme}', [BasketController::class, 'userDetail']);

$route->run();
