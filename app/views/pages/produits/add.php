
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0"><i class="fas fa-cube me-2"></i>Ajouter un produit</h1>
        </div>
        
        <div class="card-body">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Erreur!</strong> Lors de l'ajout du produit.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="/stage/produits/store" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

                <div class="row g-3">
                    <!-- Libellé -->
                    <div class="col-md-6">
                        <label for="libelle" class="form-label">Libellé <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="libelle" name="libelle" required>
                        <div class="invalid-feedback">
                            Veuillez saisir le libellé du produit.
                        </div>
                    </div>

                    <!-- Référence -->
                    <div class="col-md-6">
                        <label for="reference" class="form-label">Référence</label>
                        <input type="text" class="form-control" id="reference" name="reference">
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description_p" rows="3"></textarea>
                    </div>

                    <!-- Prix unitaire -->
                    <div class="col-md-4">
                        <label for="prix" class="form-label">Prix unitaire (DH) <span class='text-danger'>*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="prix" name="prix_u" required>
                        <div class="invalid-feedback">
                            Veuillez saisir un prix valide.
                        </div>
                    </div>

                    <!-- Taux TVA -->
                    <div class="col-md-4">
                        <label for="ttva" class="form-label">Taux TVA (%) <span class='text-danger'>*</span></label>
                        <div class="input-group">
                            <input type="number" step="0.1" min="0" max="100" class="form-control" id="ttva" name="ttva" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="invalid-feedback">
                            Veuillez saisir un taux TVA valide (0-100%).
                        </div>
                    </div>

                    <!-- Catégorie -->
                    <div class="col-md-4">
                        <label for="categorie" class="form-label">Catégorie</label>
                        <select class="form-select" id="categorie" name="categorie">
                            <option value="cat1">Catégorie 1</option>
                            <option value="cat2">Catégorie 2</option>
                            <option value="cat3">Catégorie 3</option>
                        </select>
                    </div>

                    <!-- Fournisseur -->
                    <div class="col-md-6">
                        <label for="fournisseur" class="form-label">Fournisseur</label>
                        <select class="form-select" id="fournisseur" name="fournisseur">
                            <option value="four1">Fournisseur 1</option>
                            <option value="four2">Fournisseur 2</option>
                            <option value="four3">Fournisseur 3</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Ajouter
                    </button>
                    <a href="/stage/produits" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict'
    
    const numberRegex = /^\d+(\.\d{1,2})?$/;
    
    function validateField(input, regex) {
        if (!input.value || (regex && !regex.test(input.value))) {
            input.classList.add('is-invalid');
            return false;
        }
        input.classList.remove('is-invalid');
        return true;
    }
    
    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            
            let isValid = true;
            
            const requiredFields = [
                {id: 'libelle', regex: null},
                {id: 'prix', regex: numberRegex},
                {id: 'ttva', regex: /^(100|\d{1,2}(\.\d{1,2})?)$/} // 0-100% avec 2 décimales
            ];
            
            requiredFields.forEach(field => {
                const input = document.getElementById(field.id);
                if (!validateField(input, field.regex)) {
                    isValid = false;
                }
            });
            
            if (isValid) {
                form.submit();
            } else {
                form.classList.add('was-validated');
            }
        }, false);
        
        document.getElementById('prix').addEventListener('input', function() {
            validateField(this, numberRegex);
        });
        
        document.getElementById('ttva').addEventListener('input', function() {
            validateField(this, /^(100|\d{1,2}(\.\d{1,2})?)$/);
        });
    });
})();
</script>
