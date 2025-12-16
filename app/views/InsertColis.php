<?php include("inc/header.php"); ?>

<div class="container">
    <h1>Ajouter un nouveau Colis</h1>

    <?php if (!empty($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post" action="/insertColis">
        <div class="insert-colis-page">
            <div class="insert-colis-container">
                <h1>Insertion d’un colis</h1>

                <form method="post" action="/insertColis">

                    <div class="insert-colis-group">
                        <label>Nom du colis</label>
                        <input type="text" name="nom" required>
                    </div>

                    <div class="insert-colis-group">
                        <label>Nom expéditeur</label>
                        <input type="text" name="nom_expediteur" required>
                    </div>

                    <div class="insert-colis-group">
                        <label>Adresse expéditeur</label>
                        <input type="text" name="adresse_expediteur" required>
                    </div>

                    <div class="insert-colis-group">
                        <label>Nom destinataire</label>
                        <input type="text" name="nom_destinataire" required>
                    </div>

                    <div class="insert-colis-group">
                        <label>Adresse destinataire</label>
                        <input type="text" name="adresse_destinataire" required>
                    </div>

                    <div class="insert-colis-group">
                        <label>Date expédition</label>
                        <input type="date" name="date_expedition" required>
                    </div>

                    <div class="insert-colis-group">
                        <label>Kilos</label>
                        <input type="number" step="0.1" name="kilos" required>
                    </div>

                    <button class="insert-colis-btn">Enregistrer</button>

                </form>
            </div>
        </div>

    </form>
</div>
</body>

</html>