<?php include ("inc/header.php"); ?>

<main class="container">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
        <h2 class="mb-0">Liste des chauffeurs</h2>
        <button id="btnAddChauffeur" class="btn btn-success">+ Ajouter</button>
    </div>

    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Date d'assignation</th>
                    <th>Salaire par livraison</th>
                    <th>ID Voiture</th>
                    <th>ID Livraison</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_chauffeur'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['nom_chauffeur'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['prenom_chauffeur'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['telephone_chauffeur'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['email_chauffeur'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['date_dassignation'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['salaires_parLiv'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['id_voiture'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['id_livraison'] ?? '') ?></td>
                        <td>
                            <form method="post" action="/chauffeurs/delete/<?= htmlspecialchars($row['id_chauffeur'] ?? '') ?>" style="display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce chauffeur ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>Aucun chauffeur trouvé.</p>
    <?php endif; ?>

    <div id="formChauffeur" class="card mt-4" style="display:none;">
        <div class="card-body">
            <h5 class="card-title">Ajouter un nouveau chauffeur</h5>
            <form method="post" action="/chauffeurs/add">
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
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Voiture</label>
                        <input name="id_voiture" type="number" class="form-control" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Livraison</label>
                        <input name="id_livraison" type="number" class="form-control" />
                    </div>
                </div>
                <button class="btn btn-primary">Enregistrer</button>
                <button type="button" id="btnCancelChauffeur" class="btn btn-secondary">Annuler</button>
            </form>
        </div>
    </div>

</main>

<?php include ("inc/footer.php"); ?>

<script nonce="<?= htmlspecialchars($csp_nonce ?? '') ?>">
document.getElementById('btnAddChauffeur').addEventListener('click', function(){
    document.getElementById('formChauffeur').style.display = 'block';
    window.location.hash = '#formChauffeur';
});
document.getElementById('btnCancelChauffeur').addEventListener('click', function(){
    document.getElementById('formChauffeur').style.display = 'none';
});
</script>
</body>
</html>
