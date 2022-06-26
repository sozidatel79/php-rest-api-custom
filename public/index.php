<?php
error_reporting(E_ERROR | E_PARSE);

header("Access-Control-Allow-Origin:*");
header('Content-type: application/json');

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Router\Handler;
use App\Controllers\User\User;
use App\Controllers\Auth\Auth;

$router = new Router(new Handler());


$router->get('/users', User::class . '::getAll');
$router->post('/users/one', User::class . '::getOne');
$router->patch('/users/update', User::class . '::getUpdate');

$router->post('/login', Auth::class . '::login');
$router->post('/logout', Auth::class . '::logout');


$router->dispatch();
