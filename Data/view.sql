CREATE OR REPLACE VIEW V_gc_BeneficeJour AS
SELECT
    DATE(l.date_livraison) AS jour,
    SUM(c.kilos * t.prix) AS recette,
    SUM(ch.salaires_parLiv) AS salaire_chauffeur,
    SUM(cb.prix_litre) AS cout_carburant,
    (SUM(c.kilos * t.prix) 
     - (SUM(ch.salaires_parLiv) + SUM(cb.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON ch.id_livraison = l.id_livraison
JOIN gc_voiture v ON ch.id_voiture = v.id_voiture
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
    (SUM(c.kilos * t.prix) 
     - (SUM(ch.salaires_parLiv) + SUM(cb.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON ch.id_livraison = l.id_livraison
JOIN gc_voiture v ON ch.id_voiture = v.id_voiture
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
    (SUM(c.kilos * t.prix) 
     - (SUM(ch.salaires_parLiv) + SUM(cb.prix_litre))) AS benefice
FROM gc_livraison l
JOIN gc_colis c ON l.id_colis = c.id_colis
JOIN gc_chauffeur ch ON ch.id_livraison = l.id_livraison
JOIN gc_voiture v ON ch.id_voiture = v.id_voiture
JOIN gc_carburant cb ON v.id_carburant = cb.id_carburant
JOIN gc_tarifs t ON t.unite = 'kg'
WHERE l.id_statut = 2
GROUP BY YEAR(l.date_livraison);
