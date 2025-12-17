<?php

namespace app\controllers;
use app\models\model;
use Flight;
use flight\Engine;

class Controller {
    protected Engine $app;
    protected model $model;

    public function __construct($app) {
        $this->app = $app;
        $this->model = new model(Flight::db());
    }
    public function getColis() {
        return $this->model->getColis();
    }
    public function deleteColis($id) {
        $this->model->deleteColis($id);
        Flight::redirect('/');
    }
    public function updateColis() {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->updateColis($data);
        Flight::redirect('/');
    }
    public function addColis() {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->addColis($data);
        Flight::redirect('/');
    }
    public function getColisById($id) {
        return $this->model->getColisById($id);
    }

    public function getBenefitParAnne() {
        return $this->model->getBenefitParAnne();
    }

    public function getBenefitParMois() {
        return $this->model->getBenefitParMois();
    }

    public function getBenefitParJour() {
        return $this->model->getBenefitParJour();
    }


    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos,$imageColis){
        return $this->model->InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, 
        $adresse_destinataire, $date_expedition, $date_livraison, $kilos,$imageColis);       
    }

    public function getStatuts() {
        return $this->model->getStatuts();
    }


}
