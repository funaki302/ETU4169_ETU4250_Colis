<?php

namespace app\models;

class Model
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getBenefitParAnne()
    {
        $sql = "SELECT * FROM V_gc_BeneficeAnnee";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getBenefitParJour()
    {
        $sql = "SELECT * FROM V_gc_BeneficeJour";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBenefitParMois()
    {
        $sql = "SELECT * FROM V_gc_BeneficeMois";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getColis()
    {
        $sql = "SELECT * FROM gc_colis";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateColis($data)
    {
        $id = $data['id'] ?? $data['id_colis'] ?? null;
        if ($id === null) { return; }

        $date_expedition = !empty($data['date_expedition'])
            ? $data['date_expedition']
            : null;

        $provided_date_liv = $data['date_livraison'] ?? null;
        $statutVal = $data['id_statut'] ?? null;
        if (($statutVal == 2)) {
            $date_livraison = !empty($provided_date_liv) ? $provided_date_liv : date('Y-m-d');
        } else {
            $date_livraison = null;
        }

        $sql = "UPDATE gc_colis SET nom_expediteur = ?, adresse_expediteur = ?,
            nom_destinataire = ?, adresse_destinataire = ?, date_expedition = ?,
            date_livraison = ?, kilos = ? , id_statut = ?, nom_colis = ?
        WHERE id_colis = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_expediteur'] ?? '',
            $data['adresse_expediteur'] ?? '',
            $data['nom_destinataire'] ?? '',
            $data['adresse_destinataire'] ?? '',
            $date_expedition,
            $date_livraison,
            $data['kilos'] ?? 0,
            $data['id_statut'] ?? 1,
            $data['nom_colis'] ?? '',
            $id
        ]);
    }

    public function addColis($data)
    {
        $date_expedition = !empty($data['date_expedition'])
            ? $data['date_expedition']
            : null;

        $date_livraison = !empty($data['date_livraison'])
            ? $data['date_livraison']
            : null;
        $sql = "INSERT INTO gc_colis 
            (nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, 
            date_expedition, date_livraison, kilos, id_statut,nom_colis) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_expediteur'] ?? '',
            $data['adresse_expediteur'] ?? '',
            $data['nom_destinataire'] ?? '',
            $data['adresse_destinataire'] ?? '',
            $date_expedition,  
            $date_livraison,  
            $data['kilos'] ?? 0,
            $data['id_statut'] ?? 1,
            $data['nom_colis'] ?? ''
        ]);
        return $this->db->lastInsertId();
    }

    public function deleteColis($id)
    {
        if ($id === null) { return; }
        $sql = "DELETE FROM gc_colis WHERE id_colis = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }
    public function getColisById($id)
    {
        if ($id === null) { return; }
        $sql = "SELECT * FROM gc_colis WHERE id_colis = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos){
        $sql = "INSERT INTO gc_colis 
        (nom_colis, nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, date_expedition, date_livraison, kilos, id_statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getStatuts()
    {
        $sql = "SELECT * FROM gc_statut_trajet";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getVoiture(){
        $sql = "SELECT * FROM gc_voiture";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getVoitureById($id){
        if ($id === null) { return; }
        $sql = "SELECT * FROM gc_voiture WHERE id_voiture = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateVoiture($data){
        $id = $data['id_voiture'] ?? null;
        if ($id === null) { return; }

        $sql = "UPDATE gc_voiture SET immatriculation = ?, marque = ?, modele = ?,
        capacite = ?,statut_voiture = ?, id_carburant = ? WHERE id_voiture = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['immatriculation'] ?? '',
            $data['marque'] ??'',
            $data['modele'] ?? '',
            $data['capacite'] ?? 1,
            $data['statut_voiture'] ?? '',
            $data['id_carburant'] ?? 1,
            $id
        ]);
    }

    public function deleteVoiture($id)
    {
        if ($id === null) { return; }
        $sql = "DELETE FROM gc_voiture WHERE id_voiture = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function addVoiture($data){
        $sql = "INSERT INTO gc_voiture 
        (immatriculation, marque, modele, capacite, statut_voiture, id_carburant)
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['immatriculation'] ?? '',
            $data['marque'] ??'',
            $data['modele'] ?? '',
            $data['capacite'] ?? 1,
            $data['statut_voiture'] ?? '',
            $data['id_carburant'] ?? 1
        ]);
        return $this->db->lastInsertId();
    }

    
}
