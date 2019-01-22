<?php

// PSR-7 router
use Aura\Router\RouterContainer;

use Zend\Diactoros\Response;

// Middleware
use WoohooLabs\Harmony\Harmony;
use WoohooLabs\Harmony\Middleware\HttpHandlerRunnerMiddleware;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;
use WoohooLabs\Harmony\Middleware\DispatcherMiddleware;

$container = new DI\Container();

// PSR-7 router
$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

// Routes name url file
require_once '../routes/web.php';

$matcher = $routerContainer->getMatcher();
$route = $matcher->match($request);

if (!$route) {
    echo 'Route not found';
} else {
    // Middleware section
    $harmony = new Harmony($request, new Response());
    $harmony
        ->addMiddleware(new HttpHandlerRunnerMiddleware(new SapiEmitter()))
        ->addMiddleware(new App\Middlewares\AuthMiddleware())
        ->addMiddleware(new Middlewares\AuraRouter($routerContainer))
        ->addMiddleware(new DispatcherMiddleware($container, 'request-handler'));

    $harmony();
}