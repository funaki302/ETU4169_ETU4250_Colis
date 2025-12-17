/* =========================
RESET BASE
========================= */
DROP DATABASE IF EXISTS gestion_colis;

CREATE DATABASE gestion_colis CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_general_ci;

USE gestion_colis;

/* =========================
TABLES
========================= */
CREATE TABLE
    gc_statut_trajet (
        id_statut INT AUTO_INCREMENT PRIMARY KEY,
        description_statut VARCHAR(50) NOT NULL
    );

CREATE TABLE
    gc_carburant (
        id_carburant INT AUTO_INCREMENT PRIMARY KEY,
        type_carburant VARCHAR(50) NOT NULL,
        prix_litre DOUBLE NOT NULL,
        date_dernier_approvisionnement DATE
    );

CREATE TABLE
    gc_voiture (
        id_voiture INT AUTO_INCREMENT PRIMARY KEY,
        immatriculation VARCHAR(50) UNIQUE NOT NULL,
        marque VARCHAR(50),
        modele VARCHAR(50),
        capacite INT NOT NULL,
        statut_voiture ENUM (
            'disponible',
            'en cours de livraison',
            'maintenance'
        ),
        id_carburant INT
    );

CREATE TABLE
    gc_colis (
        id_colis INT AUTO_INCREMENT PRIMARY KEY,
        nom_expediteur VARCHAR(100) NOT NULL,
        adresse_expediteur VARCHAR(255) NOT NULL,
        nom_destinataire VARCHAR(100) NOT NULL,
        adresse_destinataire VARCHAR(255) NOT NULL,
        date_expedition DATE NOT NULL,
        date_livraison DATE,
        kilos DOUBLE NOT NULL,
        id_statut INT
    );

CREATE TABLE
    gc_trajet_colis (
        id_trajet INT AUTO_INCREMENT PRIMARY KEY,
        id_colis INT,
        adresse_depart VARCHAR(255) NOT NULL,
        adresse_arrivee VARCHAR(255) NOT NULL
    );

CREATE TABLE
    gc_livraison (
        id_livraison INT AUTO_INCREMENT PRIMARY KEY,
        id_colis INT,
        date_livraison DATE NOT NULL,
        heure_livraison TIME NOT NULL,
        id_statut INT
    );

CREATE TABLE
    gc_chauffeur (
        id_chauffeur INT AUTO_INCREMENT PRIMARY KEY,
        nom_chauffeur VARCHAR(100) NOT NULL,
        prenom_chauffeur VARCHAR(100) NOT NULL,
        telephone_chauffeur VARCHAR(20),
        email_chauffeur VARCHAR(100),
        date_dassignation DATE,
        salaires_parLiv DOUBLE NOT NULL,
        id_voiture INT,
        id_livraison INT
    );

CREATE TABLE
    gc_tarifs (
        id_tarifs INT AUTO_INCREMENT PRIMARY KEY,
        unite VARCHAR(20) NOT NULL,
        prix DOUBLE NOT NULL
    );

/* =========================
FOREIGN KEYS (SANS CONSTRAINT)
========================= */
ALTER TABLE gc_voiture ADD FOREIGN KEY (id_carburant) REFERENCES gc_carburant (id_carburant);

ALTER TABLE gc_colis ADD FOREIGN KEY (id_statut) REFERENCES gc_statut_trajet (id_statut);

ALTER TABLE gc_trajet_colis ADD FOREIGN KEY (id_colis) REFERENCES gc_colis (id_colis);

ALTER TABLE gc_livraison ADD FOREIGN KEY (id_colis) REFERENCES gc_colis (id_colis);

ALTER TABLE gc_livraison ADD FOREIGN KEY (id_statut) REFERENCES gc_statut_trajet (id_statut);

ALTER TABLE gc_chauffeur ADD FOREIGN KEY (id_voiture) REFERENCES gc_voiture (id_voiture);

ALTER TABLE gc_chauffeur ADD FOREIGN KEY (id_livraison) REFERENCES gc_livraison (id_livraison);

/* Ajouter colonne non dans colis */
ALTER TABLE gc_colis
ADD COLUMN nom_colis VARCHAR(255);

CREATE TABLE
    gc_photos_colis (
        id_colis int,
        imageColis VARCHAR(50),
        FOREIGN KEY (id_colis) REFERENCES gc_colis (id_colis)
    );

-- =========== CHANGEMENT BASE =============
-- CHAUFFEUR --
ALTER TABLE gc_chauffeur
DROP FOREIGN KEY gc_chauffeur_ibfk_1,
DROP FOREIGN KEY gc_chauffeur_ibfk_2,
DROP COLUMN id_livraison,
DROP COLUMN id_voiture;

-- lIVRAISON --
ALTER TABLE gc_livraison add id_chauffeur int,
add id_voiture int,
add FOREIGN KEY (id_chauffeur) REFERENCES gc_chauffeur (id_chauffeur),
add FOREIGN KEY (id_voiture) REFERENCES gc_voiture (id_voiture);

/* Ajouter colonne profile dans gc_chauffeur */
ALTER TABLE gc_chauffeur
ADD COLUMN profile VARCHAR(255);

/* Ajouter colonne statut dans gc_chauffeur */
ALTER TABLE gc_chauffeur
ADD COLUMN statut ENUM (
            'disponible',
            'en plein livraison',
            'en congé'
        ) DEFAULT 'disponible';