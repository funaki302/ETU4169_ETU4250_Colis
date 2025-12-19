<?php include("inc/header.php"); ?>
<main class="container my-5">
<<<<<<< HEAD
    <h2 class="mb-5 text-center fw-bold display-5 text-primary">
        Liste des colis
    </h2>

    <div class="text-end mb-4">
        <a href="/formInsert" class="btn btn-primary btn-lg px-4 shadow-sm d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Ajouter
        </a>
    </div>
=======
    
    <h2 class="mb-5 text-center fw-bold display-5" style="background: linear-gradient(135deg, #0d6efd, #dc3545); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Liste des Colis
        <button id="btnAddChauffeur" class="btn btn-success" style="-webkit-text-fill-color: white !important; color: white !important;">
           <a href="/formInsert">
            + Ajouter
           </a> 
        </button>
    </h2>
    <br>
>>>>>>> 7e66d60903aaabe69b24c9a54e2fac2c8cf020ec

    <!-- Formulaire de filtres -->
    <div class="card mb-5 border-0 shadow-sm rounded-4 bg-light">
        <div class="card-body p-4">
            <form method="get" action="/" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="statut" class="form-label fw-semibold">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="tous">Tous les statuts</option>
                        <?php foreach ($statuts as $stat) { ?>
                            <option value="<?= $stat['id_statut'] ?>"><?= $stat['statut'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_min" class="form-label fw-semibold">Date expédition ≥</label>
                    <input type="date" name="date_min" id="date_min" class="form-control" value="<?= htmlspecialchars($_GET['date_min'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="date_max" class="form-label fw-semibold">Date expédition ≤</label>
                    <input type="date" name="date_max" id="date_max" class="form-control" value="<?= htmlspecialchars($_GET['date_max'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="nom" class="form-label fw-semibold">Nom du colis</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Rechercher..." value="<?= htmlspecialchars($_GET['nom'] ?? '') ?>">
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm me-3">Filtrer</button>
                    <a href="/" class="btn btn-outline-secondary btn-lg px-5 shadow-sm">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des colis -->
    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($liste as $row): ?>
                <?php
                $id = $row['id_colis'] ?? '';
                $nomColis = htmlspecialchars($row['nom_colis'] ?? 'Colis sans nom');
                $image = $row['imageColis'] ?? null;
                // Statut avec couleurs harmonisées
                $statutId = $row['id_statut'] ?? null;
                switch ($statutId) {
                    case 1: $statutTexte = "En attente"; $statutBadge = "bg-warning text-dark"; break;
                    case 2: $statutTexte = "En cours"; $statutBadge = "bg-info text-dark"; break;
                    case 3: $statutTexte = "Livré"; $statutBadge = "bg-success"; break;
                    case 4: $statutTexte = "Annulé"; $statutBadge = "bg-danger"; break;
                    default: $statutTexte = "Inconnu"; $statutBadge = "bg-secondary"; break;
                }
                ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden transition">
                        <!-- Badge statut -->
                        <div class="position-absolute top-0 start-0 p-3 z-3">
                            <span class="badge <?= $statutBadge ?> fs-6 px-3 py-2 rounded-pill"><?= $statutTexte ?></span>
                        </div>
                        <!-- Image -->
                        <div class="bg-light" style="height: 260px; overflow: hidden;">
                            <?php if ($image): ?>
                                <img src="/images/<?= htmlspecialchars($image) ?>"
                                     class="card-img-top img-fluid h-100 w-100"
                                     style="object-fit: cover; transition: transform 0.5s ease;"
                                     alt="<?= $nomColis ?>">
                            <?php else: ?>
                                <div class="d-flex flex-column justify-content-center align-items-center h-100 text-muted">
                                    <i class="bi bi-package fs-1 mb-3 opacity-50"></i>
                                    <p class="mb-0 small">Pas d'image</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Corps de la carte -->
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title text-center mb-4 fw-bold text-dark"><?= $nomColis ?></h5>
                            <div class="small text-muted mb-4 flex-grow-1">
                                <div class="mb-2"><strong>Expédition :</strong> <?= htmlspecialchars($row['date_expedition'] ?? '') ?></div>
                                <div><strong>Poids :</strong> <?= htmlspecialchars($row['kilos'] ?? '') ?> kg</div>
                            </div>
                            <div class="text-center mt-auto">
                                <a href="/colis/<?= htmlspecialchars($id) ?>"
                                   class="btn btn-primary w-100 shadow-sm">
                                    <i class="bi bi-eye me-2"></i> Voir détails
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5 my-5">
            <i class="bi bi-box-seam display-1 text-muted mb-4 opacity-50"></i>
            <h3 class="text-muted fw-light">Aucun colis trouvé</h3>
            <p class="text-muted mb-4">Essayez d'ajuster les filtres ou ajoutez un nouveau colis.</p>
            <a href="/formInsert" class="btn btn-primary btn-lg px-5 shadow-sm">
                <i class="bi bi-plus-circle me-2"></i> Ajouter un colis
            </a>
        </div>
    <?php endif; ?>
</main>

<!-- Styles personnalisés professionnels -->
<style>
    body {
        background: #f8fbff; /* Fond très clair pour luminosité */
    }
    .transition {
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.15) !important; /* Ombre bleue subtile */
    }
    .card img:hover {
        transform: scale(1.05);
    }
    .btn-primary {
        background: linear-gradient(to right, #0d6efd, #0d8bfd); /* Dégradé bleu subtil */
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(to right, #0a58ca, #0a6fd8);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
    }
    .card {
        background: white;
    }
    .bg-light {
        background: linear-gradient(to bottom, #f1f8ff, #ffffff) !important; /* Dégradé très léger pour les sections */
    }
    h2 {
        position: relative;
    }
    h2::after {
        content: '';
        display: block;
        width: 100px;
        height: 4px;
        background: linear-gradient(to right, #0d6efd, #0dcaf0);
        margin: 20px auto 0;
        border-radius: 2px;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php include("inc/footer.php"); ?>
</body>
</html>