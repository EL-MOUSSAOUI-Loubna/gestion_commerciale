<?php 
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0"><i class="fas fa-user-edit me-2"></i>Modifier fournisseur : <?= htmlspecialchars($fournisseur['nom_ste']) ?></h1>
        </div>
        
        <div class="card-body">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Erreur!</strong> Lors de la modification du fournisseur.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="/sggi/fournisseurs/update" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($fournisseur['id']) ?>">

                <div class="row g-3">
                    <!-- Raison Sociale (Required) -->
                    <div class="col-md-6">
                        <label for="nom_ste" class="form-label">Raison Sociale <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="nom_ste" name="nom_ste" 
                               value="<?= htmlspecialchars($fournisseur['nom_ste'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Veuillez saisir la raison sociale.
                        </div>
                    </div>

                    <!-- ICE (Required) -->
                    <div class="col-md-6">
                        <label for="ice" class="form-label">ICE <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="ice" name="ice" 
                               value="<?= htmlspecialchars($fournisseur['ice'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Veuillez saisir l'ICE.
                        </div>
                    </div>

                    <!-- IDF -->
                    <div class="col-md-6">
                        <label for="idf" class="form-label">IDF</label>
                        <input type="text" class="form-control" id="idf" name="idf" 
                               value="<?= htmlspecialchars($fournisseur['idf'] ?? '') ?>">
                    </div>

                    <!-- Téléphone (Required) -->
                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="telephone" name="telephone" 
                               value="<?= htmlspecialchars($fournisseur['telephone'] ?? '') ?>" required>
                        <div class="invalid-feedback">
                            Veuillez saisir un numéro de téléphone.
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="col-12">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" 
                               value="<?= htmlspecialchars($fournisseur['adresse'] ?? '') ?>">
                    </div>

                    <!-- Email -->
                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?= htmlspecialchars($fournisseur['email'] ?? '') ?>">
                        <div class="invalid-feedback">
                            Veuillez saisir un email valide.
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                    <a href="/sggi/fournisseurs" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Form validation script -->
<script>
// Validation des champs obligatoires
(function () {
    'use strict'
    
    // Regex pour validation téléphone (adaptez selon votre format)
    const phoneRegex = /^[0-9]{10,15}$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    
    // Fonction de validation personnalisée
    function validateField(input, regex) {
        if (!input.value || (regex && !regex.test(input.value))) {
            input.classList.add('is-invalid');
            return false;
        }
        input.classList.remove('is-invalid');
        return true;
    }
    
    // Appliquer à tous les formulaires
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            
            let isValid = true;
            
            // Validation des champs requis
            const requiredFields = [
                {id: 'nom_ste', regex: null},
                {id: 'ice', regex: null},
                {id: 'telephone', regex: phoneRegex}
            ];
            
            requiredFields.forEach(field => {
                const input = document.getElementById(field.id);
                if (!validateField(input, field.regex)) {
                    isValid = false;
                }
            });
            
            // Validation optionnelle pour email
            const emailInput = document.getElementById('email');
            if (emailInput.value && !emailRegex.test(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                isValid = false;
            }
            
            if (isValid) {
                form.submit();
            } else {
                form.classList.add('was-validated');
            }
        }, false);
        
        // Validation en temps réel
        document.getElementById('telephone').addEventListener('input', function() {
            validateField(this, phoneRegex);
        });
        
        document.getElementById('email').addEventListener('input', function() {
            if (this.value) {
                validateField(this, emailRegex);
            }
        });
    });
})();
</script>
