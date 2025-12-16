 TODO LIST ETU4169 ETU4250
  - [] Creation dun systeme de gestion de colis :
     - [ok] creation de databse (Mysql) :
       - [ok] dans le dossier Data/data.sql 
       - [ok] Base de donnee : gestion_colis :
           - [ok] table : gc_colis
               - [ok] id_colis (int, PK, AI)
               - [ok] nom_expediteur (varchar)
               - [ok] adresse_expediteur (varchar)
               - [ok] nom_destinataire (varchar)
               - [ok] adresse_destinataire (varchar)
               - [ok] date_expedition (date)
               - [ok] date_livraison (date)
               - [ok] id_statut (int , FK) 
               - [ok] kilos (double)

           - [ok] table : gc_trajet_colis
               - [ok] id_trajet (int, PK, AI)
               - [ok] id_colis (int, FK)
               - [ok] adresse_depart (varchar) : entrepôt de la société, 1 seul entrepôt 
               - [ok] adresse_arrivee (varchar)
             
           - [ok] table : gc_statut_trajet
               - [ok] id_statut (int, PK, AI)
               - [ok] description_statut (varchar) : en attente , livre ,annule     
           
           - [ok] table : gc_chauffeur
               - [ok] id_chauffeur (int, PK, AI)
               - [ok] nom_chauffeur (varchar)
               - [ok] prenom_chauffeur (varchar)
               - [ok] telephone_chauffeur (varchar)
               - [ok] email_chauffeur (varchar)
               - [ok] id_voiture (int, FK)
               - [ok] date_dassignation (date)
               - [] salaires_parLiv (double)
               - [] id_livraison (int , FK ) 
            
            - [ok] table : gc_voiture
               - [ok] id_voiture (int, PK, AI)
               - [ok] immatriculation (varchar)
               - [ok] marque (varchar)
               - [ok] modele (varchar)
               - [ok] capacite (int)
               - [ok] statut_voiture (varchar) : disponible, en cours de livraison, en maintenance
               - [ok] id_carburant (int , FK )

            - [ok] table : gc_livraison :
               - [ok] id_livraison (int, PK, AI)
               - [ok] id_colis (int, FK)
               - [ok] id_chauffeur (int, FK)
               - [ok] date_livraison (date)
               - [ok] heure_livraison (time)
               - [ok] id_statut (int, FK)   

            - [ok] table : gc_carburant :
               - [ok] id_carburant (int, PK, AI)
               - [ok] type_carburant (varchar)
               - [ok] prix_litre (double)
               - [ok] date_dernier_approvisionnement (date)

            - [ok] table : gc_tarifs :
               - [ok] id_tarifs (int , PK , AI)
               - [ok] unite (kg ,litre , ml , .. )
               - [ok] prix

        - [] Creation des pages web (HTML, CSS, JS, PHP) :
        - [] Page :
            - [] BeneficeParJour.php : afficher les benefice par jour 

            - [] BeneficeParMois.php : afficher les benefice par mois 

            - [] BeneficeParMois.php : afficher les benefice par annee 

            - [] home.php : page d accueil avec la liste des colis
              - FONCTION:
                - [ok] getColis() : recuperer la liste des colis
                - [ok] addColis() : ajouter un colis   
                - [ok] updateColis() : modifier un colis
                - [ok] deleteColis() : supprimer un colis 
              - Page:
                - [ok] Afficher la liste des colis dans un tableau
                - [] Lier chaque colis a une page de details (lien sur l id du colis)
            
            - [] detailsColis.php : page de details d un colis
              - FONCTION:
                - [] getColisById($id) : recuperer les details d un colis
              - Page:
                - [] Afficher les details du colis
                - [] Formulaire pour modifier le colis
                - [] Bouton pour modifier le colis
                - [] Bouton pour supprimer le colis