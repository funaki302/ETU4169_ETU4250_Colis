
    <?php include ("inc/header.php"); ?>

    <main class="container">
        <section class="product-list">
            <?php if (isset($liste) && is_array($liste) && count($liste) > 0): ?>
                <h2>Liste des colis</h2>
                <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom Expéditeur</th>
                            <th>Adresse Expéditeur</th>
                            <th>Nom Destinataire</th>
                            <th>Adresse Destinataire</th>
                            <th>Date Expédition</th>
                            <th>Date Livraison</th>
                            <th>Kilos</th>
                            <th>Statut (id)</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($liste as $row): ?>
                        <?php $statut = "";
                        switch ($row['id_statut']) {
                            case 1:
                                $statut = "En attente";
                                break;
                            case 2:
                                $statut = "Livré";
                                break;
                            case 3:
                                $statut = "Annulé";
                                break;
                            default:
                                $statut = "Inconnu";
                                break;
                        }
                        ?>
                        <tr>
                            <a href="/colis/<?= $row['id_colis'] ?>" style="color: black; text-decoration: none;">
                                <td><?= htmlspecialchars($row['id_colis'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['nom_expediteur'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['adresse_expediteur'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['nom_destinataire'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['adresse_destinataire'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['date_expedition'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['date_livraison'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['kilos'] ?? '') ?></td>
                                <td><?= htmlspecialchars($statut) ?></td>
                            </a>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php else: ?>
                <p>Aucun colis trouvé.</p>
            <?php endif; ?>
        </section>
    </main>

    <?php include ("inc/footer.php"); ?>
</body>
</html>

