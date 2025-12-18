INSERT INTO gc_statut_trajet (description_statut) VALUES
('En attente'),
('Livré'),
('Annulé');

INSERT INTO gc_carburant (type_carburant, prix_litre, date_dernier_approvisionnement) VALUES
('Essence', 5500, '2025-12-01'),
('Diesel', 4800, '2025-12-05');

INSERT INTO gc_voiture (immatriculation, marque, modele, capacite, statut_voiture, id_carburant) VALUES
('1234-TAA', 'Toyota', 'Hilux', 1000, 'disponible', 2),
('5678-TBB', 'Nissan', 'Navara', 1200, 'en cours de livraison', 2),
('9012-TCC', 'Peugeot', 'Partner', 800, 'maintenance', 1);

INSERT INTO gc_chauffeur (
    nom_chauffeur,
    prenom_chauffeur,
    telephone_chauffeur,
    email_chauffeur,
    date_dassignation,
    salaires_parLiv
) VALUES
('Rakoto', 'Jean', '0341234567', 'jean.rakoto@gmail.com', '2025-11-01', 30000),
('Rabe', 'Paul', '0329876543', 'paul.rabe@gmail.com', '2025-11-10', 35000);

INSERT INTO gc_chauffeur (
    nom_chauffeur,
    prenom_chauffeur,
    telephone_chauffeur,
    email_chauffeur,
    date_dassignation,
    salaires_parLiv
) VALUES
('Rakoto', 'Jean', '0341234567', 'jean.rakoto@gmail.com', '2025-11-01', 30000),
('Rabe', 'Paul', '0329876543', 'paul.rabe@gmail.com', '2025-11-10', 35000);

INSERT INTO gc_tarifs (unite, prix) VALUES
('kg', 2000);

INSERT INTO gc_colis (
    nom_colis,
    nom_expediteur,
    adresse_expediteur,
    nom_destinataire,
    adresse_destinataire,
    date_expedition,
    date_livraison,
    kilos,
    id_statut
) VALUES
(
    'Colis A',
    'Entreprise Alpha',
    'Entrepôt Central Antananarivo',
    'Client One',
    'Analakely',
    '2025-12-10',
    NULL,
    12.5,
    1
),
(
    'Colis B',
    'Entreprise Beta',
    'Entrepôt Central Antananarivo',
    'Client Two',
    'Ivandry',
    '2025-12-08',
    '2025-12-09',
    20,
    2
);

INSERT INTO gc_livraison (
    id_colis,
    date_livraison,
    heure_livraison,
    id_statut,
    id_chauffeur,
    id_voiture
) VALUES
(
    12,
    '2025-12-10',
    '10:30:00',
    1,
    8,
    8
),
(
    13,
    '2025-12-09',
    '15:45:00',
    2,
    9,
    9
);

INSERT INTO gc_trajet_colis (id_colis, adresse_depart, adresse_arrivee) VALUES
(1, 'Entrepôt Central Antananarivo', 'Analakely'),
(2, 'Entrepôt Central Antananarivo', 'Ivandry');

INSERT INTO gc_photos_colis (id_colis, imageColis) VALUES
(1, 'colis1.jpg'),
(2, 'colis2.jpg');
