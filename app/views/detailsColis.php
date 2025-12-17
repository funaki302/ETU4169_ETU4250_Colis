<?php include ("inc/header.php"); ?>

<main class="container">
    <section class="product-details">
        <?php if (isset($colis) && is_array($colis) && count($colis) > 0): ?>
            <?php $id = $colis['id_colis'] ?? '' ; ?>
            <h2>Détails du colis #<?= htmlspecialchars($id) ?></h2>
            <div class="card">
                <div class="card-body">
                    <form action="/colis/update/" method="post" enctype="multipart/form-data">
                        <table class="table table-borderless">

                            <tr>
                                <th>ID</th>
                                <td>
                                    <?= htmlspecialchars($id) ?>
                                    <input type="hidden" name="id_colis" value="<?= htmlspecialchars($id) ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Nom colis</th>
                                <td>
                                    <input type="text" name="nom_colis"
                                        value="<?= htmlspecialchars($colis['nom_colis'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Nom expéditeur</th>
                                <td>
                                    <input type="text" name="nom_expediteur"
                                        value="<?= htmlspecialchars($colis['nom_expediteur'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Adresse expéditeur</th>
                                <td>
                                    <input type="text" name="adresse_expediteur"
                                        value="<?= htmlspecialchars($colis['adresse_expediteur'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Nom destinataire</th>
                                <td>
                                    <input type="text" name="nom_destinataire"
                                        value="<?= htmlspecialchars($colis['nom_destinataire'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Adresse destinataire</th>
                                <td>
                                    <input type="text" name="adresse_destinataire"
                                        value="<?= htmlspecialchars($colis['adresse_destinataire'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Date expédition</th>
                                <td>
                                    <input type="date" name="date_expedition"
                                        value="<?= htmlspecialchars($colis['date_expedition'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Date livraison</th>
                                <td>
                                    <input type="date" name="date_livraison"
                                        value="<?= htmlspecialchars($colis['date_livraison'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Kilos</th>
                                <td>
                                    <input type="number" step="any" name="kilos"
                                        value="<?= htmlspecialchars($colis['kilos'] ?? '') ?>">
                                </td>
                            </tr>

                            <tr>
                                <th>Statut</th>
                                <td>
                                    <select name="id_statut">
                                    <?php foreach ($statuts as $statut): ?>
                                        <option value="<?= $statut['id_statut'] ?>"
                                        <?= ($statut['id_statut'] == $colis['id_statut']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($statut['description_statut']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>

                             <tr>
                                <th>Ajouter un image</th>
                                <td>
                                    <input type="file" name="imageColis" accept="image/*">
                                </td>
                            </tr>

                        </table>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-danger">Update</button>
                            <a href="/" class="btn btn-secondary">Retour</a>
                        </div>

                    </form>
                </div>
            </div>
        <?php else: ?>
            <p>Colis introuvable.</p>
            <a href="/" class="btn btn-secondary">Retour à la liste</a>
        <?php endif; ?>
    </section>
</main>

<?php include ("inc/footer.php"); ?>
</body>
</html>
