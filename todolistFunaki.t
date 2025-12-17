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
            - [ok] Benefice.php : afficher les benefice
              - [ok] creation de view dans data/view.sql :
                   -> [ok] V_gc_BeneficeJour
                        - [ok] afficher le jour
                        - [ok] calcul de tout les depense journaliere (carburant , salaire livreur)
                        - [ok] benefice par kg
                        - [ok] difference entre le deux donne le benefice ou perte
                   
                   -> [ok] V_gc_BeneficeMois
                        - [ok] afficher le mois
                        - [ok] calcul de tout les depense Monsuelle (carburant , salaire livreur)
                        - [ok] benefice par kg
                        - [ok] difference entre le deux donne le benefice ou perte
                   
                   -> [ok] V_gc_BeneficeAnne
                        - [ok] afficher lannee
                        - [ok] calcul de tout les depense Annuelle (carburant , salaire livreur)
                        - [ok] benefice par kg
                        - [ok] difference entre le deux donne le benefice ou perte

                - [ok] models/model.php :
                -> [ok] creation de fonction:
                     -> [ok] function getBeneficeJour() utilisant la view V_gc_BeneficeJour
                     -> [ok] function getBeneficeMois() utilisant la view V_gc_BeneficeMois
                     -> [ok] function getBeneficeAnne() utilisant la view V_gc_BeneficeAnne


                - [ok] controllers/controller.php
                -> [ok] appel des fonction pour avoir les donnes

                - [ok] config/routes.php
                -> [ok] prendre les donner et les envoyer dans Benfice.php
                -> [ok] ajout dans le header (voir tous benefice)

            - [ok] BeneficeParMois.php : afficher les benefice par annee 


                - [ok] controllers/controller.php
                -> [ok] appel des fonction pour avoir les donnes


                - [ok] config/routes.php
                -> [ok] prendre les donner et les envoyer dans Benfice.php
                -> [ok] ajout dans le header (voir tous benefice)
        
            - [ok] InsertionsColis.php :
                -> [ok] creation de form pour prendre les donner :
                    -> [ok] nom
                       [ok] nom_expediteur 
                       [ok] adresse_expediteur 
                       [ok] nom_destinataire 
                       [ok] adresse_destinataire 
                       [ok] date_expedition 
                       [ok] date_livraison 
                       [ok] kilos 
                       [ok] id_statut par defaut on mettra 1 en attente
                       [ok] images colis
 
                  -> [ok] creation fonction insertColis() : 
                         pour inserer les colis dans la bases dans modele.php:

                  -> [ok] creation fonction upload() qui controlle et insert dans public/images/ :
                         retourne un nom dimage completement different       
                  
                  -> [ok] utilisation des fonction dans insertColis()

                  -> [ok] utilisation dans controller.php 

                - [ok] routes.php :
                  -> [ok] condition pour le lien InsertColis
                  -> [ok] prendre touts les donner insertion 
                  -> [ok] Appler la function insertColis et entrer tous 
                  -> [ok] redirections vers home avec /
        
        - [ok] Afficher les images des colis dans Home.php et les faires en div en non en tables :
               - [ok] home.php : 
                   -> [ok] transformer l affichage en div et non en tables
                   -> [ok] function getImgColis($id)

               - [ok] routes.php :
                   -> [ok] inserer la fonction pour avoir les images

        - [ok] Ajouter un critere daffichage :
             -> [ok] par status
             -> [ok] date d expedition min 
             -> [ok] date d expedition max
             -> [ok] nom 
             - [ok] home.php
                 -> [ok] Ajout dun nouveau forme pour critere 

             - [ok] model.php
                 -> [ok] creation function critaireColis() 
                       qui verifie les crietres en reference au view
                       - [ok] on peut choisir un seule critere ou plusieur

             - [ok] controller.php 
                 -> [ok] appel de fonction critaireColis()           

             - [ok] routes.php 
                 -> [ok] gerer la form et appel de la fonction dans controller
                 -> [ok] envoie le resultat dans home.php 

        - [] Ajouter un upload photo dans detailsColis.php 
             - [] detailsColis.php
               -> [] ajouter un input file pour limage

             - [] model.php 
               -> [] modifie updateColis()
                  -> [] inserer la fonction upload et insertImgColis 

                      
          
