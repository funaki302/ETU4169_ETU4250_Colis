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
        Flight::redirect('/colis');
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

        Flight::redirect('/colis');
    }
    public function addColis()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        $this->model->addColis($data);
        Flight::redirect('/colis');
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

    public function getVoiture()
    {
        return $this->model->getVoiture();
    }

    public function addVoiture()
    {
        $request = Flight::request();
        $data = $request->data->getData();

        $imageFile = $_FILES['imageVoiture'] ?? null;

        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $data['imageVoiture'] = $imageFile;  // On passe le tableau complet
        } else {
            $data['imageVoiture'] = null;
        }

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

    public function getCarburantById($id)
    {
        return $this->model->getCarburantById($id);
    }

    public function getCarburants()
    {
        return $this->model->getCarburants();
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
        // Récupère manuellement le fichier uploadé depuis $_FILES
        $imageFile = $_FILES['profil'] ?? null;

        // Si un fichier est uploadé, on l'ajoute aux données
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $data['profil'] = $imageFile;  // On passe le tableau complet
        } else {
            $data['profil'] = null;
        }
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

    public function getStatut_Chauffeur()
    {
        return $this->model->getStatut_Chauffeur();
    }

    public function getStatut_Voiture()
    {
        return $this->model->getStatut_Voiture();
    }

    public function getStatut_CL()
    {
        return $this->model->getStatut_CL();
    }

    public function updateChauffeur()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        // Récupère manuellement le fichier uploadé depuis $_FILES
        $imageFile = $_FILES['profil'] ?? null;

        // Si un fichier est uploadé, on l'ajoute aux données
        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $data['profil'] = $imageFile;  // On passe le tableau complet
        } else {
            $data['profil'] = null;
        }
        $this->model->updateChauffeur($data);
        Flight::redirect('/chauffeurs');
    }

    public function getLivraisons()
    {
        return $this->model->getLivraisons();
    }

    public function deleteLivraison($id)
    {
        return $this->model->deleteLivraison($id);
    }

    public function getLivraisonById($id)
    {
        return $this->model->getLivraisonById($id);
    }

    public function updateLivraison()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        $this->model->updateLivraison($data);
        Flight::redirect('/livraisons');
    }

    public function addLivraison()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        $this->model->addLivraison($data);
        Flight::redirect('/livraisons');
    }

    public function getChauffeurDispo(){
        return $this->model->getChauffeurDispo();
    }

    public function getColisDispo(){
        return $this->model->getColisDispo();
    }

    public function getLivraisonByIdColis($id){
        return $this->model->getLivraisonByIdColis($id);
    }

    public function insertLivraison()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        $id_livraison = $this->model->addLivraison($data);
        $livraison = $this->model->getLivraisonById($id_livraison);

        $this->model->transaction_Livraison_Colis($livraison);

        Flight::redirect('/livraisons');
    }

    public function editLivraison()
    {
        $request = Flight::request();
        $data = $request->data->getData();
        
        $this->model->transaction_Livraison_Colis($data);

        Flight::redirect('/livraisons');
    }

    public function getvoituresDispo(){
        return $this->model->getVoitureDispo();
    }

    public function getZone(){
        return $this->model->getZone();
    }
    public function updateZone(){
        $request = Flight::request();
        $data = $request->data->getData();
        return $this->model->updateZone($data);
    }
    public function deleteZone($id){
        return $this->model->deleteZone($id);
    }

    public function addZone(){
        $request = Flight::request();
        $data = $request->data->getData();
        return $this->model->addZone($data);
    }
    public function getZoneById($id){
        return $this->model->getZoneById($id);
    }
}