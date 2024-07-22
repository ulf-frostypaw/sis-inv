<?php

require_once __DIR__ . '/Config/constants.php';
require_once __DIR__ . '/Config/database.php';
//require_once __DIR__ . '/Controllers/HomeController.php';

spl_autoload_register(function ($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $classFile = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});

use Core\Router;
use Core\Middleware;

// Load all middlewares
Middleware::load();

$router = new Router();
require_once __DIR__ . '/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


// Despachar la solicitud
$router->dispatch($method, $uri);
