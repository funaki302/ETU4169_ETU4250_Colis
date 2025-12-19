<?php

use app\controllers\Controller;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;


$router->group('', function (Router $router) use ($app) {
    $router->get('/', function () use ($app) {
        $controller = new Controller($app);
        $app->render('accueil', [
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->get('/colis', function () use ($app) {
        $controller = new Controller($app);

        // On utilise la nouvelle méthode avec filtres
        $liste = $controller->listeColisAvecFiltres();

        $app->render('home', [
            'liste' => $liste,
            'statuts' => $controller->getStatut_CL(),
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
            'statuts' => $controller->getStatut_CL(),

            'trajets' => $controller->getZone(),
            'imageColis'=> $controller->getImgColis($id),

            'imageColis' => $controller->getImgColis($id),
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
            'statut_voiture' => $controller->getStatut_Voiture(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/voitures/add', function () use ($app) {
        $controller = new Controller($app);
        $controller->addVoiture();
    });

    $router->post('/voitures/update/', function () use ($app) {
        $controller = new Controller($app);
        $controller->updateVoiture();
    });

    $router->get('/chauffeurs', function () use ($app) {
        $controller = new Controller($app);
        $app->render('Chauffeurs', [
            'liste' => $controller->getChauffeur(),
            'statut_chauffeur' => $controller->getStatut_Chauffeur(),
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
            'statuts' => $controller->getStatut_Chauffeur(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/chauffeur/update/', function () use ($app) {
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

        \Flight::redirect('/colis');

    });

    $router->get('/formInsert', function () use ($app) {

        // Affiche la page InsertColis.php
        $app->render('InsertColis', [
            'csp_nonce' => \Flight::get('csp_nonce')
        ]);
    });

    $router->get('/livraisons', function () use ($app) {
        $controller = new Controller($app);
        $app->render('Livraison', [
            'liste' => $controller->getLivraisons(),
            'voitures' => $controller->getvoituresDispo(),
            'chauffeurs' => $controller->getChauffeurDispo(),
            'colis' => $controller->getColisDispo(),
            'statuts' => $controller->getStatut_CL(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->post('/livraison/add', function () use ($app) {
        $controller = new Controller($app);
        $controller->insertLivraison();
        Flight::redirect('/livraisons');
    });

    $router->post('/livraison/update/', function () use ($app) {
        $controller = new Controller($app);
        $controller->editLivraison();
        Flight::redirect('/livraisons');
    });

    $router->get('/livraison/@id', function ($id) use ($app) {
        $controller = new Controller($app);
        $livraison = $controller->getLivraisonById($id);
        $app->render('detailsLivraison', [
            'livraison' => $livraison,
            'voiture' => $controller->getVoitureById($livraison['id_voiture']),
            'chauffeur' => $controller->getChauffeurById($livraison['id_chauffeur']),
            'colis' => $controller->getColisById($livraison['id_colis']),
            'statuts' => $controller->getStatut_CL(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });


    $router->get('/zones', function () use ($app) {
        $controller = new Controller($app);
        $app->render('ZoneLivraison', [
            'liste' => $controller->getZone(),'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->get('/voiture/benefice/', function () use ($app) {
        $controller = new Controller($app);
        $app->render('BeneficeVoiture', [
            'beneficeVoitures' => $controller->get_beneficeVoiture(),
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->get('/zone/@id', function ($id) use ($app) {
        $controller = new Controller($app);
        $zone = $controller->getZoneById($id);
        $app->render('detailsZone', [
            'zone' => $zone,
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
    });

    $router->get('/zone/update', function () use ($app) {
        $controller = new Controller($app);
        $controller->updateZone();
        Flight::redirect('/zones');
    });

    $router->post('/zone/add', function () use ($app) {
        $controller = new Controller($app);
        $controller->addZone();
        Flight::redirect('/zones');
    });

    $router->get('/zone/delete/@id', function ($id) use ($app)
    {
        $controller = new Controller($app);
        $controller->deleteZone($id);
        Flight::redirect('/zones');
    });

    $router->get('/voitures/details//@id', function ($id) use ($app)
    {
        $controller = new Controller($app);
         $zone = $controller->get_beneficeById( $id );
        $app->render('detailsVoiture', [
            'benefice' => $zone,
            'csp_nonce' => Flight::get('csp_nonce')
        ]);
       
    });


}, [SecurityHeadersMiddleware::class]);
