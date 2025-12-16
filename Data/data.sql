/* =========================
   RESET BASE
========================= */
DROP DATABASE IF EXISTS gestion_colis;

CREATE DATABASE gestion_colis
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE gestion_colis;

/* =========================
   TABLES
========================= */

CREATE TABLE gc_statut_trajet (
    id_statut INT AUTO_INCREMENT PRIMARY KEY,
    description_statut VARCHAR(50) NOT NULL
);

CREATE TABLE gc_carburant (
    id_carburant INT AUTO_INCREMENT PRIMARY KEY,
    type_carburant VARCHAR(50) NOT NULL,
    prix_litre DOUBLE NOT NULL,
    date_dernier_approvisionnement DATE
);

CREATE TABLE gc_voiture (
    id_voiture INT AUTO_INCREMENT PRIMARY KEY,
    immatriculation VARCHAR(50) UNIQUE NOT NULL,
    marque VARCHAR(50),
    modele VARCHAR(50),
    capacite INT NOT NULL,
    statut_voiture ENUM('disponible','en cours de livraison','maintenance'),
    id_carburant INT
);

CREATE TABLE gc_colis (
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

CREATE TABLE gc_trajet_colis (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    id_colis INT,
    adresse_depart VARCHAR(255) NOT NULL,
    adresse_arrivee VARCHAR(255) NOT NULL
);

CREATE TABLE gc_livraison (
    id_livraison INT AUTO_INCREMENT PRIMARY KEY,
    id_colis INT,
    date_livraison DATE NOT NULL,
    heure_livraison TIME NOT NULL,
    id_statut INT
);

CREATE TABLE gc_chauffeur (
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

CREATE TABLE gc_tarifs (
    id_tarifs INT AUTO_INCREMENT PRIMARY KEY,
    unite VARCHAR(20) NOT NULL,
    prix DOUBLE NOT NULL
);

/* =========================
   FOREIGN KEYS (SANS CONSTRAINT)
========================= */

ALTER TABLE gc_voiture
ADD FOREIGN KEY (id_carburant) REFERENCES gc_carburant(id_carburant);

ALTER TABLE gc_colis
ADD FOREIGN KEY (id_statut) REFERENCES gc_statut_trajet(id_statut);

ALTER TABLE gc_trajet_colis
ADD FOREIGN KEY (id_colis) REFERENCES gc_colis(id_colis);

ALTER TABLE gc_livraison
ADD FOREIGN KEY (id_colis) REFERENCES gc_colis(id_colis);

ALTER TABLE gc_livraison
ADD FOREIGN KEY (id_statut) REFERENCES gc_statut_trajet(id_statut);

ALTER TABLE gc_chauffeur
ADD FOREIGN KEY (id_voiture) REFERENCES gc_voiture(id_voiture);

ALTER TABLE gc_chauffeur
ADD FOREIGN KEY (id_livraison) REFERENCES gc_livraison(id_livraison);

/* =========================
   DONNÉES DE TEST
========================= */

INSERT INTO gc_statut_trajet (description_statut) VALUES
('en attente'),
('livré'),
('annulé');

INSERT INTO gc_carburant (type_carburant, prix_litre, date_dernier_approvisionnement) VALUES
('Diesel', 5200, '2025-11-01'),
('Essence', 5400, '2025-11-05'),
('Electrique', 1200, '2025-11-10');

INSERT INTO gc_voiture (immatriculation, marque, modele, capacite, statut_voiture, id_carburant) VALUES
('AB-1234-TN', 'Toyota', 'Hilux', 1200, 'disponible', 1),
('CD-5678-TN', 'Isuzu', 'D-Max', 1500, 'en cours de livraison', 1),
('EF-9012-TN', 'Nissan', 'Navara', 1300, 'maintenance', 2);

INSERT INTO gc_colis
(nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, date_expedition, date_livraison, kilos, id_statut)
VALUES
('Société Alpha', 'Antananarivo', 'Client A', 'Antsirabe', '2025-11-10', NULL, 25.5, 1),
('Entreprise Beta', 'Toamasina', 'Client B', 'Mahajanga', '2025-11-09', NULL, 10.2, 2),
('Particulier Gamma', 'Fianarantsoa', 'Client C', 'Toliara', '2025-11-05', '2025-11-12', 5.0, 3);

INSERT INTO gc_trajet_colis (id_colis, adresse_depart, adresse_arrivee) VALUES
(1, 'Entrepôt Central Antananarivo', 'Antsirabe'),
(2, 'Entrepôt Central Antananarivo', 'Mahajanga'),
(3, 'Entrepôt Central Antananarivo', 'Toliara');

INSERT INTO gc_livraison (id_colis, date_livraison, heure_livraison, id_statut) VALUES
(2, '2025-11-11', '14:30:00', 2),
(3, '2025-11-12', '09:15:00', 2);

INSERT INTO gc_chauffeur
(nom_chauffeur, prenom_chauffeur, telephone_chauffeur, email_chauffeur, date_dassignation, salaires_parLiv, id_voiture, id_livraison)
VALUES
('Rakoto', 'Jean', '0341234567', 'jean.rakoto@mail.com', '2025-11-01', 15000, 1, 1),
('Rabe', 'Marc', '0339876543', 'marc.rabe@mail.com', '2025-11-03', 18000, 2, 2);

INSERT INTO gc_tarifs (unite, prix) VALUES
('kg', 2500),
('colis', 15000);

/* Ajouter colonne non dans colis */
ALTER TABLE gc_colis
ADD COLUMN nom_colis VARCHAR(255) ;

CREATE TABLE gc_photos_colis(
    id_colis int ,
    imageColis VARCHAR(50),
    FOREIGN KEY (id_colis) REFERENCES gc_colis(id_colis)
);
