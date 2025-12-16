-- Schema MySQL pour l'application
-- Contient les tables : chauffeur, vehicule, recette, carburant, salaire, trajet
-- et des données de test pour développement
create database if not exists gestion_transport;
use gestion_transport;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS trajet;
DROP TABLE IF EXISTS salaire;
DROP TABLE IF EXISTS carburant;
DROP TABLE IF EXISTS recette;
DROP TABLE IF EXISTS vehicule;
DROP TABLE IF EXISTS chauffeur;

SET FOREIGN_KEY_CHECKS=1;

-- Table chauffeur
CREATE TABLE IF NOT EXISTS gt_chauffeur (
	idChauffeur INT UNSIGNED NOT NULL AUTO_INCREMENT,
	nom VARCHAR(80) NOT NULL,
	prenom VARCHAR(80) NOT NULL,
	telephone VARCHAR(30) DEFAULT NULL,
	adresse VARCHAR(255) DEFAULT NULL,
	email VARCHAR(150) DEFAULT NULL,
	salaire DECIMAL(10,2) DEFAULT NULL,
	PRIMARY KEY (idChauffeur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table vehicule
CREATE TABLE IF NOT EXISTS gt_vehicule (
	idVehicule INT UNSIGNED NOT NULL AUTO_INCREMENT,
	marque VARCHAR(80) NOT NULL,
	modele VARCHAR(80) DEFAULT NULL,
	PRIMARY KEY (idVehicule)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table recette
CREATE TABLE IF NOT EXISTS gt_recette (
	idRecette INT UNSIGNED NOT NULL AUTO_INCREMENT,
	montant DECIMAL(10,2) NOT NULL,
	date DATE NOT NULL,
	PRIMARY KEY (idRecette)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gt_carburant (
	idCarburant INT UNSIGNED NOT NULL AUTO_INCREMENT,
	idVehicule INT UNSIGNED NOT NULL,
	prixLitre DECIMAL(10,3) NOT NULL,
	quantite DECIMAL(10,3) NOT NULL,
	dateAchat DATE NOT NULL,
	PRIMARY KEY (idCarburant),
 	FOREIGN KEY (idVehicule) REFERENCES gt_vehicule(idVehicule)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gt_salaire (
	idSalaire INT UNSIGNED NOT NULL AUTO_INCREMENT,
	montant DECIMAL(10,2) NOT NULL,
	datePaiement DATE NOT NULL,
	idChauffeur INT UNSIGNED NOT NULL,
	PRIMARY KEY (idSalaire),
 	FOREIGN KEY (idChauffeur) REFERENCES gt_chauffeur(idChauffeur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gt_trajet (
	idTrajet INT UNSIGNED NOT NULL AUTO_INCREMENT,
	dateHeureDebut DATETIME NOT NULL,
	dateHeureFin DATETIME DEFAULT NULL,
	distance DECIMAL(10,2) DEFAULT NULL,
	idChauffeur INT UNSIGNED DEFAULT NULL,
	idVehicule INT UNSIGNED DEFAULT NULL,
	idRecette INT UNSIGNED DEFAULT NULL,
	idCarburant INT UNSIGNED DEFAULT NULL,
	pointDepart VARCHAR(255) DEFAULT NULL,
	pointArrivee VARCHAR(255) DEFAULT NULL,
	PRIMARY KEY (idTrajet),
 	FOREIGN KEY (idChauffeur) REFERENCES gt_chauffeur(idChauffeur),
 	FOREIGN KEY (idVehicule) REFERENCES gt_vehicule(idVehicule),
 	FOREIGN KEY (idRecette) REFERENCES gt_recette(idRecette),
 	FOREIGN KEY (idCarburant) REFERENCES gt_carburant(idCarburant)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DONNEES DE TEST
-- Chauffeurs
INSERT INTO gt_chauffeur (nom, prenom, telephone, adresse, email, salaire) VALUES
('Dupont', 'Pierre', '0612345678', '12 rue de la République, Paris', 'p.dupont@example.com', 2200.00),
('Martin', 'Sophie', '0698765432', '5 avenue Victor Hugo, Lyon', 's.martin@example.com', 2400.00),
('Nguyen', 'Thi', '0678954321', '3 rue des Fleurs, Marseille', 't.nguyen@example.com', 2000.00);

-- Vehicules
INSERT INTO gt_vehicule (marque, modele) VALUES
('Renault', 'Clio'),
('Peugeot', '208');

-- Recettes
INSERT INTO gt_recette (montant, date) VALUES
(150.50, '2025-12-01'),
(230.00, '2025-12-02');

-- Carburants
INSERT INTO gt_carburant (idVehicule, prixLitre, quantite, dateAchat) VALUES
(1, 1.789, 40.00, '2025-11-28'),
(2, 1.759, 50.00, '2025-11-29');

-- Salaires
INSERT INTO gt_salaire (montant, datePaiement, idChauffeur) VALUES
(2200.00, '2025-11-30', 1),
(2400.00, '2025-11-30', 2),
(2000.00, '2025-11-30', 3);

-- Trajets
INSERT INTO gt_trajet (dateHeureDebut, dateHeureFin, distance, idChauffeur, idVehicule, idRecette, idCarburant, pointDepart, pointArrivee) VALUES
('2025-12-03 08:00:00','2025-12-03 10:30:00',120.50,1,1,1,1,'Paris, Gare du Nord','Rouen, Centre'),
('2025-12-04 09:15:00','2025-12-04 11:00:00',85.75,2,2,2,2,'Lyon, Part-Dieu','Grenoble, Centre');
-- Fin du script

CREATE OR REPLACE VIEW V_gt_trajet_detaillee AS
SELECT
	t.idTrajet,
	t.dateHeureDebut,
	t.dateHeureFin,
	t.distance,
	t.pointDepart,
	t.pointArrivee,
	t.idChauffeur,
	CONCAT(c.prenom, ' ', c.nom) AS chauffeur_nom_complet,
	c.telephone AS chauffeur_telephone,
	c.email AS chauffeur_email,
	t.idVehicule,
	v.marque AS vehicule_marque,
	v.modele AS vehicule_modele,
	t.idRecette,
	r.montant AS recette_montant,
	r.date AS recette_date,
	t.idCarburant
FROM gt_trajet t
LEFT JOIN gt_chauffeur c ON t.idChauffeur = c.idChauffeur
LEFT JOIN gt_vehicule v ON t.idVehicule = v.idVehicule
LEFT JOIN gt_recette r ON t.idRecette = r.idRecette;