<?php

use App\Controller\AuthController;
use App\Controller\TaskController;
use Libraries\Router\Router;
use App\Model\ModelRepository;

$modelRepository = new ModelRepository(require(__DIR__.'/../config/db.php'));
$router = new Router($modelRepository);

$router->get('/', [TaskController::class, 'list']);
$router->get('/create', [TaskController::class, 'createPage']);
$router->post('/create', [TaskController::class, 'create']);
$router->get('/edit', [TaskController::class, 'editPage']);
$router->post('/edit', [TaskController::class, 'edit']);
$router->get('/auth', [AuthController::class, 'loginPage']);
$router->post('/auth', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
