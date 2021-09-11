<?php
session_start();

use Libraries\Router\Router;

require_once __DIR__.'/../bootstrap/autoloader.php';
require_once __DIR__.'/../bootstrap/router.php';

/**
 * @var Router $router
 */
$router->dispatch();