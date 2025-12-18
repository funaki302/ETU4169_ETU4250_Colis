DROP DATABASE IF EXISTS gestion_colis;

CREATE DATABASE gestion_colis CHARACTER
SET
    utf8mb4 COLLATE utf8mb4_general_ci;

USE gestion_colis;

/* TABLES */
CREATE TABLE gc_statut_CL (
    id_statut INT AUTO_INCREMENT PRIMARY KEY,
    statut VARCHAR(50) NOT NULL
);

CREATE TABLE gc_statut_Voiture (
    id_statut INT AUTO_INCREMENT PRIMARY KEY,
    statut VARCHAR(50) NOT NULL
);

CREATE TABLE gc_statut_Chauffeur (
    id_statut INT AUTO_INCREMENT PRIMARY KEY,
    statut VARCHAR(50) NOT NULL
);

CREATE TABLE gc_carburant (
    id_carburant INT AUTO_INCREMENT PRIMARY KEY,
    type_carburant VARCHAR(200) NOT NULL,
    prix_litre DOUBLE NOT NULL,
    date_dernier_approvisionnement DATE
);

CREATE TABLE gc_voiture (
    id_voiture INT AUTO_INCREMENT PRIMARY KEY,
    immatriculation VARCHAR(50) UNIQUE NOT NULL,
    marque VARCHAR(50),
    modele VARCHAR(50),
    capacite INT NOT NULL,
    imageVoiture VARCHAR(255),
    id_carburant INT,
    id_statut INT,
    FOREIGN KEY (id_carburant) REFERENCES gc_carburant(id_carburant),
    FOREIGN KEY (id_statut) REFERENCES gc_statut_Voiture(id_statut)
);

CREATE TABLE gc_colis (
    id_colis INT AUTO_INCREMENT PRIMARY KEY,
    nom_colis VARCHAR(200),
    nom_expediteur VARCHAR(200) NOT NULL,
    adresse_expediteur VARCHAR(255) NOT NULL,
    nom_destinataire VARCHAR(200) NOT NULL,
    adresse_destinataire VARCHAR(255) NOT NULL,
    date_expedition DATE NOT NULL,
    date_livraison DATE,
    kilos DOUBLE NOT NULL,
    id_statut INT,
    FOREIGN KEY (id_statut) REFERENCES gc_statut_CL(id_statut)
);

CREATE TABLE gc_photos_colis (
    id_colis int,
    imageColis VARCHAR(50),
    FOREIGN KEY (id_colis) REFERENCES gc_colis (id_colis)
);

CREATE TABLE gc_chauffeur (
    id_chauffeur INT AUTO_INCREMENT PRIMARY KEY,
    nom_chauffeur VARCHAR(200) NOT NULL,
    prenom_chauffeur VARCHAR(200) NOT NULL,
    telephone_chauffeur VARCHAR(20),
    email_chauffeur VARCHAR(200),
    date_dassignation DATE,
    salaires_parLiv DOUBLE NOT NULL,
    profil VARCHAR(255),
    id_statut INT,
    FOREIGN KEY (id_statut) REFERENCES gc_statut_Chauffeur(id_statut)
);

CREATE TABLE gc_livraison (
    id_livraison INT AUTO_INCREMENT PRIMARY KEY,
    id_colis INT,
    date_livraison DATE NOT NULL,
    heure_livraison TIME NOT NULL,
    id_chauffeur INT,
    id_voiture INT,
    id_statut INT,
    FOREIGN KEY (id_colis) REFERENCES gc_colis(id_colis),
    FOREIGN KEY (id_chauffeur) REFERENCES gc_chauffeur(id_chauffeur),
    FOREIGN KEY (id_voiture) REFERENCES gc_voiture(id_voiture),
    FOREIGN KEY (id_statut) REFERENCES gc_statut_CL(id_statut)
);

CREATE TABLE gc_tarifs (
    id_tarifs INT AUTO_INCREMENT PRIMARY KEY,
    unite VARCHAR(20) NOT NULL,
    prix DOUBLE NOT NULL
);

CREATE TABLE gc_trajet_colis (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    id_colis INT,
    adresse_depart VARCHAR(255) NOT NULL,
    adresse_arrivee VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_colis) REFERENCES gc_colis(id_colis)
);


/* VIEWS */

CREATE OR REPLACE VIEW V_gc_BeneficeJour AS
SELECT
    DATE(l.date_livraison) AS jour,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_parLiv) AS salaire_chauffeur,
    SUM(cb.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) - (SUM(ch.salaires_parLiv) + SUM(cb.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON l.id_chauffeur = ch.id_chauffeur
JOIN gc_voiture v ON l.id_voiture = v.id_voiture
JOIN gc_carburant cb ON v.id_carburant = cb.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 2
GROUP BY DATE(l.date_livraison);

CREATE OR REPLACE VIEW V_gc_BeneficeMois AS
SELECT
    YEAR(l.date_livraison) AS annee,
    MONTH(l.date_livraison) AS mois,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_parLiv) AS salaire_chauffeur,
    SUM(cb.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) - (SUM(ch.salaires_parLiv) + SUM(cb.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON l.id_chauffeur = ch.id_chauffeur
JOIN gc_voiture v ON l.id_voiture = v.id_voiture
JOIN gc_carburant cb ON v.id_carburant = cb.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 2
GROUP BY YEAR(l.date_livraison), MONTH(l.date_livraison);

CREATE OR REPLACE VIEW V_gc_BeneficeAnnee AS
SELECT
    YEAR(l.date_livraison) AS annee,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_parLiv) AS salaire_chauffeur,
    SUM(cb.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) - (SUM(ch.salaires_parLiv) + SUM(cb.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON l.id_chauffeur = ch.id_chauffeur
JOIN gc_voiture v ON l.id_voiture = v.id_voiture
JOIN gc_carburant cb ON v.id_carburant = cb.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 2
GROUP BY YEAR(l.date_livraison);


CREATE OR REPLACE VIEW V_gc_ColisImg AS
SELECT 
    c.id_colis,
    c.nom_colis,
    c.nom_expediteur,
    c.adresse_expediteur,
    c.nom_destinataire,
    c.adresse_destinataire,
    c.date_expedition,
    c.date_livraison,
    c.kilos,
    c.id_statut,
    s.statut,
    MIN(p.imageColis) AS imageColis
FROM gc_colis c
LEFT JOIN gc_photos_colis p 
    ON c.id_colis = p.id_colis
LEFT JOIN gc_statut_CL s
    ON c.id_statut = s.id_statut
GROUP BY
    c.id_colis,
    c.nom_colis,
    c.nom_expediteur,
    c.adresse_expediteur,
    c.nom_destinataire,
    c.adresse_destinataire,
    c.date_expedition,
    c.date_livraison,
    c.kilos,
    c.id_statut;
