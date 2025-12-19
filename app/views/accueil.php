<?php include("inc/header.php"); ?>
<link href="/assets/css/style1.css" rel="stylesheet">

<!-- Bannière Hero -->
<section class="hero-banner text-white position-relative overflow-hidden">
    <div class="stars-background"></div>
    <div class="container py-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">
                    Gestion de Livraison de Colis
                </h1>
                <p class="lead mb-5 opacity-90 animate__animated animate__fadeInUp">
                    Suivez, gérez et optimisez vos livraisons intergalactiques avec précision et rapidité.
                </p>
                <a href="#dashboard-cards" class="btn btn-primary btn-lg px-5 py-3 shadow-lg">
                    Explorer le tableau de bord <i class="bi bi-rocket-takeoff ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="wave-bottom"></div>
</section>

<!-- Section Cartes Dashboard -->
<section id="dashboard-cards" class="py-5  text-white">
    <div class="container">
        <div class="row g-5 justify-content-center">

            <!-- Livraisons : grande carte seule sur la première ligne -->
            <div class="col-12 ">
                <div class="dashboard-card featured-card h-100 p-5 rounded-4 shadow-lg border-0 position-relative overflow-hidden">
                    <div class="icon-circle large mb-4">
                        <i class="bi bi-truck fs-1"></i>
                    </div>
                    <h3 class="h3 fw-bold">Livraisons</h3>
                    <p class="text-muted fs-5">
                        Suivez en temps réel toutes vos livraisons en cours, planifiées ou terminées.
                    </p>
                    <a href="/livraisons" class="stretched-link text-decoration-none text-primary fw-bold fs-5">
                        Voir les livraisons →
                    </a>
                    <div class="card-glow"></div>
                </div>
            </div>

            <!-- Ligne 1 : Colis + Bénéfices -->
            <div class="col-12 col-md-6">
                <div class="dashboard-card h-100 p-4 rounded-4 shadow-lg border-0 position-relative overflow-hidden">
                    <div class="icon-circle mb-4">
                        <i class="bi bi-box-seam fs-1"></i>
                    </div>
                    <h3 class="h4 fw-bold">Colis</h3>
                    <p class="text-muted">
                        Gérez l'inventaire de tous vos colis en attente de livraison.
                    </p>
                    <a href="/" class="stretched-link text-decoration-none text-primary fw-bold">
                        Gérer les colis →
                    </a>
                    <div class="card-glow"></div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="dashboard-card h-100 p-4 rounded-4 shadow-lg border-0 position-relative overflow-hidden">
                    <div class="icon-circle mb-4">
                        <i class="bi bi-graph-up-arrow fs-1"></i>
                    </div>
                    <h3 class="h4 fw-bold">Bénéfices</h3>
                    <p class="text-muted">
                        Analysez vos performances, revenus et statistiques de livraison.
                    </p>
                    <a href="/benefices" class="stretched-link text-decoration-none text-primary fw-bold">
                        Voir les statistiques →
                    </a>
                    <div class="card-glow"></div>
                </div>
            </div>

            <!-- Ligne 2 : Voitures + Chauffeurs -->
            <div class="col-12 col-md-6">
                <div class="dashboard-card h-100 p-4 rounded-4 shadow-lg border-0 position-relative overflow-hidden">
                    <div class="icon-circle mb-4">
                        <i class="bi bi-car-front fs-1"></i>
                    </div>
                    <h3 class="h4 fw-bold">Voitures</h3>
                    <p class="text-muted">
                        Gérez votre flotte de véhicules de livraison avec suivi et maintenance.
                    </p>
                    <a href="/voitures" class="stretched-link text-decoration-none text-primary fw-bold">
                        Voir la flotte →
                    </a>
                    <div class="card-glow"></div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="dashboard-card h-100 p-4 rounded-4 shadow-lg border-0 position-relative overflow-hidden">
                    <div class="icon-circle mb-4">
                        <i class="bi bi-person-arms-up fs-1"></i>
                    </div>
                    <h3 class="h4 fw-bold">Chauffeurs</h3>
                    <p class="text-muted">
                        Consultez et gérez les profils de tous vos chauffeurs livreurs.
                    </p>
                    <a href="/chauffeurs" class="stretched-link text-decoration-none text-primary fw-bold">
                        Voir les chauffeurs →
                    </a>
                    <div class="card-glow"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include("inc/footer.php"); ?>