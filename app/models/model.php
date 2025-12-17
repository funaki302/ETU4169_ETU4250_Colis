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

        $id = $data['id_colis'] ?? null;
        if ($id === null) {
            return;
        }

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

    public function deleteColis($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "DELETE FROM gc_colis WHERE id_colis = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function getColisById($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "SELECT * FROM gc_colis WHERE id_colis = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function upload($file)
    {
        // Debug : affiche ce qu'on reçoit
        error_log("Fichier reçu dans upload : " . print_r($file, true));

        if (!$file || !isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            $errorCode = $file['error'] ?? 'inconnu';
            error_log("Erreur upload - Code : " . $errorCode);
            return null;
        }

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            error_log("Extension non autorisée : " . $ext);
            return null;
        }

        $uploadDir = __DIR__ . '/../../public/images/';

        // Vérifie que le dossier existe
        if (!is_dir($uploadDir)) {
            error_log("Dossier d'upload inexistant : " . $uploadDir);
            if (!mkdir($uploadDir, 0777, true)) {
                error_log("Échec création dossier");
                return null;
            }
        }

        // Vérifie que c'est écrivable
        if (!is_writable($uploadDir)) {
            error_log("Dossier non écrivable : " . $uploadDir);
            return null;
        }

        $uniqueName = uniqid('colis_', true) . '.' . $ext;
        $targetPath = $uploadDir . $uniqueName;

        error_log("Tentative de déplacement vers : " . $targetPath);

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            error_log("Upload réussi : " . $uniqueName);
            return $uniqueName;
        }

        error_log("Échec move_uploaded_file. tmp_name : " . $file['tmp_name']);
        return null;
    }

    function insertImageColis($idColis, $image)
    {
        $sql = 'INSERT into gc_photos_colis (id_colis , imageColis) values (?,?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idColis, $image]);

    }

    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos, $imageFile = null)
    {
        $sql = "INSERT INTO gc_colis
            (nom_colis, nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, date_expedition, date_livraison, kilos, id_statut)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos]);

        $idColis = $this->db->lastInsertId();
        error_log("Colis inséré avec ID : " . $idColis);

        if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
            $newname = $this->upload($imageFile);
            if ($newname) {
                $this->insertImageColis($idColis, $newname);
                error_log("Image liée au colis : " . $newname);
            } else {
                error_log("Échec upload de l'image pour colis " . $idColis);
            }
        } else {
            error_log("Aucun fichier image valide reçu");
        }

        return $idColis;
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

    public function getCarburants(){
        $sql = "SELECT * FROM gc_carburant";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCarburantById($id){
        if ($id === null) { return; }
        $sql = "SELECT * FROM gc_carburant WHERE id_carburant = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }


}
