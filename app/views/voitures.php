<?php include ("inc/header.php"); ?>

<style>
    .voiture-card img { height: 180px; object-fit: cover; }
    .voiture-badge { font-size: 0.85rem; }
    .voiture-actions a { min-width: 90px; }
</style>

<main class="container my-5">
    <h2 class="mb-5 text-center fw-bold display-5" style="background: linear-gradient(135deg, #0d6efd, #dc3545); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Liste des Voitures
        <button id="btnAdd" class="btn btn-success" style="-webkit-text-fill-color: white !important; color: white !important;">
            + Ajouter
        </button>
    </h2>

    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($liste as $row): ?>
                <?php
                    $id = htmlspecialchars($row['id_voiture'] ?? '');
                    $marque = htmlspecialchars($row['marque'] ?? '');
                    $modele = htmlspecialchars($row['modele'] ?? '');
                    $immatriculation = htmlspecialchars($row['immatriculation'] ?? '');
                    $capacite = htmlspecialchars($row['capacite'] ?? '');
                    $carburant = htmlspecialchars($carburants[($row['id_carburant'] ?? 1)-1]['type_carburant'] ?? '');
                    $statutIdx = $row['id_statut'] ?? null;
                    switch ($statutIdx) {
                        case 1: $badgeClass = 'bg-success'; $statutText = 'Disponible'; break;
                        case 2: $badgeClass = 'bg-warning text-dark'; $statutText = 'En service'; break;
                        case 3: $badgeClass = 'bg-danger'; $statutText = 'En panne'; break;
                        default: $badgeClass = 'bg-secondary'; $statutText = $statut_voiture[($statutIdx-1)]['statut'] ?? 'Inconnu'; break;
                    }
                    $image = !empty($row['imageVoiture']) ? '/images/' . htmlspecialchars($row['imageVoiture']) : null;
                ?>

                <div class="col">
                    <div class="card h-100 shadow-sm voiture-card">
                        <?php if ($image): ?>
                            <img src="<?= $image ?>" class="card-img-top" alt="Voiture <?= $marque ?> <?= $modele ?>">
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                                <i class="bi bi-car-front fs-1 text-muted"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title mb-1"><?= $marque ?> <?= $modele ?></h5>
                                    <div class="text-muted small">Immatriculation: <?= $immatriculation ?></div>
                                </div>
                                <span class="badge voiture-badge <?= $badgeClass ?>"><?= htmlspecialchars($statutText) ?></span>
                            </div>

                            <div class="mb-3 small text-muted">
                                <div><strong>Capacité:</strong> <?= $capacite ?></div>
                                <div><strong>Carburant:</strong> <?= $carburant ?></div>
                                <div><strong>benefice:</strong><a href=" /voiture/benefice/">voir benefice</a> </div>
                               
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucune voiture trouvée.</p>
        </div>
    <?php endif; ?>

    <div id="formContainer" class="card mt-4" style="display:none;">
        <div class="card-body">
            <h5 class="card-title">Ajouter une nouvelle voiture</h5>
            <form method="post" action="/voitures/add" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Immatriculation</label>
                    <input name="immatriculation" class="form-control" required />
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Marque</label>
                        <input name="marque" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Modèle</label>
                        <input name="modele" class="form-control" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Capacité (Puissance)</label>
                        <input name="capacite" type="number" class="form-control" value="1" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Statut</label>
                        <select name="statut_voiture" class="form-select">
                            <?php if (isset($statut_voiture)) {
                                foreach ($statut_voiture as $stat) { ?>
                                    <option value="<?= htmlspecialchars($stat['id_statut']) ?>"><?= htmlspecialchars($stat['statut']) ?></option>
                                <?php }
                            } else { ?>
                                <option value="1">Disponible</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Carburant</label>
                        <select name="id_carburant" class="form-select">
                            <?php if (isset($carburants)) {
                                foreach ($carburants as $carburant) { ?>
                                    <option value="<?= htmlspecialchars($carburant['id_carburant']) ?>"><?= htmlspecialchars($carburant['type_carburant']) ?></option>
                                <?php }
                            } else { ?>
                                <option value="1">Essence</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="imageVoiture" class="form-label">Ajouter une photo</label>
                        <input type="file" name="imageVoiture" id="imageVoiture" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Enregistrer</button>
                    <button type="button" id="btnCancel" class="btn btn-secondary ms-2">Annuler</button>
                </div>
            </form>
        </div>
    </div>

</main>

<?php include ("inc/footer.php"); ?>

<script nonce="<?= htmlspecialchars($csp_nonce ?? '') ?>">
    document.getElementById('btnAdd').addEventListener('click', function(){
        document.getElementById('formContainer').style.display = 'block';
        window.location.hash = '#formContainer';
    });
    document.getElementById('btnCancel').addEventListener('click', function(){
        document.getElementById('formContainer').style.display = 'none';
    });
</script>
</body>
</html>
