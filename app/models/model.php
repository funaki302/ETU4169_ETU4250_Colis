<?php

namespace app\models;

class Model
{
    protected $db;

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

        $uniqueName = uniqid('IMG_', true) . '.' . $ext;
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
        if (!$id) {
            return;
        }

        // === UPLOAD IMAGE SI UNE PHOTO EST ENVOYÉE ===
        if (isset($data['imageColis']) && is_array($data['imageColis']) && $data['imageColis']['error'] === UPLOAD_ERR_OK) {
            $newname = $this->upload($data['imageColis']);
            if ($newname) {
                $this->insertImageColis($id, $newname);
                error_log("Image ajoutée avec succès pour le colis $id : $newname");
            } else {
                error_log("Échec de l'upload pour le colis $id");
            }
        }

        // === GESTION DATE LIVRAISON SELON STATUT ===
        $date_livraison = null;
        if (isset($data['id_statut']) && $data['id_statut'] == 2) {
            $date_livraison = !empty($data['date_livraison']) ? $data['date_livraison'] : date('Y-m-d');
        }

        // === MISE À JOUR DES CHAMPS DU COLIS ===
        $sql = "UPDATE gc_colis SET
                nom_colis = ?,
                nom_expediteur = ?,
                adresse_expediteur = ?,
                nom_destinataire = ?,
                adresse_destinataire = ?,
                date_expedition = ?,
                date_livraison = ?,
                kilos = ?,
                id_statut = ?,
                id_trajet = ?
            WHERE id_colis = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_colis'] ?? '',
            $data['nom_expediteur'] ?? '',
            $data['adresse_expediteur'] ?? '',
            $data['nom_destinataire'] ?? '',
            $data['adresse_destinataire'] ?? '',
            $data['date_expedition'] ?? null,
            $date_livraison,
            $data['kilos'] ?? 0,
            $data['id_statut'] ?? 1,
            $data['id_trajet'] ?? null,
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

