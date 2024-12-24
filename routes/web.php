<?php

$router = new Router();
$router->get('/', [LandingController::class, 'index']);
$router->get('/login', [LandingController::class, 'index']);

// Ruta protegida
$router->group([AuthGuard::class], function () use ($router) {
    $router->get('/dashboard', [LandingController::class, 'index']);
});

$request = new Request();
$router->dispatch($request, $_SERVER['REQUEST_METHOD']);
