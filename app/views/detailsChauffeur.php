<?php include("inc/header.php"); ?>
<main class="container mt-5">
    <?php if (isset($chauffeur) && is_array($chauffeur) && count($chauffeur) > 0): ?>
        <?php
        $id = $chauffeur['id_chauffeur'] ?? '';
        $profileImage = !empty($chauffeur['profil']) ? '/images/' . htmlspecialchars($chauffeur['profil']) : null;
        $prenom = htmlspecialchars($chauffeur['prenom_chauffeur'] ?? '');
        $nom = htmlspecialchars($chauffeur['nom_chauffeur'] ?? '');
        $nomComplet = trim($prenom . ' ' . $nom);
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <!-- En-tête : Photo + Nom à côté (alignés horizontalement) -->
                        <div class="d-flex align-items-center mb-5">
                            <div class="flex-shrink-0">
                                <?php if ($profileImage): ?>
                                    <img src="<?= $profileImage ?>" class="rounded-circle shadow-lg"
                                        alt="Photo de <?= $nomComplet ?>"
                                        style="width: 160px; height: 160px; object-fit: cover; border: 5px solid #fff;">
                                <?php else: ?>
                                    <div class="rounded-circle bg-light shadow-lg d-flex align-items-center justify-content-center"
                                        style="width: 160px; height: 160px;">
                                        <i class="bi bi-person-circle text-muted" style="font-size: 70px;"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ms-4">
                                <h3 class="mb-1"><?= $nomComplet ?></h3>
                                <span
                                    class="badge bg-primary rounded-pill px-3 py-2"><?= htmlspecialchars($statuts[$chauffeur['id_statut']-1]['statut'] ?? 'Disponible') ?></span>
                                <?php if (!empty($chauffeur['email_chauffeur'])): ?>
                                    <p class="text-muted mb-0 mt-2">
                                        <i
                                            class="bi bi-envelope me-2"></i><?= htmlspecialchars($chauffeur['email_chauffeur']) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <h5 class="text-center mb-4 text-muted">Modifier le profil</h5>
                        <form method="post" action="/chauffeur/update" enctype="multipart/form-data">
                            <input type="hidden" name="id_chauffeur" value="<?= htmlspecialchars($id) ?>">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-person me-2"></i>Prénom</label>
                                    <input type="text" name="prenom_chauffeur" class="form-control" value="<?= $prenom ?>"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-person-badge me-2"></i>Nom</label>
                                    <input type="text" name="nom_chauffeur" class="form-control" value="<?= $nom ?>"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-telephone me-2"></i>Téléphone</label>
                                    <input type="text" name="telephone_chauffeur" class="form-control"
                                        value="<?= htmlspecialchars($chauffeur['telephone_chauffeur'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-envelope me-2"></i>Email</label>
                                    <input type="email" name="email_chauffeur" class="form-control"
                                        value="<?= htmlspecialchars($chauffeur['email_chauffeur'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-calendar-event me-2"></i>Date
                                        d'assignation</label>
                                    <input type="date" name="date_dassignation" class="form-control"
                                        value="<?= htmlspecialchars($chauffeur['date_dassignation'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-currency-euro me-2"></i>Salaire par
                                        livraison</label>
                                    <input type="number" step="0.01" name="salaires_parLiv" class="form-control"
                                        value="<?= htmlspecialchars($chauffeur['salaires_parLiv'] ?? '') ?>">
                                </div>

                                <!-- Upload photo de profil -->
                                <input type="hidden" name="profil_actuel" value="<?= htmlspecialchars($chauffeur['profil'] ?? '') ?>">
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-image me-2"></i>Photo de profil</label>
                                    <input type="file" name="profil" accept="image/*" class="form-control">
                                    <?php if ($profileImage): ?>
                                        <small class="text-muted d-block mt-2">
                                            <i class="bi bi-check-circle text-success me-1"></i>
                                            Photo actuelle : <?= htmlspecialchars($chauffeur['profil']) ?>
                                        </small>
                                    <?php else: ?>
                                        <small class="text-muted d-block mt-2">Aucune photo pour le moment</small>
                                    <?php endif; ?>
                                </div>

                                <!-- Statut -->
                                <div class="col-md-6">
                                    <label class="form-label"><i class="bi bi-person-check me-2"></i>Statut du
                                        chauffeur</label>
                                    <select name="id_statut" class="form-select">
                                        <option value="<?= htmlspecialchars($chauffeur['id_statut']) ?>"><?= $statuts[$chauffeur['id_statut'] - 1]['statut'] ?>
                                           </option>
                                        <?php $taille = count($statuts); ?>
                                        <?php for ($i = 1; $i < $taille; $i++): ?>
                                            <?php if ($statuts[$i]['id_statut'] !== ($chauffeur['id_statut'])) { ?>
                                                <option value="<?= htmlspecialchars($statuts[$i]['id_statut']) ?>"><?= $statuts[$i]['statut'] ?>
                                                </option>
                                            <?php }
                                        endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                                    <i class="bi bi-check-lg me-2"></i>Mettre à jour le profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle fs-3"></i>
                    <p class="mt-3 mb-0">Chauffeur introuvable.</p>
                    <a href="/chauffeurs" class="btn btn-secondary mt-3">Retour à la liste</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>
<?php include("inc/footer.php"); ?>
</body>

</html>