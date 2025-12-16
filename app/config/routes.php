<?php

use app\controllers\Controller;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

$router->group('', function(Router $router) use ($app) {
    $router->get('/', function() use ($app) {
        $controller = new Controller($app);
        $app->render('home' , ['liste' => $controller->getColis() , 'csp_nonce' => Flight::get('csp_nonce')]);
    });
 

}, [ SecurityHeadersMiddleware::class ]);
