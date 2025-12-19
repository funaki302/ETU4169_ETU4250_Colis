<?php include ("inc/header.php"); ?>

<main class="container my-5">

    <a href="/voitures" class="btn btn-outline-secondary mb-4">
        ← Retour à la liste
    </a>

    <div class="card shadow-lg">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                🚗 Détails des bénéfices — 
                <?= htmlspecialchars($benefice['marque']) ?>
                <?= htmlspecialchars($benefice['modele']) ?>
            </h4>
        </div>

        <div class="card-body">

            <!-- INFOS VOITURE -->
            <h5 class="mb-3">Informations du véhicule</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Immatriculation :</strong>
                            <?= htmlspecialchars($benefice['immatriculation']) ?>
                        </li>
                        <li class="list-group-item">
                            <strong>Capacité :</strong>
                            <?= htmlspecialchars($benefice['capacite']) ?>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Nombre de livraisons :</strong>
                            <?= (int)$benefice['nombre_livraisons'] ?>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- FINANCES -->
            <h5 class="mb-3">Résultat financier</h5>

            <table class="table table-bordered align-middle">
                <tr>
                    <th>📦 Chiffre d’affaires</th>
                    <td class="text-end">
                        <?= number_format($benefice['chiffre_affaires'], 0, ',', ' ') ?> Ar
                    </td>
                </tr>
                <tr>
                    <th>👨‍✈️ Coût salaires chauffeurs</th>
                    <td class="text-end text-danger">
                        − <?= number_format($benefice['cout_salaire_chauffeur'], 0, ',', ' ') ?> Ar
                    </td>
                </tr>
                <tr>
                    <th>⛽ Coût carburant</th>
                    <td class="text-end text-danger">
                        − <?= number_format($benefice['cout_carburant'], 0, ',', ' ') ?> Ar
                    </td>
                </tr>
                <tr class="table-success fw-bold">
                    <th>💰 Bénéfice net</th>
                    <td class="text-end fs-5">
                        <?= number_format($benefice['benefice_net'], 0, ',', ' ') ?> Ar
                    </td>
                </tr>
            </table>

        </div>
    </div>

</main>

<?php include ("inc/footer.php"); ?>
