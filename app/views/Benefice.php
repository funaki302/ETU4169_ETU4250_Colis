
<?php include ("inc/header.php"); ?>
<link href="/assets/css/styleB.css" rel="stylesheet">

<div class="container">
    <h1>📊 Rapport des Bénéfices</h1>

    <!-- ================== PAR JOUR ================== -->
    <section class="bloc">
        <h2>📅 Bénéfice par Jour</h2>
        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Recette</th>
                    <th>Salaire Chauffeur</th>
                    <th>Coût Carburant</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($beneficeJour as $row): ?>
                <?php
                    $classe = ($row['benefice'] > 0) ? 'gain' :
                              (($row['benefice'] < 0) ? 'perte' : 'neutre');
                ?>
                <tr class="<?= $classe ?>">
                    <td><?= htmlspecialchars($row['jour']) ?></td>
                    <td><?= number_format($row['recette'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format($row['salaire_chauffeur'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format($row['cout_carburant'], 2, ',', ' ') ?> Ar</td>
                    <td>
                        <?= number_format($row['benefice'], 2, ',', ' ') ?> Ar
                        <span class="etat">
                            <?= ($row['benefice'] > 0) ? 'Gain' :
                               (($row['benefice'] < 0) ? 'Perte' : 'Aucun bénéfice') ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- ================== PAR MOIS ================== -->
    <section class="bloc">
        <h2>📆 Bénéfice par Mois</h2>
        <table>
            <thead>
                <tr>
                    <th>Année</th>
                    <th>Mois</th>
                    <th>Recette</th>
                    <th>Salaire Chauffeur</th>
                    <th>Coût Carburant</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($beneficeMois as $row): ?>
                <?php
                    $classe = ($row['benefice'] > 0) ? 'gain' :
                              (($row['benefice'] < 0) ? 'perte' : 'neutre');
                ?>
                <tr class="<?= $classe ?>">
                    <td><?= $row['annee'] ?></td>
                    <td><?= $row['mois'] ?></td>
                    <td><?= number_format($row['recette'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format($row['salaire_chauffeur'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format($row['cout_carburant'], 2, ',', ' ') ?> Ar</td>
                    <td>
                        <?= number_format($row['benefice'], 2, ',', ' ') ?> Ar
                        <span class="etat">
                            <?= ($row['benefice'] > 0) ? 'Gain' :
                               (($row['benefice'] < 0) ? 'Perte' : 'Aucun bénéfice') ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- ================== PAR ANNEE ================== -->
    <section class="bloc">
        <h2>📊 Bénéfice par Année</h2>
        <table>
            <thead>
                <tr>
                    <th>Année</th>
                    <th>Recette</th>
                    <th>Salaire Chauffeur</th>
                    <th>Coût Carburant</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($beneficeAnne as $row): ?>
                <?php
                    $classe = ($row['benefice'] > 0) ? 'gain' :
                              (($row['benefice'] < 0) ? 'perte' : 'neutre');
                ?>
                <tr class="<?= $classe ?>">
                    <td><?= $row['annee'] ?></td>
                    <td><?= number_format($row['recette'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format($row['salaire_chauffeur'], 2, ',', ' ') ?> Ar</td>
                    <td><?= number_format($row['cout_carburant'], 2, ',', ' ') ?> Ar</td>
                    <td>
                        <?= number_format($row['benefice'], 2, ',', ' ') ?> Ar
                        <span class="etat">
                            <?= ($row['benefice'] > 0) ? 'Gain' :
                               (($row['benefice'] < 0) ? 'Perte' : 'Aucun bénéfice') ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

</div>

</body>
</html>
