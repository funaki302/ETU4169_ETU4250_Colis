<?php include("inc/header.php"); ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <?php if (isset($colis) && is_array($colis) && count($colis) > 0): ?>
                <?php $id = $colis['id_colis'] ?? ''; ?>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <!-- En-tête dégradé bleu fluide -->
                    <div class="card-header text-white text-center py-5"
                        style="background: linear-gradient(135deg, #0d6efd, #a92a2aff);">
                        <h2 class="mb-0 fw-bold fs-2">
                            Détails du colis #<?= htmlspecialchars($id) ?>
                        </h2>
                        <p class="mb-0 mt-2 fs-5 opacity-90">
                            Gérer les informations et les photos du colis
                        </p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">

                        <!-- ======================== -->
                        <!-- SECTION IMAGES EXISTANTES -->
                        <!-- ======================== -->
            

                        <?php if (!empty($imageColis) && is_array($imageColis)): ?>
                            <h4 class="mb-4 text-primary fw-semibold">
                                <i class="bi bi-images me-2"></i> Photos du colis (<?= count($imageColis) ?>)
                            </h4>

                            <!-- Galerie avec scroll horizontal -->
                            <div class="overflow-auto mb-5" style="max-width: 100%;">
                                <div class="d-flex flex-nowrap gap-3 pb-3" style="scroll-behavior: smooth;">
                                    <?php foreach ($imageColis as $photo): ?>
                                        <div class="flex-shrink-0" style="width: 280px;">
                                            <div class="position-relative overflow-hidden rounded-4 shadow hover-shadow">
                                                <img src="/images/<?= htmlspecialchars($photo['imageColis']) ?>"
                                                    class="img-fluid w-100 rounded-4"
                                                    style="height: 280px; object-fit: cover; transition: transform 0.4s ease;"
                                                    alt="Photo du colis <?= $id ?>" data-bs-toggle="modal"
                                                    data-bs-target="#imageModal<?= htmlspecialchars($photo['imageColis']) ?>">
                                            </div>
                                        </div>

                                        <!-- Modal zoom -->
                                        <div class="modal fade" id="imageModal<?= htmlspecialchars($photo['imageColis']) ?>"
                                            tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content border-0 shadow-lg overflow-hidden">
                                                    <div class="modal-body p-0">
                                                        <img src="/images/<?= htmlspecialchars($photo['imageColis']) ?>"
                                                            class="img-fluid w-100" alt="Zoom photo">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Indicateur de scroll (optionnel mais joli) -->
                            <div class="text-center text-muted small mb-4">
                                <i class="bi bi-arrow-left-right me-2"></i> Faites défiler pour voir plus de photos
                            </div>

                        <?php else: ?>
                            <div class="alert alert-info text-center py-5 mb-5 rounded-4 border-0 shadow-sm">
                                <i class="bi bi-image fs-1 mb-3 text-muted opacity-75"></i>
                                <p class="mb-0 fw-semibold">Aucune photo pour ce colis</p>
                                <small>Ajoutez-en une ci-dessous</small>
                            </div>
                        <?php endif; ?>
                        <!-- ========================= -->
                        <!-- FORMULAIRE DE MISE À JOUR -->
                        <!-- ========================= -->
                        <h4 class="mb-4 text-primary fw-semibold">
                            <i class="bi bi-pencil-square me-2"></i> Modifier les informations
                        </h4>

                        <form action="/colis/update/" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id_colis" value="<?= htmlspecialchars($id) ?>">

                            <div class="row g-4">
                                <!-- ID Colis (affichage uniquement) -->
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded-3 border-start border-primary border-5">
                                        <strong class="text-primary fs-5">ID Colis : #<?= htmlspecialchars($id) ?></strong>
                                    </div>
                                </div>

                                <!-- Nom du colis -->
                                <div class="col-12">
                                    <label for="nom_colis" class="form-label fw-semibold text-dark">Nom du colis</label>
                                    <input type="text" name="nom_colis" id="nom_colis" class="form-control form-control-lg"
                                        value="<?= htmlspecialchars($colis['nom_colis'] ?? '') ?>" required>
                                </div>

                                <!-- Expéditeur -->
                                <div class="col-md-6">
                                    <label for="nom_expediteur" class="form-label fw-semibold text-dark">Nom
                                        expéditeur</label>
                                    <input type="text" name="nom_expediteur" id="nom_expediteur" class="form-control"
                                        value="<?= htmlspecialchars($colis['nom_expediteur'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="adresse_expediteur" class="form-label fw-semibold text-dark">Adresse
                                        expéditeur</label>
                                    <input type="text" name="adresse_expediteur" id="adresse_expediteur"
                                        class="form-control"
                                        value="<?= htmlspecialchars($colis['adresse_expediteur'] ?? '') ?>" required>
                                </div>

                                <!-- Destinataire -->
                                <div class="col-md-6">
                                    <label for="nom_destinataire" class="form-label fw-semibold text-dark">Nom
                                        destinataire</label>
                                    <input type="text" name="nom_destinataire" id="nom_destinataire" class="form-control"
                                        value="<?= htmlspecialchars($colis['nom_destinataire'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="adresse_destinataire" class="form-label fw-semibold text-dark">Adresse
                                        destinataire</label>
                                    <input type="text" name="adresse_destinataire" id="adresse_destinataire"
                                        class="form-control"
                                        value="<?= htmlspecialchars($colis['adresse_destinataire'] ?? '') ?>" required>
                                </div>

                                <!-- Dates et poids -->
                                <div class="col-md-4">
                                    <label for="date_expedition" class="form-label fw-semibold text-dark">Date
                                        expédition</label>
                                    <input type="date" name="date_expedition" id="date_expedition" class="form-control"
                                        value="<?= htmlspecialchars($colis['date_expedition'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="date_livraison" class="form-label fw-semibold text-dark">Date
                                        livraison</label>
                                    <input type="date" name="date_livraison" id="date_livraison" class="form-control"
                                        value="<?= htmlspecialchars($colis['date_livraison'] ?? '') ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="kilos" class="form-label fw-semibold text-dark">Poids (kg)</label>
                                    <input type="number" step="0.01" name="kilos" id="kilos" class="form-control"
                                        value="<?= htmlspecialchars($colis['kilos'] ?? '') ?>" required>
                                </div>

                                <!-- Statut -->
                                <input type="hidden" name="id_statut" value="<?= htmlspecialchars($colis['id_statut'] ?? '') ?>">

                                <div class="col-12">
                                    <label for="imageColis" class="form-label fw-semibold text-dark">Ajouter une
                                        photo</label>
                                    <input type="file" name="imageColis" id="imageColis" class="form-control"
                                        accept="image/*">
                                    <div class="form-text">Sélectionnez une image (JPG, PNG, WebP). Vous pouvez en ajouter
                                        plusieurs fois.</div>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="text-center mt-5 pt-4 border-top">
                                <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm me-3">
                                    <i class="bi bi-check-circle-fill me-2"></i> Mettre à jour
                                </button>
                                <a href="/" class="btn btn-outline-secondary btn-lg px-5 shadow-sm">
                                    <i class="bi bi-arrow-left-circle me-2"></i> Retour à la liste
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted mb-4"></i>
                    <h3 class="text-muted">Colis introuvable</h3>
                    <p class="text-muted mb-4">Le colis demandé n'existe pas.</p>
                    <a href="/" class="btn btn-primary btn-lg px-5 shadow-sm">
                        <i class="bi bi-house-door me-2"></i> Retour
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<?php include("inc/footer.php"); ?>
</body>

</html>