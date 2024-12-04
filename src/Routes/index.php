<?php

use App\Controllers\BeheerBekijkEventController;
use App\Controllers\BeheerEventAanmakenController;
use App\Controllers\BeheerHomeController;
use App\Controllers\HomeController;
use App\Controllers\DashboardController;
use App\Controllers\EventInfoController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\EventsController;
use App\Controllers\ProfielController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/home', HomeController::class, 'index');
$router->get('/dashboard', DashboardController::class, 'index');
$router->get('/login', LoginController::class, 'index');
$router->get('/register', RegisterController::class, 'index');
$router->get('/events', EventsController::class, 'index');
$router->get('/event-info', EventInfoController::class, 'index');
$router->get('/beheer/event-aanmaken', BeheerEventAanmakenController::class, 'index');
$router->get('/beheer/', BeheerHomeController::class, 'index');
$router->get('/profiel', ProfielController::class, 'index');
$router->get('/beheer/bekijk-events', BeheerBekijkEventController::class, 'index');


$router->dispatch();