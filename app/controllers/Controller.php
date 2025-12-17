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

        // Récupère les données POST normales
        $data = $request->data->getData();

        // Récupère manuellement le fichier uploadé depuis $_FILES
        $imageFile = $_FILES['imageColis'] ?? null;

        // Si un fichier est uploadé, on l'ajoute aux données
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $data['imageColis'] = $imageFile;  // On passe le tableau complet
        } else {
            $data['imageColis'] = null;
        }

        // On passe les données (texte + fichier) au modèle
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
    
    function getImgColis($id_colis)
    {
        return $this->model->getImgColis($id_colis);
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

    public function getChauffeur()
    {
        return $this->model->getChauffeur();
    }

    public function addChauffeur()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->addChauffeur($data);
    }

    public function getChauffeurById($id)
    {
        return $this->model->getChauffeurById($id);
    }

    public function deleteChauffeur($id)
    {
        return $this->model->deleteChauffeur($id);
    }

    public function getStatut_chauffeur(){
        $statut = 
        [
            'disponible',
            'en plein livraison',
            'en congé'
        ];
        return $statut;
    }

    public function updateChauffeur()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        $this->model->updateChauffeur($data);
        Flight::redirect('/chauffeurs');
    }

}
