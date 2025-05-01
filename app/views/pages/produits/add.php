<?php // At the top of the form page (add.php):
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
;?>
<div>
    <h1>ajouter produit</h1>

    <!-- Display errors if any -->
    <?php if (isset($_GET['error'])): ?>
        <div class="error">Erreur lors de l'ajout du client.</div>
    <?php endif; ?>

    <form method="post" action="/stage/produits/store" enctype="multipart/form-data">

        <!-- CSRF Token (if using sessions) -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <label for="libelle">Libellé :</label>
        <input type="text" id="libelle" name="libelle"><br>

        <label for="reference">Réference :</label>
        <input type="text" id="reference" name="reference"><br>

        <label for="description_p">Description :</label>
        <textarea id="description" name="description_p"></textarea><br>

        <label for="prix_u">Prix unitaire :</label>
        <input type="number" id="prix" name="prix_u"><br>

        <label for="qte">Quantité :</label>
        <input type="number" id="quantite" name="qte"><br>

        <label for="u_mesure">Unité de mesure :</label>
        <select id="u_mesure" name="u_mesure">
            <option value="kg">kg</option>
            <option value="g">g</option>
            <option value="l">l</option>
            <option value="ml">ml</option>
            <option value="m">m</option>
            <option value="cm">cm</option>
            <option value="piece">piéce</option>
        </select><br>

        <label for="categorie">Catégorie :</label>
        <select id="categorie" name="categorie">
            <option value="cat1">Catégorie 1</option>
            <option value="cat2">Catégorie 2</option>
            <option value="cat3">Catégorie 3</option>
        </select><br>

        <label for='ttva'>Taux TVA :</label>
        <input type="number" id="ttva" name="ttva"> %<br>

        <label for="fournisseur">Fournisseur :</label>
        <select id="fournisseur" name="fournisseur">
            <option value="four1">Fournisseur 1</option>
            <option value="four2">Fournisseur 2</option>
            <option value="four3">Fournisseur 3</option>
        </select><br>

        <label for="image">Image :</label>
        <input type="text" id="image" name="image_p"><br>

        <input type="submit" value="Ajouter">
    </form>
</div>