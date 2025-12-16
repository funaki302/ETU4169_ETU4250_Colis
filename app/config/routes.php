<?php

use app\controllers\Controller;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;


$router->group('', function (Router $router) use ($app) {

    $router->get('/', function() use ($app) {
        $controller = new Controller($app);
        $app->render('home' , ['liste' => $controller->getColis() , 'csp_nonce' => Flight::get('csp_nonce')]);
    });

  
    $router->get('/benefices', function () use ($app) {
        $controller = new Controller($app);
        $beneficeAnne = $controller->getBenefitParAnne();
        $beneficeMois = $controller->getBenefitParMois();
        $beneficeJour = $controller->getBenefitParJour();
        $app->render('Benefice', [
            'beneficeAnne' => $beneficeAnne,
            'beneficeMois' => $beneficeMois,
            'beneficeJour' => $beneficeJour,
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });


}, [SecurityHeadersMiddleware::class]);
