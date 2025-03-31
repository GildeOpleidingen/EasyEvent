<?php

use App\Controllers\PlanningController;
use App\Controllers\BeheerEventAanmakenController;
use App\Controllers\BeheerHomeController;
use App\Controllers\HomeController;
use App\Controllers\DashboardController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\EventsController;
use App\Controllers\EventInfoController;
use App\Controllers\ProfielController;
use App\Controllers\UserController;
use App\Router;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/home', HomeController::class, 'index');
$router->get('/dashboard', DashboardController::class, 'index');
$router->get('/login', LoginController::class, 'index');
$router->post('/login', LoginController::class, 'login');
$router->get('/forgot-password', LoginController::class, 'forgotPasswordForm');
$router->post('/forgot-password', LoginController::class, 'sendResetEmail');
$router->get('/logout', LoginController::class, 'logout');
$router->get('/register', RegisterController::class, 'index');
$router->post('/register', RegisterController::class, 'register');
$router->post('/verify-code', RegisterController::class, 'verifyCode');
$router->get('/events', EventsController::class, 'index');
$router->get('/event-info', EventInfoController::class, 'index');
$router->post('/event-info', EventInfoController::class, 'update');
$router->get('/beheer/event-aanmaken', BeheerEventAanmakenController::class, 'index', true);
$router->post('/beheer/event-aanmaken', BeheerEventAanmakenController::class, 'sendEvent', true);
$router->get('/beheer/event-aanmaken-stap-2', BeheerEventAanmakenController::class, 'index', true);
$router->post('/beheer/event-aanmaken-stap-2', BeheerEventAanmakenController::class, 'sendEvent', true);
$router->get('/beheer/', BeheerHomeController::class, 'index');
$router->get('/profiel', ProfielController::class, 'index', true);
$router->post('/profiel', ProfielController::class, 'updateTelefoon', true);
$router->post('/profiel/updateAdresGegevens', ProfielController::class, 'updateAdresGegevens', true);
$router->post('/profiel/updateWachtwoord', ProfielController::class, 'updateWachtwoord', true);
$router->post('/profiel/logout', LoginController::class, 'logout');
$router->get('/beheer/event', EventsController::class, 'adminIndex', true);
$router->get('/beheer/event/planning', PlanningController::class, 'index', true);
$router->get('/beheer/user-overzicht', UserController::class, 'index', true);
$router->get('/beheer/user-aanmaken', UserController::class, 'add', true);
$router->post('/beheer/user-aanmaken', UserController::class, 'saveUser', true);

$router->dispatch();
