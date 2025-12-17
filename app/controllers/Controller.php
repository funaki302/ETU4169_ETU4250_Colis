<?php

namespace app\controllers;
use app\models\model;
use Flight;
use flight\Engine;

class Controller
{
    protected Engine $app;
    protected model $model;

    public function __construct($app)
    {
        $this->app = $app;
        $this->model = new model(Flight::db());
    }
    public function getColis()
    {
        return $this->model->getColis();
    }
    public function deleteColis($id)
    {
        $this->model->deleteColis($id);
        Flight::redirect('/');
    }
    public function updateColis()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->updateColis($data);
        Flight::redirect('/');
    }
    public function addColis()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->addColis($data);
        Flight::redirect('/');
    }
    public function getColisById($id)
    {
        return $this->model->getColisById($id);
    }

    public function getBenefitParAnne()
    {
        return $this->model->getBenefitParAnne();
    }

    public function getBenefitParMois()
    {
        return $this->model->getBenefitParMois();
    }

    public function getBenefitParJour()
    {
        return $this->model->getBenefitParJour();
    }


    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos, $imageColis)
    {
        return $this->model->InsertColis(
            $nom,
            $nom_expediteur,
            $adresse_expediteur,
            $nom_destinataire,
            $adresse_destinataire,
            $date_expedition,
            $date_livraison,
            $kilos,
            $imageColis
        );
    }

    public function getStatuts()
    {
        return $this->model->getStatuts();
    }

    public function getVoiture()
    {
        return $this->model->getVoiture();
    }

    public function addVoiture()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->addVoiture($data);
        Flight::redirect('/voitures');
    }

    public function updateVoiture()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        $this->model->updateVoiture($data);
        Flight::redirect('/voitures');
    }

    public function deleteVoiture($id)
    {
        return $this->model->deleteVoiture($id);
    }

    public function getVoitureById($id)
    {
        return $this->model->getVoitureById($id);
    }

    public function getCarburantById($id){
        return $this->model->getCarburantById($id);
    }

    public function getCarburants(){
        return $this->model->getCarburants();
    }

    public function getStatut_voiture(){
        $statut = 
        [
            'disponible',
            'en cours de livraison',
            'maintenance'
        ];
        return $statut;
    }
    
    function getImgColis()
    {
        return $this->model->getImgColis();
    }

    public function listeColisAvecFiltres()
    {
        $statut = $_GET['statut'] ?? null;
        if ($statut === 'tous' || $statut === '') {
            $statut = null;
        }

        $dateMin = !empty($_GET['date_min']) ? $_GET['date_min'] : null;
        $dateMax = !empty($_GET['date_max']) ? $_GET['date_max'] : null;
        $nom = !empty($_GET['nom']) ? trim($_GET['nom']) : null;

        return $this->model->critereColis($statut, $dateMin, $dateMax, $nom);
    }

}
