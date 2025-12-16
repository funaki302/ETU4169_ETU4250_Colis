<?php

use app\controllers\ProductController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

$router->group('', function(Router $router) use ($app) {
    $router->get('/', function() use ($app) {
        $controller = new ProductController($app);
        $app->render('home' , ['liste' => $controller->getTrajetsByDate() , 'csp_nonce' => Flight::get('csp_nonce')]);
    });
 

}, [ SecurityHeadersMiddleware::class ]);
