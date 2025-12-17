<?php

use app\controllers\Controller;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;


$router->group('', function (Router $router) use ($app) {
    $router->get('/', function () use ($app) {
        $controller = new Controller($app);

        // On utilise la nouvelle méthode avec filtres
        $liste = $controller->listeColisAvecFiltres();

        $app->render('home.php', [
            'liste' => $liste,
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
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

    $router->get('/colis/@id', function ($id) use ($app) {
        $controller = new Controller($app);
        $app->render('detailsColis', [
            'colis' => $controller->getColisById($id),
            'statuts' => $controller->getStatuts(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/colis/update/', function () use ($app) {
        $controller = new Controller($app);
        $controller->updateColis();
    });

    $router->get('/voitures', function () use ($app) {
        $controller = new Controller($app);
        $app->render('voitures', [
            'liste' => $controller->getVoiture(),
            'carburants' => $controller->getCarburants(),
            'statut_voiture' => $controller->getStatut_voiture(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/voitures/add', function () use ($app) {
        $controller = new Controller($app);
        $controller->addVoiture();
    });

    $router->post('/voitures/update/', function() use ($app) {
        $controller = new Controller($app);
        $controller->updateVoiture();
    });

    $router->get('/chauffeurs', function () use ($app) {
        $controller = new Controller($app);
        $app->render('Chauffeurs', [
            'liste' => $controller->getChauffeur(),
            'statut_chauffeur' => $controller->getStatut_chauffeur(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/chauffeurs/add', function () use ($app) {
        $controller = new Controller($app);
        $controller->addChauffeur();
        Flight::redirect('/chauffeurs');
    });

    $router->post('/chauffeurs/delete/@id', function ($id) use ($app) {
        $controller = new Controller($app);
        $controller->deleteChauffeur($id);
        Flight::redirect('/chauffeurs');
    });

    $router->get('/chauffeur/@id', function ($id) use ($app) {
        $controller = new Controller($app);
        $app->render('detailsChauffeur', [
            'chauffeur' => $controller->getChauffeurById($id),
            'statut_chauffeur' => $controller->getStatut_chauffeur(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/chauffeur/update/', function() use ($app) {
        $controller = new Controller($app);
        $controller->updateChauffeur();
    });

    $router->post('/insertColis', function () use ($app) {
        $controller = new Controller($app);

        $nom = $_POST['nom'] ?? '';
        $nom_expediteur = $_POST['nom_expediteur'] ?? '';
        $adresse_expediteur = $_POST['adresse_expediteur'] ?? '';
        $nom_destinataire = $_POST['nom_destinataire'] ?? '';
        $adresse_destinataire = $_POST['adresse_destinataire'] ?? '';
        $date_expedition = $_POST['date_expedition'] ?? null;
        $date_livraison = $_POST['date_livraison'] ?? null;
        $kilos = $_POST['kilos'] ?? 0;
        $images = $_FILES['imageColis'] ?? null;

        $controller->InsertColis(
            $nom,
            $nom_expediteur,
            $adresse_expediteur,
            $nom_destinataire,
            $adresse_destinataire,
            $date_expedition,
            $date_livraison,
            $kilos,
            $images
        );

        \Flight::redirect('/');

    });

    $router->get('/formInsert', function () use ($app) {

        // Affiche la page InsertColis.php
        $app->render('InsertColis', [
            'csp_nonce' => \Flight::get('csp_nonce')
        ]);
    });


}, [SecurityHeadersMiddleware::class]);
