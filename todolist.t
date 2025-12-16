

- [ok] Creation Base de donne Mysql:
     [ok] table :
      -> [ok] trajet (idTrajet ,dateHeureDebut , dateHeureFin, distance, idChauffeur, idVehicule, idRecette, idCarburant, String pointDepart,String pointArrivee)
      -> [ok] chauffeur (idChauffeur ,nom, prenom, telephone, adresse, email, salaire)
      -> [ok] vehicule ( idVehicule , marque, modele)
      -> [ok] recette (idRecette , montant , date)
      -> [ok] salaire (idSalaire , montant , datePaiement, idChauffeur)
      -> [ok] carburant (idCarburant ,idVehicule , prixLitre , quantite , dateAchat)

- [ok] connection pour se connecterr a la base de donne Mysql
   - [ok] config/database.php :
      [ok] fonction connect() : connexion a la base de donne Mysql avec PDO.

- [] Home.php :
    [ok] Afficher la liste de trajet avec les informations du chauffeur et du vehicule par jour.
       - [ok] fonction getTrajetsByDate()
       -> [ok] creation de la vue V_gt_trajet_detaillee pour faciliter la recuperation des donnees.       
          -> [ok] union entre les tables trajet, chauffeur et vehicule et recette.

    [] Affichage total benefice par vehicule .
       - [] fonction getBeneficeByVehicule()
       -> [] recuperation des donnees de la table recette et trajet pour le calcul du benefice par vehicule.
          -> [] Creation de la vue V_gt_benefice_par_vehicule pour faciliter la recuperation des donnees.
             -> [] somme de tout les depenses de carburant par vehicule.

    [] Affichage total benefice par jour .
       - [] fonction getBeneficeByDate($date)
       ->[] recuperation des donnees de la table recette et trajet pour le calcul du benefice par jour.

    [] Affichage Trajet le plus rentable par jour .
       - [] fonction getTrajetLePlusRentableByDate($date)
       -> [] recuperation des donnees de la table recette et trajet pour identifier le trajet le plus rentable par jour.       

    - [] Amelioration :
    [] Ajouter un nouveau trajet.
  