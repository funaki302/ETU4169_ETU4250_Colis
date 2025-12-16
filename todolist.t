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
            - [] Benefice.php : afficher les benefice
              - [] creation de view dans data/view.sql :
                   -> [] V_gc_BeneficeJour
                        - [] afficher le jour
                        - [] calcul de tout les depense journaliere (carburant , salaire livreur)
                        - [] benefice par kg
                        - [] difference entre le deux donne le benefice ou perte
                   
                   -> [] V_gc_BeneficeMois
                        - [] afficher le mois
                        - [] calcul de tout les depense Monsuelle (carburant , salaire livreur)
                        - [] benefice par kg
                        - [] difference entre le deux donne le benefice ou perte
                   
                   -> [] V_gc_BeneficeAnne
                        - [] afficher lannee
                        - [] calcul de tout les depense Annuelle (carburant , salaire livreur)
                        - [] benefice par kg
                        - [] difference entre le deux donne le benefice ou perte

                - [] models/model.php :
                -> [] creation de fonction:
                     -> [] function getBeneficeJour() utilisant la view V_gc_BeneficeJour
                     -> [] function getBeneficeMois() utilisant la view V_gc_BeneficeMois
                     -> [] function getBeneficeAnne() utilisant la view V_gc_BeneficeAnne

                - [] controllers/controller.php
                -> [] appel des fonction pour avoir les donnes

                - [] config/routes.php
                -> [] prendre les donner et les envoyer dans Benfice.php
                -> [] ajout dans le header (voir tous benefice)
