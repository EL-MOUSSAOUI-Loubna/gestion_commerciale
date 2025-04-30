<?php // At the top of the form page (add.php):
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
;?>
<div>
    <h1>edit client <?= $client['nom_ste'] ?></h1>
    
    <!-- Display errors if any -->
    <?php if (isset($_GET['error'])): ?>
        <div class="error">Erreur lors de l'ajout du client.</div>
    <?php endif; ?>

    <!-- 
        Key fixes:
        1. Correct `action` to match your routing.
        2. Add `enctype` for file uploads.
        3. Add CSRF token (if using sessions).
    -->
    <form method="post" action="/stage/clients/update" enctype="multipart/form-data">
        <!-- CSRF Token (if using sessions) -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

        <!-- Required fields with client-side validation -->
        Nom Société : <input type="text" name="nom_ste" value="<?= $client['nom_ste'] ?>"><br>
        ICE : <input type="text" name="ice" value="<?= $client['ice'] ?>"><br>
        IDF : <input type="text" name="idf" value="<?= $client['idf'] ?>"><br>
        Adresse : <input type="text" name="adresse" value="<?= $client['adresse'] ?>"><br>
        Téléphone : <input type="text" name="telephone" value="<?= $client['telephone'] ?>"><br>
        Email : <input type="email" name="email" value="<?= $client['email'] ?>"><br>
        logo : <input type="text" name="logo" value="<?= $client['logo'] ?>"><br>
        
        <!-- File upload (note: PHP will use $_FILES['logo']) 
        Logo : <input type="file" name="logo" accept="image/*"><br>-->

        <input type="submit" value="modifier">
    </form>
</div>