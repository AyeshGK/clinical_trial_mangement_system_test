<?php

use app\core\Application;
use app\Http\Controllers\AuthController;
use app\Http\Controllers\SiteController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$app = new Application();

$app->routing()->get('/', [SiteController::class, 'home']);

$app->routing()->get('/signup', [AuthController::class, 'signUp']);
$app->routing()->post('/signup', [AuthController::class, 'register']);

$app->routing()->get('/login', [AuthController::class, 'logIn']);

$app->run();