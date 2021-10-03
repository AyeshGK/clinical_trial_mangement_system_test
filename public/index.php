<?php
require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\Http\Controllers\AuthController;


$app = new Application();


$app->router->get('/', 'signup');
$app->router->post('/', [AuthController::class, 'register']);


$app->run();