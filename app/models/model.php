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
        $sql = "UPDATE gc_colis SET nom_expediteur = ?, adresse_expediteur = ?,
            nom_destinataire = ?, adresse_destinataire = ?, date_expedition = ?, 
            date_livraison = ?, kilos = ? , id_statut = ?
        WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_expediteur'] ?? '',
            $data['adresse_expediteur'] ?? '',
            $data['nom_destinataire'] ?? '',
            $data['adresse_destinataire'] ?? '',
            $data['date_expedition'] ?? null,
            $data['date_livraison'] ?? null,   
            $data['kilos'] ?? 0,
            $data['id_statut'] ?? 1,
            $data['id']
        ]);
    }

    public function addColis($data)
    {
        $sql = "INSERT INTO gc_colis 
            (nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, 
            date_expedition, date_livraison, kilos, id_statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_expediteur'] ?? '',
            $data['adresse_expediteur'] ?? '',
            $data['nom_destinataire'] ?? '',
            $data['adresse_destinataire'] ?? '',
            $data['date_expedition'] ?? null,
            $data['date_livraison'] ?? null,   
            $data['kilos'] ?? 0,
            $data['id_statut'] ?? 1
        ]);
        return $this->db->lastInsertId();
    }

    public function deleteColis($data)
    {
        $sql = "DELETE FROM gc_colis WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$data['id']]);
    }
    public function getColisById($id)
    {
        $sql = "SELECT * FROM gc_colis WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos){
        $sql = "INSERT INTO gc_colis 
        (nom, nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, date_expedition, date_livraison, kilos, id_statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
