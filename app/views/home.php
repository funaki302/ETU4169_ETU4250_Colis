

    <?php include ("inc/header.php"); ?>

    <main class="container">
        <section class="product-list">
            <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
                <h2>Liste des trajets</h2>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Distance</th>
                            <th>Départ</th>
                            <th>Arrivée</th>
                            <th>Chauffeur</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Véhicule</th>
                            <th>Recette</th>
                            <th>Date Recette</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($liste as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['idTrajet'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['dateHeureDebut'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['dateHeureFin'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['distance'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['pointDepart'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['pointArrivee'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['chauffeur_nom_complet'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['chauffeur_telephone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['chauffeur_email'] ?? '') ?></td>
                            <td><?= htmlspecialchars((($row['vehicule_marque'] ?? '') . ' ' . ($row['vehicule_modele'] ?? '')) ) ?></td>
                            <td><?= htmlspecialchars($row['recette_montant'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['recette_date'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php else: ?>
                <p>Aucun trajet trouvé.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include ("inc/footer.php"); ?>
</body>
</html>

