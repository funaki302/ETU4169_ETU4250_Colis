<?php include("inc/header.php"); ?>

<main class="container my-5">
    <h2 class="mb-4 text-center fw-bold">Liste des livraisons
        <button id="btnAddLivraison" class="btn btn-success ms-3">+</button>
    </h2>

    <!-- Filtres -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="get" action="/livraisons" class="row g-3">

                <div class="col-md-4">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="tous">Tous</option>
                        <option value="en_attente" <?= (($_GET['statut'] ?? '') === 'en_attente') ? 'selected' : '' ?>>En attente</option>
                        <option value="en_cours" <?= (($_GET['statut'] ?? '') === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                        <option value="livree" <?= (($_GET['statut'] ?? '') === 'livree') ? 'selected' : '' ?>>Livrée</option>
                        <option value="annulee" <?= (($_GET['statut'] ?? '') === 'annulee') ? 'selected' : '' ?>>Annulée</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end justify-content-end">
                    <div>
                        <button type="submit" class="btn btn-primary me-2">Filtrer</button>
                        <a href="/livraisons" class="btn btn-outline-secondary">Réinitialiser</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($liste as $row): ?>
                <?php
                $statutId = $row['id_statut'] ?? null;
                switch ($statutId) {
                    case 1: $statutTexte = "En attente"; $statutBadge = 'bg-warning text-dark'; break;
                    case 2: $statutTexte = "En cours"; $statutBadge = 'bg-info text-dark'; break;
                    case 3: $statutTexte = "Livrée"; $statutBadge = 'bg-success'; break;
                    case 4: $statutTexte = "Annulée"; $statutBadge = 'bg-danger'; break;
                    default: $statutTexte = $row['statut'] ?? 'Inconnu'; $statutBadge = 'bg-secondary'; break;
                }
                ?>

                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0"><?= htmlspecialchars($row['destinataire'] ?? $row['nom_destinataire'] ?? '') ?></h5>
                                <span class="badge <?= $statutBadge ?>"><?= htmlspecialchars($statutTexte) ?></span>
                            </div>

                            <div class="small text-muted mb-3">
                                <h3>Livraison #<?= htmlspecialchars($row['id_livraison'] ?? '') ?></h3>
                                <div><strong>Date de livraison :</strong> <?= htmlspecialchars($row['date_livraison'] ?? '') ?></div>
                                <div><strong>Heure de livraison :</strong> <?= htmlspecialchars($row['heure_livraison'] ?? '') ?></div>
                            </div>

                            <div class="mt-auto text-end">
                                <a href="/livraison/<?= htmlspecialchars($row['id_livraison'] ?? $row['id'] ?? '') ?>" class="btn btn-primary btn-sm">Détails</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucune livraison correspondant aux critères.</p>
        </div>
    <?php endif; ?>

    <div id="formLivraison" class="card mt-4" style="display:none;">
        <div class="card-body">
            <h5 class="card-title">Ajouter une nouvelle livraison</h5>
            <form method="post" action="/livraisons/add" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Colis</label>
                    <select name="id_colis" class="form-select">
                        <?php if (!empty($colis)): ?>
                            <?php foreach ($colis as $col): ?>
                                <option value="<?= htmlspecialchars($col['id_colis']) ?>"><?= htmlspecialchars($col['nom_colis'] ?? ($col['description'] ?? 'Colis')) ?> (ID: <?= htmlspecialchars($col['id_colis']) ?>)</option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Aucun colis disponible</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date livraison</label>
                        <input name="date_livraison" type="date" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Heure livraison</label>
                        <input name="heure_livraison" type="time" class="form-control" />
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select name="id_statut" class="form-select">
                        <?php if (!empty($statuts)): ?>
                            <?php foreach ($statuts as $s): ?>
                                <option value="<?= htmlspecialchars($s['id_statut']) ?>"><?= htmlspecialchars($s['statut']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">Aucun statut disponible</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Chauffeur</label>
                        <select name="id_chauffeur" class="form-select">
                            <?php if (!empty($chauffeurs)): ?>
                                <?php foreach ($chauffeurs as $ch): ?>
                                    <option value="<?= htmlspecialchars($ch['id_chauffeur']) ?>"><?= htmlspecialchars(($ch['prenom_chauffeur'] ?? '') . ' ' . ($ch['nom_chauffeur'] ?? '')) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Aucun chauffeur disponible</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Voiture</label>
                        <select name="id_voiture" class="form-select">
                            <?php if (!empty($voitures)): ?>
                                <?php foreach ($voitures as $v): ?>
                                    <option value="<?= htmlspecialchars($v['id_voiture']) ?>"><?= htmlspecialchars(($v['marque'] ?? '') . ' ' . ($v['modele'] ?? '')) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Aucune voiture disponible</option>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Remarques</label>
                    <textarea name="remarques" class="form-control" rows="3"></textarea>
                </div>

                <button class="btn btn-primary">Enregistrer</button>
                <button type="button" id="btnCancelLivraison" class="btn btn-secondary ms-2">Annuler</button>
            </form>
        </div>
    </div>

</main>

<?php include("inc/footer.php"); ?>

<script nonce="<?= htmlspecialchars($csp_nonce ?? '') ?>">
    document.getElementById('btnAddLivraison').addEventListener('click', function () {
        document.getElementById('formLivraison').style.display = 'block';
        window.location.hash = '#formLivraison';
    });
    document.getElementById('btnCancelLivraison').addEventListener('click', function () {
        document.getElementById('formLivraison').style.display = 'none';
    });
</script>
</body>

</html>