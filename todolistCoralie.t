- [ok] home.php : page d accueil avec la liste des colis
  - FONCTION:
    - [ok] getColis() : recuperer la liste des colis
    - [ok] addColis() : ajouter un colis   
    - [ok] updateColis() : modifier un colis
    - [ok] deleteColis() : supprimer un colis 
  - Page:
    - [ok] Afficher la liste des colis dans un tableau
    - [ok] Lier chaque colis a une page de details (lien sur l id du colis)
            
- [ok] detailsColis.php : page de details d un colis
  - FONCTION:
    - [ok] getColisById($id) : recuperer les details d un colis
    - [ok] getStatuts() : recuperer la liste des statuts pour le formulaire de modification
  - Page:
    - [ok] Afficher les details du colis
    - [ok] Formulaire pour modifier le colis : Formulaire pres remplit avec les donnees actuelles du colis
    - [ok] Bouton pour modifier le colis

- [ok] voiture.php : page pour ajouter de nouvelles voiture 
  - FONCTION :
    - [ok] getVoiture()
    - [ok] getVoitureById($id)
    - [ok] addVoiture()
    - [ok] updateVoiture()
    - [ok] deleteVoiture()
    - [ok] getCarburants()
    - [ok] getCarburantById($id)
    - [ok] getStatut_voiture()
  - Page :
    - [ok] Afficher la liste de tous les voitures
    - [ok] Bouton ajouter nouvelles voitures
      - [ok] un formulaire pour ajouter une nouvelle voiture
    - [ok] Bouton modifier une voiture
      - [ok] un formulaire pour modifier une voiture
    - [ok] Bouton supprimer une voiture

- [ok] Chauffeurs.php : page pour ajouter un nouveau chauffeur 
  - FONCTION :
    - [ok] getChauffeur()
    - [ok] getChauffeurById($id)
    - [ok] addChauffeur()
    - [ok] updateChauffeur()
    - [ok] deleteChauffeur()
  - Page :
    - [ok] Afficher la liste de tous les chauffeurs
    - [ok] Bouton ajouter nouveaux chauffeurs
      - [ok] un formulaire pour ajouter un nouveau chauffeur
    - [ok] Bouton voir les informations du chauffeur

- [ok] detailsChauffeur.php
  -Page:
    - [ok] Afficher les informations du chauffeur
    - [ok] un formulaire pres remplit pour modifier un chauffeur
    - [ok] upload photo de profile

- [] Livraison.php
  - FONCTION:
    - [ok] getLivraisons()
    - [ok] getLivraisonById()
    - [ok] updateLivraison()
    - [ok] deleteLivraison()
    - [ok] addLivraison()
    - [ok] getChauffeurDispo()
    - [ok] getColisDispo()
    - [ok] getLivraisonByIdColis()
    - [] transactionColisLivraison()

  - Page:
    - [ok] Afficher la liste de tous les Livraison
    - [ok] Bouton + pour ajouter une nouvelle Livraison
      - [ok] Formulaire a remplir
    - [] Bouton qui permet de voir les details de cette Livraison

  - Logique:
    [] ajouter une statut EN COURS DE LIVRAISON
    [] colis creer au depart, est EN COURS DE LIVRAISON par defaut

    ____________COLIS____________LIVRAISON____________CHAUFFEUR____________VOITURE____________
.statut       livrer             livrer               disponible        disponible

.annule       annule             annule               disponible        disponible

.en attente   en cours de         en cours de          en plein           en plein
              livr                  livr                livr                livr

.en attente    en attente         disponible            disponible               aucun
de livr          de livr


    [] quand on cree une livraison:
         le statut du colis passe a EN COURS DE LIVRAISON
    [] quand on assigne un chauffeur et une voiture:
         le statut du chauffeur et de la voiture passe a EN PLEIN LIVRAISON
    [] quand la livraison est terminee:
         le statut du colis passe a LIVRE, 
         le statut du chauffeur et de la voiture passe a DISPONIBLE
    [] si on annule une livraison:
         le statut du colis passe a ANNULE, 
         le statut du chauffeur et de la voiture passe a DISPONIBLE


STATUTS POSSIBLES:
  [] colis / livraison :
    - en attente
    - en cours de livraison
    - livre
    - annule

  [] chauffeur :
    - disponible
    - en plein livraisons 
    - en congé

  [] voiture :
    - disponible
    - en plein livraisons
    - en maintenance
    - hors service

🟡 Jaune  → bg-warning
🔵 Bleu   → bg-info
🟢 Vert   → bg-success
🔴 Rouge  → bg-danger




