<?php include("inc/header.php"); ?>

<main class="container my-5">
	<h2 class="mb-5 text-center fw-bold display-5" style="background: linear-gradient(135deg, #0d6efd, #20c997); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
		Liste des Trajets
		<button id="btnAddTrajet" class="btn btn-success" style="-webkit-text-fill-color: white !important; color: white !important;">
			+
		</button>
	</h2>

	<?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
		<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
			<?php foreach ($liste as $row): ?>
				<div class="col">
					<div class="card h-100 shadow-sm">
						<div class="card-body d-flex flex-column">
							<div class="d-flex justify-content-between align-items-start mb-2">
								<h5 class="card-title mb-0"><?= htmlspecialchars($row['nom_trajet'] ?? ($row['nom'] ?? 'Trajet')) ?></h5>
								<span class="badge bg-primary"><?= htmlspecialchars($row['zone'] ?? '') ?></span>
							</div>

							<div class="small text-muted mb-3">
								<div><strong>Départ :</strong> <?= htmlspecialchars($row['adresse_depart'] ?? '') ?></div>
								<div><strong>Arrivée :</strong> <?= htmlspecialchars($row['adresse_arrivee'] ?? '') ?></div>
								<div><strong>Taux de recomponse:</strong> <?= htmlspecialchars($row['taux'] ?? '') ?> %</div>
							</div>

							<div class="mt-auto text-end">
								<a href="/zone/<?= htmlspecialchars($row['id_trajet'] ?? $row['id'] ?? '') ?>" class="btn btn-primary btn-sm">Détails</a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="text-center py-5">
			<i class="bi bi-geo-alt fs-1 text-muted mb-3"></i>
			<p class="text-muted fs-5">Aucun trajet disponible.</p>
		</div>
	<?php endif; ?>

	<div id="formTrajet" class="card mt-4" style="display:none;">
		<div class="card-body">
			<h5 class="card-title">Ajouter un nouveau trajet</h5>

			<div id="errorMessageTrajet" class="alert alert-danger" style="display:none;"></div>

			<form id="formAddTrajet" method="post" action="/zone/add">

				<div class="row">
					<div class="col-md-6 mb-3">
						<label class="form-label">Point de départ</label>
						<input name="adresse_depart" type="text" class="form-control" required />
					</div>
					<div class="col-md-6 mb-3">
						<label class="form-label">Point d'arrivée</label>
						<input name="point_arrivee" type="text" class="form-control" required />
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 mb-3">
						<label class="form-label">Taux de recomponse(%)</label>
						<input name="taux" type="number" step="0.1" class="form-control" />
					</div>
					<div class="col-md-6 mb-3">
						<label class="form-label">Dispo (0/1)</label>
						<input name="dispo" type="number" class="form-control" />
					</div>
				</div>

				<button type="submit" id="btnSubmitTrajet" class="btn btn-primary">Enregistrer</button>
				<button type="button" id="btnCancelTrajet" class="btn btn-secondary ms-2">Annuler</button>
			</form>
		</div>
	</div>

</main>

<?php include("inc/footer.php"); ?>

<script nonce="<?= htmlspecialchars($csp_nonce ?? '') ?>">
	const btnAdd = document.getElementById('btnAddTrajet');
	const formTrajet = document.getElementById('formTrajet');
	const btnCancel = document.getElementById('btnCancelTrajet');
	const form = document.getElementById('formAddTrajet');
	const errorMessage = document.getElementById('errorMessageTrajet');

	btnAdd.addEventListener('click', function () {
		formTrajet.style.display = 'block';
		formTrajet.scrollIntoView({ behavior: 'smooth' });
		errorMessage.style.display = 'none';
	});

	btnCancel.addEventListener('click', function () {
		formTrajet.style.display = 'none';
		errorMessage.style.display = 'none';
	});

	form.addEventListener('submit', function (e) {
		// Basic client-side validation example
		errorMessage.style.display = 'none';
		errorMessage.innerHTML = '';

		const nom = form.querySelector('[name="nom_trajet"]').value.trim();
		const depart = form.querySelector('[name="adresse_depart"]').value.trim();
		const arrivee = form.querySelector('[name="point_arrivee"]').value.trim();
		let errors = [];

		if (!nom) errors.push('Le nom du trajet est requis.');
		if (!depart) errors.push('Le point de départ est requis.');
		if (!arrivee) errors.push('Le point d\'arrivée est requis.');

		if (errors.length > 0) {
			e.preventDefault();
			errorMessage.innerHTML = '<strong>Impossible d’enregistrer le trajet :</strong><br>' + errors.join('<br>');
			errorMessage.style.display = 'block';
			errorMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
		}
	});
</script>
</body>

</html>