    public function addColis($data)
    {
        $sql = "INSERT INTO gc_colis 
        (nom_colis, nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire,
        date_expedition, date_livraison, kilos, id_statut,id_trajet)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_colis'] ?? '',
            $data['nom_expediteur'] ?? '',
            $data['adresse_expediteur'] ?? '',
            $data['nom_destinataire'] ?? '',
            $data['adresse_destinataire'] ?? '',
            $data['date_expedition'] ?? null,
            $data['date_livraison'] ?? null,
            $data['kilos'] ?? 0,
            $data['id_statut'] ?? 1,
            $data['id_trajet'] ?? null,
        ]);
        return $this->db->lastInsertId();
    }

    public function InsertColis($nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos, $imageFile = null,$id_trajet)
    {
        $sql = "INSERT INTO gc_colis
            (nom_colis, nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, date_expedition, date_livraison, kilos, id_statut, id_trajet)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nom, $nom_expediteur, $adresse_expediteur, $nom_destinataire, $adresse_destinataire, $date_expedition, $date_livraison, $kilos, 1, $id_trajet]);
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

    public function getStatut_CL()
    {
        $sql = "SELECT * FROM gc_statut_CL";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getStatut_Voiture()
    {
        $sql = "SELECT * FROM gc_statut_Voiture";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getStatut_Chauffeur()
    {
        $sql = "SELECT * FROM gc_statut_Chauffeur";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getVoiture()
    {
        $sql = "SELECT * FROM gc_voiture";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getVoitureById($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "SELECT * FROM gc_voiture WHERE id_voiture = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateVoiture($data)
    {
        $id = $data['id_voiture'] ?? null;
        if ($id === null) {
            return;
        }

        $sql = "UPDATE gc_voiture SET immatriculation = ?, marque = ?, modele = ?,
        capacite = ?,statut_voiture = ?, id_carburant = ?, id_statut = ? WHERE id_voiture = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['immatriculation'] ?? '',
            $data['marque'] ?? '',
            $data['modele'] ?? '',
            $data['capacite'] ?? 1,
            $data['statut_voiture'] ?? '',
            $data['id_carburant'] ?? 1,
            $data['id_statut'] ?? 1,
            $id
        ]);
    }

    public function deleteVoiture($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "DELETE FROM gc_voiture WHERE id_voiture = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function addVoiture($data)
    {
        $imageVoiture = "" ;
          // === UPLOAD IMAGE SI UNE PHOTO EST ENVOYÉE ===
        if (isset($data['imageVoiture']) && is_array($data['imageVoiture']) && $data['imageVoiture']['error'] === UPLOAD_ERR_OK) {
            $newname = $this->upload($data['imageVoiture']);
            if ($newname) {
              $imageVoiture = $newname;
            } else {
                error_log("Échec de l'upload pour le imageVoiture chauffeur");
            }
        }
        $sql = "INSERT INTO gc_voiture 
        (immatriculation, marque, modele, capacite, id_statut, id_carburant,imageVoiture)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['immatriculation'] ?? '',
            $data['marque'] ?? '',
            $data['modele'] ?? '',
            $data['capacite'] ?? 1,
            $data['id_statut'] ?? 1,
            $data['id_carburant'] ?? 1,
            $imageVoiture ?? ''
        ]);
        return $this->db->lastInsertId();
    }

    public function getCarburants()
    {
        $sql = "SELECT * FROM gc_carburant";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addCarburant($data)
    {
        $sql = "INSERT INTO gc_carburant (type_carburant,prix_litre,date_dernier_approvisionnement) 
        VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['type_carburant'] ?? '',
            $data['prix_litre'] ?? 0.0,
            $data['date_dernier_approvisionnement'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    public function getImgColis($id_colis)
    {
        $sql = "SELECT imageColis FROM gc_photos_colis WHERE id_colis = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_colis]);
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Si pas de résultat → tableau vide
        return $results ?: [];
    }

    public function getCarburantById($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "SELECT * FROM gc_carburant WHERE id_carburant = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function critereColis($statut = null, $dateMin = null, $dateMax = null, $nom = null)
    {
        $sql = "SELECT * FROM V_gc_ColisImg WHERE 1=1";
        $params = [];

        if ($statut !== null) {
            $sql .= " AND id_statut = ?";
            $params[] = (int) $statut;
        }

        if ($dateMin !== null) {
            $sql .= " AND date_expedition >= ?";
            $params[] = $dateMin;
        }

        if ($dateMax !== null) {
            $sql .= " AND date_expedition <= ?";
            $params[] = $dateMax;
        }

        if ($nom !== null) {
            $sql .= " AND nom_colis LIKE ?";
            $params[] = '%' . $nom . '%';
        }

        $sql .= " ORDER BY id_colis DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getChauffeur()
    {
        $sql = "SELECT * FROM gc_chauffeur";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getChauffeurById($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "SELECT * FROM gc_chauffeur WHERE id_chauffeur = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteChauffeur($id)
    {
        if ($id === null) {
            return;
        }
        $sql = "DELETE FROM gc_chauffeur WHERE id_chauffeur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function updateChauffeur($data)
    {
        $id = $data['id_chauffeur'] ?? null;
        if ($id === null) {
            return;
        }

        $profil_actuel = $data['profil_actuel'] ?? '' ;

        $profil = "" ;
          // === UPLOAD IMAGE SI UNE PHOTO EST ENVOYÉE ===
        if (isset($data['profil']) && is_array($data['profil']) && $data['profil']['error'] === UPLOAD_ERR_OK) {
            $newname = $this->upload($data['profil']);
            if ($newname) {
              $profil = $newname;
            } else {
                error_log("Échec de l'upload pour le profil chauffeur");
            }
        }
        if ($profil === "" ) {
            $profil = $profil_actuel ;
        }

        $sql = "UPDATE gc_chauffeur SET nom_chauffeur = ?, prenom_chauffeur = ?, 
        telephone_chauffeur = ?, email_chauffeur = ?,
        date_dassignation = ?, salaires_parLiv = ?, 
        profil = ?, id_statut = ?
        WHERE id_chauffeur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_chauffeur'] ?? '',
            $data['prenom_chauffeur'] ?? '',
            $data['telephone_chauffeur'] ?? '',
            $data['email_chauffeur'] ?? '',
            $data['date_dassignation'] ?? null,
            $data['salaires_parLiv'] ?? 0,
            $profil ?? '',
            $data['id_statut'] ?? 1,
            $id
        ]);
    }

    public function addChauffeur($data)
    {
        $profil = "" ;
          // === UPLOAD IMAGE SI UNE PHOTO EST ENVOYÉE ===
        if (isset($data['profil']) && is_array($data['profil']) && $data['profil']['error'] === UPLOAD_ERR_OK) {
            $newname = $this->upload($data['profil']);
            if ($newname) {
              $profil = $newname;
            } else {
                error_log("Échec de l'upload pour le profil chauffeur");
            }
        }
        
        $sql = "INSERT INTO gc_chauffeur 
        (nom_chauffeur, prenom_chauffeur, telephone_chauffeur, email_chauffeur,
        date_dassignation, salaires_parLiv,profil, id_statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['nom_chauffeur'] ?? '',
            $data['prenom_chauffeur'] ?? '',
            $data['telephone_chauffeur'] ?? '',
            $data['email_chauffeur'] ?? '',
            $data['date_dassignation'] ?? null,
            $data['salaires_parLiv'] ?? 0.0,
            $profil ?? '',
            $data['id_statut'] ?? 1
        ]);
        return $this->db->lastInsertId();
    }

    public function getLivraisons(){
        $sql = "SELECT * FROM gc_livraison";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLivraisonById($id){
        if ($id === null) {
            return;
        }
        $sql = "SELECT * FROM gc_livraison WHERE id_livraison = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteLivraison($id){
        if ($id === null) {
            return;
        }
        $sql = "DELETE FROM gc_livraison WHERE id_livraison = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function updateLivraison($data){
        if ($data === null) {
            return;
        }
        
        $sql = "UPDATE gc_livraison set id_colis = ?,
        date_livraison = ? , heure_livraison = ?, id_statut = ?,
        id_chauffeur = ?, id_voiture = ? WHERE id_livraison = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['id_colis'] ?? null,
            $data['date_livraison'] ?? null,
            $data['heure_livraison'] ?? null,
            $data['id_statut'] ?? null,
            $data['id_chauffeur'] ?? null,
            $data['id_voiture'] ?? null,
            $data['id_livraison'] ?? null
        ]);
    }

    public function addLivraison($data){
        $sql = "INSERT INTO gc_livraison 
        (id_colis, date_livraison, heure_livraison, id_statut, id_chauffeur, id_voiture)
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['id_colis'] ?? null,
            $data['date_livraison'] ?? null,
            $data['heure_livraison'] ?? null,
            $data['id_statut'] ?? null,
            $data['id_chauffeur'] ?? null,
            $data['id_voiture'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    public function getChauffeurDispo(){
        $sql = "SELECT * FROM gc_chauffeur WHERE id_statut = 1";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getColisDispo(){
        $sql = "SELECT * FROM gc_colis WHERE id_statut = 1";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getVoitureDispo(){
        $sql = "SELECT * FROM gc_voiture WHERE id_statut = 1";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLivraisonByIdColis($id_colis){
        $sql = "SELECT * FROM gc_livraison WHERE id_colis = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_colis]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function transactionLivraisonColis1( $data_livraison): bool
    {
        if (empty($data_livraison['id_colis']) || empty($data_livraison['id_statut'])) {
            error_log("transactionLivraisonColis : données incomplètes");
            return false;
        }

        $id_colis       = $data_livraison['id_colis'];
        $nouveau_statut = (int) $data_livraison['id_statut'];
        $date_livraison = $data_livraison['date_livraison'] ?? null;
        $id_chauffeur   = $data_livraison['id_chauffeur'] ?? null;
        $id_voiture     = $data_livraison['id_voiture'] ?? null;

        // Définition des statuts "occupés"
        $statut_occupé_chauffeur = 'en plein livraison';
        $statut_libre_chauffeur  = 'disponible';

        $this->db->beginTransaction();

        try {
            //  Récupérer le colis
            $colis = $this->getColisById($id_colis);
            if (!$colis) {
                throw new \Exception("Colis introuvable (ID: $id_colis)");
            }


            //  Récupérer chauffeur et voiture
            $chauffeur = $this->getChauffeurById($id_chauffeur);
            $voiture   = $this->getVoitureById($id_voiture);

            if (!$chauffeur || !$voiture) {
                throw new \Exception("Chauffeur ou voiture introuvable");
            }

            $nouveau_statut_chauffeur = $data_livraison['id_statut'] === 1 ? $statut_occupé_chauffeur : $statut_libre_chauffeur;

          // Préparer les données pour les mises à jour
            // Mise à jour du COLIS
            $data_colis = $colis;
            $data_colis['id_statut']     = $nouveau_statut;
            $data_colis['date_livraison']= $date_livraison;

            // Mise à jour du CHAUFFEUR
            $data_chauffeur = $chauffeur;
            $data_chauffeur['id_chauffeur'] = $chauffeur['id_chauffeur'];
            $data_chauffeur['statut']       = $nouveau_statut_chauffeur;

            // Mise à jour de la VOITURE
            $data_voiture = $voiture;
            $data_voiture['id_voiture']     = $voiture['id_voiture'];

            // 6. Exécuter les mises à jour
            $idL = $this->addLivraison($data_livraison);
            $this->updateColis($data_colis);
            $this->updateChauffeur($data_chauffeur);
            $this->updateVoiture($data_voiture);

            $this->db->commit();
            error_log("TransactionLivraisonColis réussie pour colis ID $id_colis (statut $nouveau_statut)");
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur transactionLivraisonColis (colis $id_colis) : " . $e->getMessage());
            return false;
        }
    }

    // Mise à jour uniquement du statut et date_livraison du colis
    public function update_StatDate_Colis($id_colis, $id_statut, $date_livraison = null)
    {
        $sql = "UPDATE gc_colis SET id_statut = ?, date_livraison = ? WHERE id_colis = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_statut, $date_livraison, $id_colis]);
    }

    // Mise à jour uniquement du statut du chauffeur
    public function update_Stat_Chauffeur($id_chauffeur, $id_statut)
    {
        $sql = "UPDATE gc_chauffeur SET id_statut = ? WHERE id_chauffeur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_statut, $id_chauffeur]);
    }

    // Mise à jour uniquement du statut de la voiture (si tu en as besoin)
    public function update_Stat_Voiture($id_voiture, $id_statut)
    {
        $sql = "UPDATE gc_voiture SET id_statut = ? WHERE id_voiture = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_statut, $id_voiture]);
    }

    public function transaction_Livraison_Colis($data_livraison): bool
    {
        if (empty($data_livraison['id_colis']) || empty($data_livraison['id_statut'])) {
            error_log("transactionLivraisonColis : données incomplètes");
            return false;
        }

        $id_colis       = $data_livraison['id_colis'];
        $nouveau_statut = (int) $data_livraison['id_statut'];
        $date_livraison = $data_livraison['date_livraison'] ?? null;
        $id_chauffeur   = $data_livraison['id_chauffeur'] ?? null;
        $id_voiture     = $data_livraison['id_voiture'] ?? null;

        // Définition des statuts "occupés"
        $statut_occupé_chauffeur = 2; // id pour "en plein livraison"
        $statut_libre_chauffeur  = 1; // id pour "disponible"

        $statut_occupé_voiture   = 2; // id pour "en livraison"
        $statut_libre_voiture    = 1; // id pour "disponible"

        $this->db->beginTransaction();
        try {
            //  Récupérer le colis
            $colis = $this->getColisById($id_colis);
            if (!$colis) {
                throw new \Exception("Colis introuvable (ID: $id_colis)");
            }


            //  Récupérer chauffeur et voiture
            $chauffeur = $this->getChauffeurById($id_chauffeur);
            $voiture   = $this->getVoitureById($id_voiture);

            if (!$chauffeur || !$voiture) {
                throw new \Exception("Chauffeur ou voiture introuvable");
            }

            $nouveau_statut_chauffeur = $nouveau_statut == 2 ? $statut_occupé_chauffeur : $statut_libre_chauffeur ;
            $nouveau_statut_voiture   = $nouveau_statut == 2 ? $statut_occupé_voiture : $statut_libre_voiture ;

            // 1. Update la livraison
            $this->updateLivraison($data_livraison);

            // 2. Mettre à jour seulement ce qui est nécessaire
            $this->update_StatDate_Colis($id_colis, $nouveau_statut, $date_livraison);
            $this->update_Stat_Chauffeur($id_chauffeur, $nouveau_statut_chauffeur);
            $this->update_Stat_Voiture($id_voiture, $nouveau_statut_voiture);

            $this->db->commit();
            error_log("Transaction réussie pour colis $id_colis");
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log("Erreur transaction : " . $e->getMessage());
            return false;
        }
    }

    public function getZone() {
        $sql = "SELECT * FROM gc_trajet_colis";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getZoneById($id){
        $sql = "SELECT * FROM gc_trajet_colis WHERE id_trajet = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteZone($id){
        $sql = "DELETE FROM gc_trajet_colis WHERE id_trajet = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    public function updateZone($data){
        $sql = "UPDATE gc_trajet_colis SET adresse_depart = ?, adresse_arrivee = ?,
        taux = ? , dispo = ? 
        WHERE id_trajet = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['adresse_depart'] ?? '',
            $data['adresse_arrivee'] ??'',
            $data['taux'] ?? 0,
            $data['dispo'] ?? 0,
            $data['id_trajet']
        ]);
    }

    public function addZone($data){
        $sql = "INSERT INTO gc_trajet_colis(adresse_depart,adresse_arrivee,taux,dispo)
        VALUE (?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['adresse_depart'] ?? '',
            $data['adresse_arrivee'] ??'',
            $data['taux'] ?? 0,
            $data['dispo'] ?? 0
        ]);

        return $this->db->lastInsertId();
    }

    public function get_beneficeVoiture() {
    $stmt = $this->db->query("SELECT * FROM V_gc_BeneficeParVoiture ORDER BY benefice_net DESC");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
}
