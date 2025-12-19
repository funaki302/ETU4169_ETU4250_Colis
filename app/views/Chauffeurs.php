<?php include("inc/header.php"); ?>

<main class="container my-5">
    <h2 class="mb-5 text-center fw-bold display-5" style="background: linear-gradient(135deg, #0d6efd, #dc3545); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        Liste des Chauffeurs
        <button id="btnAddChauffeur" class="btn btn-success" style="-webkit-text-fill-color: white !important; color: white !important;">
            + Ajouter
        </button>
    </h2>
    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($liste as $row): ?>
                <?php
                $statutId = $row['id_statut'] ?? null;
                switch ($statutId) {
                    case 1: $statutTexte = "Disponible"; $class = "bg-success"; break;
                    case 2: $statutTexte = "En plein livraison"; $class = "bg-warning"; break;
                    case 3: $statutTexte = "En congé"; $class = "bg-danger"; break;
                    default: $statutTexte = "Inconnu"; $class = "bg-secondary"; break;
                }
                ?>
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow transition">
                        <div class="position-absolute top-0 start-0 p-2 z-index-10">
                            <span class="badge <?= $class ?> fs-6"><?= $statutTexte ?></span>
                        </div>

                        <div class="text-center bg-light" style="height: 250px; overflow: hidden;">
                            <?php if ($row['profil']): ?>
                                <img src="/images/<?= htmlspecialchars($row['profil']) ?>"
                                    class="card-img-top img-fluid h-100 w-100" style="object-fit: cover;" alt="">
                            <?php else: ?>
                                <div class="d-flex flex-column justify-content-center align-items-center h-100 text-muted">
                                    <i class="bi bi-image fs-1 mb-3"></i>
                                    <p class="mb-0">Pas de profile</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-center mb-3"><?= $row['nom_chauffeur'] ?>         <?= $row['prenom_chauffeur'] ?>
                            </h5>
                            <div class="small text-muted mb-3">
                                <div><strong>Telephone :</strong> <?= htmlspecialchars($row['telephone_chauffeur'] ?? '') ?>
                                </div>
                                <div><strong>Email :</strong> <?= htmlspecialchars($row['email_chauffeur'] ?? '') ?></div>
                                <div><strong>Date d'assignation :</strong>
                                    <?= htmlspecialchars($row['date_dassignation'] ?? '') ?></div>
                                <div><strong>Salaire par livraison :</strong>
                                    <?= htmlspecialchars($row['salaires_parLiv'] ?? '') ?> $</div>
                            </div>
                            <div class="mt-auto text-center">
                                <a href="/chauffeur/<?= htmlspecialchars($row['id_chauffeur']) ?>"
                                    class="btn btn-primary btn-sm px-4">Plus d'nformations</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-box-seam fs-1 text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucun chauffeur correspondant aux critères.</p>
        </div>
    <?php endif; ?>

    <div id="formChauffeur" class="card mt-4" style="display:none;">
        <div class="card-body">
            <h5 class="card-title">Ajouter un nouveau chauffeur</h5>
            <form method="post" action="/chauffeurs/add" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nom</label>
                        <input name="nom_chauffeur" class="form-control" required />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prénom</label>
                        <input name="prenom_chauffeur" class="form-control" required />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Téléphone</label>
                    <input name="telephone_chauffeur" class="form-control" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email_chauffeur" type="email" class="form-control" />
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date d'assignation</label>
                        <input name="date_dassignation" type="date" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Salaire par livraison</label>
                        <input name="salaires_parLiv" type="number" step="0.01" class="form-control" />
                    </div>
                    <div class="col-md-6">
                        <label for="imageColis" class="form-label fw-semibold text-dark">Ajouter une
                            photo</label>
                        <input type="file" name="profil" id="profil" class="form-control" accept="image/*">
                        <div class="form-text">Sélectionnez une image (JPG, PNG, WebP). Vous pouvez en ajouter
                            plusieurs fois.</div>
                    </div>
                </div>
                <br>
                <button class="btn btn-primary">Enregistrer</button>
                <button type="button" id="btnCancelChauffeur" class="btn btn-secondary">Annuler</button>
            </form>
        </div>
    </div>
</main>

<?php include("inc/footer.php"); ?>

<script nonce="<?= htmlspecialchars($csp_nonce ?? '') ?>">
    document.getElementById('btnAddChauffeur').addEventListener('click', function () {
        document.getElementById('formChauffeur').style.display = 'block';
        window.location.hash = '#formChauffeur';
    });
    document.getElementById('btnCancelChauffeur').addEventListener('click', function () {
        document.getElementById('formChauffeur').style.display = 'none';
    });
</script>
</body>

</html>