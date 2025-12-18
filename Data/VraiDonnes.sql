INSERT INTO gc_statut_CL (statut) VALUES
('en attente'),
('en cours de livraison'),
('livré'),
('annulé');

INSERT INTO gc_statut_Voiture (statut) VALUES
('disponible'),
('en cours de livraison'),
('maintenance');

INSERT INTO gc_statut_Chauffeur (statut) VALUES
('disponible'),
('en plein livraison'),
('en congé');

INSERT INTO gc_carburant (type_carburant, prix_litre, date_dernier_approvisionnement) VALUES
('Essence', 1.25, '2025-01-10'),
('Diesel', 1.10, '2025-01-12');

INSERT INTO gc_voiture (immatriculation, marque, modele, capacite, id_carburant, id_statut,imageVoiture) VALUES
('AB-123-CD', 'Toyota', 'Hilux', 1000, 2, 1, 'voiture1.jpg'),
('EF-456-GH', 'Isuzu', 'D-Max', 1200, 2, 1, 'voiture2.jpg'),
('IJ-789-KL', 'Peugeot', 'Partner', 800, 1, 2, 'voiture3.jpg');

INSERT INTO gc_chauffeur
(nom_chauffeur, prenom_chauffeur, telephone_chauffeur, email_chauffeur, date_dassignation, salaires_parLiv, profil, id_statut)
VALUES
('Rakoto', 'Jean', '0341234567', 'rakoto.jean@email.com', '2024-12-01', 15, 'chauffeur1.jpg', 1),
('Rabe', 'Paul', '0329876543', 'rabe.paul@email.com', '2024-12-10', 18, 'chauffeur2.jpg', 2),
('Randria', 'Marc', '0335558888', 'randria.marc@email.com', '2024-11-20', 20, 'chauffeur3.jpg', 1);

INSERT INTO gc_colis
(nom_colis, nom_expediteur, adresse_expediteur, nom_destinataire, adresse_destinataire,
 date_expedition, date_livraison, kilos, id_statut)
VALUES
('Ordinateur portable', 'Eric', 'Antananarivo', 'Luc', 'Toamasina', '2025-01-10', '2025-01-11', 5, 2),
('Documents', 'Marie', 'Fianarantsoa', 'Paul', 'Antsirabe', '2025-01-12', NULL, 1, 1),
('Téléviseur', 'Jean', 'Mahajanga', 'Sophie', 'Antananarivo', '2025-01-09', '2025-01-10', 12, 2),
('Meubles', 'David', 'Toliara', 'Claire', 'Morondava', '2025-01-08', NULL, 50, 3);

INSERT INTO gc_photos_colis (id_colis, imageColis) VALUES
(1, 'colis1.jpg'),
(1, 'colis1b.jpg'),
(2, 'colis2.jpg'),
(3, 'colis3.jpg');

INSERT INTO gc_livraison
(id_colis, date_livraison, heure_livraison, id_chauffeur, id_voiture, id_statut)
VALUES
(1, '2025-01-11', '10:30:00', 1, 1, 2),
(3, '2025-01-10', '15:00:00', 2, 2, 2);

INSERT INTO gc_tarifs (unite, prix) VALUES
('kg', 2.5);

INSERT INTO gc_trajet_colis (id_colis, adresse_depart, adresse_arrivee) VALUES
(1, 'Antananarivo', 'Toamasina'),
(2, 'Fianarantsoa', 'Antsirabe'),
(3, 'Mahajanga', 'Antananarivo'),
(4, 'Toliara', 'Morondava');

