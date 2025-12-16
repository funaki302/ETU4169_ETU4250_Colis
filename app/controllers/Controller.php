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
    private function upload($file, $currentImage)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return $currentImage;
        }

        $uploadDir = __DIR__ . '/../../public/images/';
        $tmpName = $file['tmp_name'];
        $fileName = basename($file['name']);
        $uniqueName = time() . '_' . $fileName;
        $targetPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            return $uniqueName;
        }

        return $currentImage;
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

    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos){
        return $this->model->InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, 
        $adresse_destinataire, $date_expedition, $date_livraison, $kilos);       
    }


}
