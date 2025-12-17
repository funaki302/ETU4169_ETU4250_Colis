<?php include ("inc/header.php"); ?>

<main class="container">
    <div class="d-flex align-items-center justify-content-between mt-4 mb-3">
        <h2 class="mb-0">Liste des voitures</h2>
        <button id="btnAdd" class="btn btn-success">+ Ajouter</button>
    </div>

    <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Immatriculation</th>
                    <th>Marque</th>
                    <th>Modèle</th>
                    <th>Capacité</th>
                    <th>Statut</th>
                    <th>ID Carburant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id_voiture'] ?? $row['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['immatriculation'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['marque'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['modele'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['capacite'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['statut_voiture'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['id_carburant'] ?? '') ?></td>
                        <td>
                            <form method="post" action="/voitures/delete/<?= htmlspecialchars($row['id_voiture'] ?? $row['id'] ?? '') ?>" style="display:inline-block;">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette voiture ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>Aucune voiture trouvée.</p>
    <?php endif; ?>

    <div id="formContainer" class="card mt-4" style="display:none;">
        <div class="card-body">
            <h5 class="card-title">Ajouter une nouvelle voiture</h5>
            <form method="post" action="/voitures/add">
                <div class="mb-3">
                    <label class="form-label">Immatriculation</label>
                    <input name="immatriculation" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Marque</label>
                    <input name="marque" class="form-control" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Modèle</label>
                    <input name="modele" class="form-control" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Capacité</label>
                    <input name="capacite" type="number" class="form-control" value="1" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select name="statut_voiture" class="form-control">
                        <option value="disponible">disponible</option>
                        <option value="en cours de livraison">en cours de livraison</option>
                        <option value="maintenance">maintenance</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Carburant</label>
                    <input name="id_carburant" type="number" class="form-control" value="1" />
                </div>
                <button class="btn btn-primary">Enregistrer</button>
                <button type="button" id="btnCancel" class="btn btn-secondary">Annuler</button>
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
