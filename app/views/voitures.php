<?php include ("inc/header.php"); ?>
<style>
    .update{
        background-color: blue;
        color: blanchedalmond;
    }
</style>
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
                    <th>Capacité (Puissance)</th>
                    <th>Statut</th>
                    <th>Carburant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $row): ?>
                    <tr>
                        <form action="/voitures/update/" method="post">
                            <td>
                                <?= htmlspecialchars($row['id_voiture'] ?? '') ?>
                                <input type="hidden" name="id_voiture" 
                                value="<?= htmlspecialchars($row['id_voiture'] ?? '') ?>">
                            </td>
                            <td>
                                <input type="text" name="immatriculation" 
                                value="<?= htmlspecialchars($row['immatriculation'] ?? '') ?>"
                                required>
                            </td>
                            <td>
                                <input type="text" name="marque" 
                                value="<?= htmlspecialchars($row['marque'] ?? '') ?>"
                                required>
                            </td>
                            <td>
                                <input type="text" name="modele" value="<?= htmlspecialchars($row['modele'] ?? '') ?>" 
                                required>
                            </td>
                            <td>
                                <input type="number" step="any" name="capacite" 
                                value="<?= htmlspecialchars($row['capacite'] ?? '') ?>" 
                                required>
                            </td>
                            <td>
                                <select name="id_statut" class="form-control" required>
                                        <option value="<?= $row['id_statut'] ?>"><?= $statut_voiture[$row['id_statut']-1]['statut'] ?></option>
                                        <?php foreach ($statut_voiture as $stat) { ?>
                                            <?php if ($stat['id_statut'] !== ($row['id_statut'])) { ?>
                                                <option value="<?= $stat['id_statut'] ?>"><?= $stat['statut'] ?></option>
                                            <?php }?>
                                        <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select name="id_carburant" class="form-control" required>
                                    <option value="<?= $row['id_carburant'] ?>"><?= $carburants[$row['id_carburant']-1]['type_carburant'] ?></option>
                                        <?php foreach ($carburants as $carburant) { 
                                            if ($carburant['id_carburant'] !== ($row['id_carburant'])) { ?>
                                                <option value="<?= $carburant['id_carburant'] ?>"><?= $carburant['type_carburant'] ?></option>
                                            <?php }?>
                                        <?php } ?>    
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-sm update" value="Update">
                            </td>
                        </form>
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
                    <label class="form-label">Capacité (Puissance)</label>
                    <input name="capacite" type="number" class="form-control" value="1" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Statut</label>
                    <select name="statut_voiture" class="form-control">
                        <?php if (isset($statut_voiture)) {   
                            foreach ($statut_voiture as $stat) { ?>
                                <option value="<?= $stat['id_statut'] ?>"><?= $stat['statut'] ?></option>
                            <?php } ?>
                        <?php }else { ?>
                            <option value="1">disponnible par defaut 1</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">ID Carburant</label>
                    <select name="id_carburant" class="form-control">
                        <?php if (isset($carburants)) { 
                            foreach ($carburants as $carburant) { ?>
                                <option value="<?= $carburant['id_carburant'] ?>"><?= $carburant['type_carburant'] ?></option>
                            <?php } ?>    
                        <?php } else { ?>
                            <option value="1">Carburant par defaut 1</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="imageColis" class="form-label fw-semibold text-dark">Ajouter une
                        photo</label>
                    <input type="file" name="imageColis" id="imageColis" class="form-control"
                        accept="image/*">
                    <div class="form-text">Sélectionnez une image (JPG, PNG, WebP). Vous pouvez en ajouter
                        plusieurs fois.</div>
                    </div>
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
