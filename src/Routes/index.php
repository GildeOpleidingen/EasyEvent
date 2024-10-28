<?php

use App\Controllers\HomeController;
use App\Controllers\DashboardController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\EventsController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/home', HomeController::class, 'index');
$router->get('/dashboard', DashboardController::class, 'index');
$router->get('/login', LoginController::class, 'index');
$router->get('/register', RegisterController::class, 'index');
$router->post('/register', RegisterController::class, 'register');
$router->get('/events', EventsController::class, 'index');


$router->dispatch();