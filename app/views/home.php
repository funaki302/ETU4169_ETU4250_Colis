<?php include("inc/header.php"); ?>

<main class="container my-5">
    <h2 class="mb-4 text-center fw-bold">Liste des colis</h2>

    <!-- Formulaire de filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="get" action="/" class="row g-3">
                <div class="col-md-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="tous">Tous les statuts</option>
                        <option value="1" <?= isset($_GET['statut']) && $_GET['statut'] == 1 ? 'selected' : '' ?>>En attente</option>
                        <option value="2" <?= isset($_GET['statut']) && $_GET['statut'] == 2 ? 'selected' : '' ?>>Livré</option>
                        <option value="3" <?= isset($_GET['statut']) && $_GET['statut'] == 3 ? 'selected' : '' ?>>Annulé</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="date_min" class="form-label">Date expédition ≥</label>
                    <input type="date" name="date_min" id="date_min" class="form-control" value="<?= htmlspecialchars($_GET['date_min'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label for="date_max" class="form-label">Date expédition ≤</label>
                    <input type="date" name="date_max" id="date_max" class="form-control" value="<?= htmlspecialchars($_GET['date_max'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <label for="nom" class="form-label">Nom du colis</label>
                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Rechercher..." value="<?= htmlspecialchars($_GET['nom'] ?? '') ?>">
                </div>

                <div class="col-md-12 text-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                    <a href="/" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des colis (même code que précédemment) -->
    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($liste as $row): ?>
                <?php
                $id = $row['id_colis'] ?? '';
                $nomColis = htmlspecialchars($row['nom_colis'] ?? 'Colis sans nom');
                $image = $row['imageColis'] ?? null;

                $statutId = $row['id_statut'] ?? null;
                switch ($statutId) {
                    case 1: $statutTexte = "En attente"; $statutBadge = "bg-warning text-dark"; break;
                    case 2: $statutTexte = "Livré"; $statutBadge = "bg-success"; break;
                    case 3: $statutTexte = "Annulé"; $statutBadge = "bg-danger"; break;
                    default: $statutTexte = "Inconnu"; $statutBadge = "bg-secondary"; break;
                }
                ?>
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow transition">
                        <div class="position-absolute top-0 start-0 p-2 z-index-10">
                            <span class="badge <?= $statutBadge ?> fs-6"><?= $statutTexte ?></span>
                        </div>

                        <div class="text-center bg-light" style="height: 250px; overflow: hidden;">
                            <?php if ($image): ?>
                                <img src="/images/<?= htmlspecialchars($image) ?>" class="card-img-top img-fluid h-100 w-100" style="object-fit: cover;" alt="<?= $nomColis ?>">
                            <?php else: ?>
                                <div class="d-flex flex-column justify-content-center align-items-center h-100 text-muted">
                                    <i class="bi bi-image fs-1 mb-3"></i>
                                    <p class="mb-0">Pas encore d'image</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center mb-3"><?= $nomColis ?></h5>
                            <div class="small text-muted mb-3">
                                <div><strong>Expéditeur :</strong> <?= htmlspecialchars($row['nom_expediteur'] ?? '') ?></div>
                                <div><strong>Destinataire :</strong> <?= htmlspecialchars($row['nom_destinataire'] ?? '') ?></div>
                                <div><strong>Date expédition :</strong> <?= htmlspecialchars($row['date_expedition'] ?? '') ?></div>
                                <div><strong>Poids :</strong> <?= htmlspecialchars($row['kilos'] ?? '') ?> kg</div>
                            </div>
                            <div class="mt-auto text-center">
                                <a href="/colis/<?= htmlspecialchars($id) ?>" class="btn btn-primary btn-sm px-4">Voir les détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucun colis correspondant aux critères.</p>
        </div>
    <?php endif; ?>
</main>

<style>
    .hover-shadow { transition: all 0.3s ease; }
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
    .z-index-10 { z-index: 10; }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("inc/footer.php"); ?>