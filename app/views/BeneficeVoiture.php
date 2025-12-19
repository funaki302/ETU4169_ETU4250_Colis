<?php include ("inc/header.php"); ?>
<link href="/assets/css/styleB.css" rel="stylesheet">

<div class="container">
    <h1>🚛 Rapport des Bénéfices par Véhicule</h1>

    <section class="bloc">
        <h2>📊 Performance et Rentabilité par Voiture</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Immatriculation</th>
                    <th>Marque & Modèle</th>
                    <th>Capacité (t)</th>
                    <th>Livraisons effectuées</th>
                    <th>Chiffre d'affaires</th>
                    <th>Coût salaire chauffeur</th>
                    <th>Coût carburant</th>
                    <th>Bénéfice net</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($beneficeVoitures)): ?>
                    <tr>
                        <td colspan="9" style="text-align:center; padding:30px; color:#999; font-style:italic;">
                            Aucune livraison terminée enregistrée pour le moment.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($beneficeVoitures as $row): ?>
                        <?php 
                        $classe = ($row['benefice_net'] > 0) ? 'gain' :
                                  (($row['benefice_net'] < 0) ? 'perte' : 'neutre');
                        ?>
                        <tr class="<?= $classe ?>">
                            <td><strong><?= htmlspecialchars($row['immatriculation']) ?></strong></td>
                            <td><?= htmlspecialchars($row['marque'] . ' ' . $row['modele']) ?></td>
                            <td><?= htmlspecialchars($row['capacite']) ?> t</td>
                            <td><?= number_format($row['nombre_livraisons'], 0, '', ' ') ?></td>
                            <td><?= number_format($row['chiffre_affaires'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format($row['cout_salaire_chauffeur'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format($row['cout_carburant'], 2, ',', ' ') ?> Ar</td>
                            <td>
                                <strong><?= number_format($row['benefice_net'], 2, ',', ' ') ?> Ar</strong>
                            </td>
                            <td>
                                <span class="etat">
                                    <?= $row['benefice_net'] > 0 ? 'Rentable' :
                                       ($row['benefice_net'] < 0 ? 'Déficitaire' : 'Équilibré') ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <?php if (!empty($beneficeVoitures)): ?>
        <?php
        // Calcul des totaux globaux (directement en PHP à partir des données déjà chargées)
        $totalCA = array_sum(array_column($beneficeVoitures, 'chiffre_affaires'));
        $totalSalaire = array_sum(array_column($beneficeVoitures, 'cout_salaire_chauffeur'));
        $totalCarburant = array_sum(array_column($beneficeVoitures, 'cout_carburant'));
        $totalBenefice = $totalCA - $totalSalaire - $totalCarburant;

        $classeTotal = ($totalBenefice > 0) ? 'gain' : (($totalBenefice < 0) ? 'perte' : 'neutre');
        ?>

        <section class="bloc" style="margin-top: 40px; background:#f9f9f9; border: 2px solid #ddd;">
            <h3>📈 Synthèse Globale (Toutes Voitures)</h3>
            <table style="font-size:1.1em; width:100%;">
                <thead>
                    <tr>
                        <th>Chiffre d'affaires total</th>
                        <th>Coûts salaires</th>
                        <th>Coûts carburant</th>
                        <th><strong>Bénéfice net global</strong></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="<?= $classeTotal ?>">
                        <td><?= number_format($totalCA, 2, ',', ' ') ?> Ar</td>
                        <td><?= number_format($totalSalaire, 2, ',', ' ') ?> Ar</td>
                        <td><?= number_format($totalCarburant, 2, ',', ' ') ?> Ar</td>
                        <td><strong><?= number_format($totalBenefice, 2, ',', ' ') ?> Ar</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
</div>

<?php include ("inc/footer.php"); // si vous avez un footer ?>
</body>
</html>