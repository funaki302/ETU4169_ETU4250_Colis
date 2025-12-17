<?php include("inc/header.php"); ?>

<div class="container">
    <h1>Ajouter un nouveau Colis</h1>

    <?php if (!empty($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <!-- UN SEUL FORMULAIRE ICI -->
    <form method="post" action="/insertColis" enctype="multipart/form-data">
        <div class="insert-colis-page">
            <div class="insert-colis-container">
                <h1>Insertion d’un colis</h1>

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

                <div class="insert-colis-group">
                    <label>Image du colis (optionnelle)</label>
                    <input type="file" name="imageColis" accept="image/*">
                </div>

                <button type="submit" class="insert-colis-btn">Enregistrer</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>