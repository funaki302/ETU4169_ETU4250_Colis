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

    public function getStatuts()
    {
        $sql = "SELECT * FROM gc_statut_trajet";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
