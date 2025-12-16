-- =====================================================
-- TABLE: gc_voiture
-- =====================================================
INSERT INTO gc_voiture (immatriculation, marque, modele, capacite, statut_voiture, id_carburant) VALUES
('AB-1234-TN', 'Toyota', 'Hilux', 1200, 'disponible', 1),
('CD-5678-TN', 'Isuzu', 'D-Max', 1500, 'en cours de livraison', 1),
('EF-9012-TN', 'Nissan', 'Navara', 1300, 'maintenance', 2),
('GH-3456-TN', 'Mitsubishi', 'L200', 1400, 'disponible', 2),
('IJ-7890-TN', 'Ford', 'Ranger', 1600, 'en cours de livraison', 1),
('KL-1122-TN', 'Chevrolet', 'S10', 1250, 'disponible', 2),
('MN-3344-TN', 'Toyota', 'Hilux', 1300, 'maintenance', 1);

-- =====================================================
-- TABLE: gc_colis
-- =====================================================
INSERT INTO gc_colis
(nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire, date_expedition, date_livraison, kilos, id_statut)
VALUES
('Société Alpha', 'Antananarivo', 'Client A', 'Antsirabe', '2025-11-10', NULL, 25.5, 1),
('Entreprise Beta', 'Toamasina', 'Client B', 'Mahajanga', '2025-11-09', NULL, 10.2, 2),
('Particulier Gamma', 'Fianarantsoa', 'Client C', 'Toliara', '2025-11-05', '2025-11-12', 5.0, 3),
('Société Delta', 'Antananarivo', 'Client D', 'Fianarantsoa', '2025-11-08', NULL, 12.5, 1),
('Entreprise Epsilon', 'Antsirabe', 'Client E', 'Toliara', '2025-11-09', '2025-11-14', 18.0, 2),
('Particulier Zeta', 'Toamasina', 'Client F', 'Mahajanga', '2025-11-10', '2025-11-15', 7.5, 3),
('Société Theta', 'Fianarantsoa', 'Client G', 'Antananarivo', '2025-11-11', NULL, 20.0, 1),
('Entreprise Iota', 'Toliara', 'Client H', 'Toamasina', '2025-11-12', NULL, 9.8, 1);

-- =====================================================
-- TABLE: gc_trajet_colis
-- =====================================================
INSERT INTO gc_trajet_colis (id_colis, adresse_depart, adresse_arrivee) VALUES
(1, 'Entrepôt Central Antananarivo', 'Antsirabe'),
(2, 'Entrepôt Central Antananarivo', 'Mahajanga'),
(3, 'Entrepôt Central Antananarivo', 'Toliara'),
(4, 'Entrepôt Central Antananarivo', 'Fianarantsoa'),
(5, 'Entrepôt Central Antsirabe', 'Toliara'),
(6, 'Entrepôt Central Toamasina', 'Mahajanga'),
(7, 'Entrepôt Central Fianarantsoa', 'Antananarivo'),
(8, 'Entrepôt Central Toliara', 'Toamasina');

-- =====================================================
-- TABLE: gc_livraison
-- =====================================================
INSERT INTO gc_livraison (id_colis, date_livraison, heure_livraison, id_statut) VALUES
(2, '2025-11-11', '14:30:00', 2),
(3, '2025-11-12', '09:15:00', 2),
(4, '2025-11-13', '10:00:00', 2),
(5, '2025-11-14', '11:30:00', 2),
(6, '2025-11-15', '09:45:00', 2),
(7, '2025-11-16', '15:00:00', 1),
(8, '2025-11-17', '13:20:00', 1);

-- =====================================================
-- TABLE: gc_chauffeur
-- =====================================================
INSERT INTO gc_chauffeur
(nom_chauffeur, prenom_chauffeur, telephone_chauffeur, email_chauffeur, date_dassignation, salaires_parLiv, id_voiture, id_livraison)
VALUES
('Rakoto', 'Jean', '0341234567', 'jean.rakoto@mail.com', '2025-11-01', 15000, 1, 1),
('Rabe', 'Marc', '0339876543', 'marc.rabe@mail.com', '2025-11-03', 18000, 2, 2),
('Andrianarisoa', 'Hery', '0341112233', 'hery.andrianarisoa@mail.com', '2025-11-02', 17000, 3, 4),
('Rakotovao', 'Liva', '0334445566', 'liva.rakotovao@mail.com', '2025-11-04', 16000, 4, 5),
('Rasolofonirina', 'Tiana', '0345556677', 'tiana.rasolofonirina@mail.com', '2025-11-05', 15000, 1, 6);

-- =====================================================
-- TABLE: gc_tarifs
-- =====================================================
INSERT INTO gc_tarifs (unite, prix) VALUES
('kg', 2500),
('colis', 15000);



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
