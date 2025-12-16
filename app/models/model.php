<?php

namespace app\models;

class Model {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProduits() {
        $sql = "SELECT * FROM produits";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProduit($id) {
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertProduit($data) {
        $sql = "INSERT INTO produits (p_name, p_image, p_price, p_description) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['p_name'] ?? '',
            $data['p_image'] ?? '1.jpg',
            $data['p_price'] ?? 0,
            $data['p_description'] ?? ''
        ]);
        return $this->db->lastInsertId();
    }

    public function updateProduit($data) {
        $sql = "UPDATE produits SET p_name=?, p_image=?, p_price=?, p_description=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['p_name'] ?? '',
            $data['p_image'] ?? '1.jpg',
            $data['p_price'] ?? 0,
            $data['p_description'] ?? '',
            $data['id']
        ]);
    }

    public function deleteProduit($id) {
        $sql = "DELETE FROM produits WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function getTrajetsByDate() {
        $sql = "SELECT * FROM V_gt_trajet_detaillee";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

<<<<<<< HEAD

    public function getBenefitParAnne() {
        $sql = "SELECT * FROM V_gc_BeneficeAnnee";
=======
    public function getBenefitParJour() {

    }
    public function getBenefitParJour() {
        $sql = "SELECT * FROM V_gc_BeneficeJour";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBenefitParMois() {
        $sql = "SELECT * FROM V_gc_BeneficeMois";
>>>>>>> dd706f236a0fcfc6544de7e14e148a2a2c2dd978
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
