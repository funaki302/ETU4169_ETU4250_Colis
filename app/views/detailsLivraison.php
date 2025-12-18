
<?php include("inc/header.php"); ?>
<main class="container mt-5">
	<?php if (isset($livraison) && is_array($livraison) && count($livraison) > 0): ?>
		<?php
		$id = $livraison['id_livraison'] ?? '';
		$date = htmlspecialchars($livraison['date_livraison'] ?? '');
		$heure = htmlspecialchars($livraison['heure_livraison'] ?? '');
		$id_statut = $livraison['id_statut'] ?? null;
        switch ($id_statut) {
            case 1: $statutTexte = "En attente"; $statutBadge = 'bg-warning text-dark'; break;
            case 2: $statutTexte = "En cours"; $statutBadge = 'bg-info text-dark'; break;
            case 3: $statutTexte = "Livrée"; $statutBadge = 'bg-success'; break;
            case 4: $statutTexte = "Annulée"; $statutBadge = 'bg-danger'; break;
            default: $statutTexte = $row['statut'] ?? 'Inconnu'; $statutBadge = 'bg-secondary'; break;
        }
		?>

		<div class="row justify-content-center">
			<div class="col-lg-8 col-xl-7">
				<div class="card border-0 shadow-sm">
					<div class="card-body p-4 p-md-5">
						<div class="d-flex justify-content-between align-items-start mb-4">
							<div>
								<div class="text-muted small">ID livraison: <?= htmlspecialchars($id) ?></div>
							</div>
							<div class="text-end">
								<span class="badge <?= $statutBadge ?> mb-2"><?= $statutTexte ?></span>
								<div class="small text-muted">Date: <?= $date ?> <?= $heure ?></div>
							</div>
						</div>

						<h5 class="text-center mb-4 text-muted">Modifier la livraison</h5>
						<form method="post" action="/livraison/update" enctype="multipart/form-data">
							<input type="hidden" name="id_livraison" value="<?= htmlspecialchars($id) ?>">
							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label">Colis</label>
									<p><strong><?= htmlspecialchars($colis['nom_colis'] ?? 'Colis non spécifié') ?></strong></p>
								</div>

								<div class="col-md-6">
									<label class="form-label">Statut</label>
									<select name="id_statut" class="form-select">
										<option value="<?= $id_statut ?>"><?= htmlspecialchars($statutTexte) ?></option>
										<?php if (!empty($statuts)): ?>
											<?php foreach ($statuts as $s): 
                                                if ($s['id_statut'] !== $id_statut) { ?>
                                                    <option value="<?= htmlspecialchars($s['id_statut']) ?>">
                                                        <?= htmlspecialchars($s['statut']) ?></option> 
                                                <?php } ?>
											<?php endforeach; ?>
										<?php else: ?>
											<option value="">Aucun statut</option>
										<?php endif; ?>
									</select>
								</div>

								<div class="col-md-6">
									<label class="form-label">Date</label>
									<input type="date" name="date_livraison" class="form-control" value="<?= htmlspecialchars($livraison['date_livraison'] ?? '') ?>">
								</div>
								<div class="col-md-6">
									<label class="form-label">Heure</label>
									<input type="time" name="heure_livraison" class="form-control" value="<?= htmlspecialchars($livraison['heure_livraison'] ?? '') ?>">
								</div>

								<div class="col-md-6">
									<label class="form-label">Chauffeur</label>
                                    <p><strong><?= htmlspecialchars($chauffeur['prenom_chauffeur'] ?? '') ?> <?= htmlspecialchars($chauffeur['nom_chauffeur'] ?? '') ?></strong></p>
								</div>

								<div class="col-md-6">
									<label class="form-label">Voiture</label>
                                    <p><strong><?= htmlspecialchars($voiture['marque'] ?? '') ?> <?= htmlspecialchars($voiture['modele'] ?? '') ?></strong></p>
								</div>

							</div>

							<div class="text-center mt-4">
								<button type="submit" class="btn btn-primary btn-lg px-4">
									<i class="bi bi-check-lg me-2"></i>Enregistrer
								</button>
								<a href="/livraisons" class="btn btn-secondary btn-lg ms-2">Retour</a>
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
					<p class="mt-3 mb-0">Livraison introuvable.</p>
					<a href="/livraisons" class="btn btn-secondary mt-3">Retour à la liste</a>
				</div>
			</div>
		</div>
	<?php endif; ?>
</main>
<?php include("inc/footer.php"); ?>
</body>

</html>
