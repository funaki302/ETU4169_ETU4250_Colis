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
                    <th>ID Carburant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $row): ?>
                    <tr>
                        <form action="/voitures/update/" method="post">
                            <td>
                                <?= htmlspecialchars($row['id_voiture'] ?? $row['id'] ?? '') ?>
                                <input type="hidden" name="id_voiture" 
                                value="<?= htmlspecialchars($row['id_voiture'] ?? $row['id'] ?? '') ?>">
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
                                <select name="statut_voiture" class="form-control" required>
                                    <option value="<?= htmlspecialchars($row['statut_voiture'] ?? '') ?>"><?= htmlspecialchars($row['statut_voiture'] ?? '') ?></option>
                                    <?php if (isset($statut_voiture)) { 
                                        foreach ($statut_voiture as $stat) { 
                                            if ($stat != ($row['statut_voiture'])) { ?>
                                                <option value="<?= $stat ?>"><?= $stat ?></option>
                                            <?php }?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <select name="id_carburant" class="form-control" required>
                                    <?php if (isset($carburants)) { 
                                        foreach ($carburants as $carburant) { 
                                            if ($carburant['id_carburant'] == ($row['id_carburant'])) { ?>
                                                <option value="<?= $carburant['id_carburant'] ?>"><?= $carburant['type_carburant'] ?></option>
                                            <?php }
                                            if ($carburant['id_carburant'] != ($row['id_carburant'])) { ?>
                                                <option value="<?= $carburant['id_carburant'] ?>"><?= $carburant['type_carburant'] ?></option>
                                            <?php }?>
                                        <?php } ?>    
                                    <?php } else { ?>
                                        <option value="1">Carburant par defaut 1</option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-sm update" value="Update">
                            </td>
                            <td>
                                <form method="post" action="/voitures/delete/<?= htmlspecialchars($row['id_voiture'] ?? $row['id'] ?? '') ?>" style="display:inline-block;">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette voiture ?')">Supprimer</button>
                                </form>
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
                                <option value="<?= $stat ?>"><?= $stat ?></option>
                            <?php } ?>
                        <?php }else { ?>
                            <option value="disponnible">disponnible par defaut 1</option>
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
