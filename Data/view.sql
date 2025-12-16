-- benefice jour
CREATE OR REPLACE VIEW V_gc_BeneficeJour AS
SELECT
    DATE(l.date_livraison) AS jour,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_journaliers) AS salaire_chauffeur,
    SUM(vf.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) - (SUM(ch.salaires_journaliers) + SUM(vf.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON l.id_chauffeur = ch.id_chauffeur
JOIN gc_voiture v ON ch.id_voiture = v.id_voiture
JOIN gc_carburant vf ON v.id_carburant = vf.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 3
GROUP BY DATE(l.date_livraison);

-- benefice mois
CREATE OR REPLACE VIEW V_gc_BeneficeMois AS
SELECT
    YEAR(l.date_livraison) AS annee,
    MONTH(l.date_livraison) AS mois,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_journaliers) AS salaire_chauffeur,
    SUM(vf.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) - (SUM(ch.salaires_journaliers) + SUM(vf.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON l.id_chauffeur = ch.id_chauffeur
JOIN gc_voiture v ON ch.id_voiture = v.id_voiture
JOIN gc_carburant vf ON v.id_carburant = vf.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 3
GROUP BY YEAR(l.date_livraison), MONTH(l.date_livraison);

-- benefice annee
CREATE OR REPLACE VIEW V_gc_BeneficeAnnee AS
SELECT
    YEAR(l.date_livraison) AS annee,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_journaliers) AS salaire_chauffeur,
    SUM(vf.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) - (SUM(ch.salaires_journaliers) + SUM(vf.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON l.id_chauffeur = ch.id_chauffeur
JOIN gc_voiture v ON ch.id_voiture = v.id_voiture
JOIN gc_carburant vf ON v.id_carburant = vf.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 3
GROUP BY YEAR(l.date_livraison);
