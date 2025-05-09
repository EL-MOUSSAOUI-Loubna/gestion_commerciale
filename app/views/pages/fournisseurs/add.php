
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">Ajouter un fournisseur</h1>
        </div>
        
        <div class="card-body">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Erreur!</strong> Lors de l'ajout du fournisseur.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form method="post" action="/stage/fournisseurs/store" enctype="multipart/form-data" class="needs-validation" novalidate>
                <!-- CSRF Token -->
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nom_ste" class="form-label">Raison Sociale <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="nom_ste" name="nom_ste" required>
                        <div class="invalid-feedback">
                            Veuillez entrer le nom de la société.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="ice" class="form-label">ICE <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="ice" name="ice" required>
                        <div class="invalid-feedback">
                            Veuillez entrer l'ICE.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="idf" class="form-label">IDF</label>
                        <input type="text" class="form-control" id="idf" name="idf">
                    </div>

                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone <span class='text-danger'>*</span></label>
                        <input type="text" class="form-control" id="telephone" name="telephone" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un numéro de téléphone valide.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse">
                    </div>

                    <div class="col-md-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                        <div class="invalid-feedback">
                            Veuillez entrer un email valide (exemple@domaine.com).
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Ajouter
                    </button>
                    <a href="/stage/fournisseurs" class="btn btn-outline-secondary px-4">
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
    
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^[0-9]{10,15}$/;
    
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
            
            Array.from(form.elements).forEach(element => {
                if (element.required && !element.value.trim()) {
                    element.classList.add('is-invalid');
                    isValid = false;
                }
            });
            
            const emailInput = form.querySelector('#email');
            if (emailInput.value && !emailRegex.test(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                isValid = false;
            }
            
            const phoneInput = form.querySelector('#telephone');
            if (phoneInput.value && !phoneRegex.test(phoneInput.value.replace(/\s/g, ''))) {
                phoneInput.classList.add('is-invalid');
                isValid = false;
            }
            
            if (isValid) {
                form.submit();
            } else {
                form.classList.add('was-validated');
            }
        }, false);
        
        form.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                if (this.id === 'email' && this.value) {
                    validateField(this, emailRegex);
                } else if (this.id === 'telephone' && this.value) {
                    validateField(this, phoneRegex);
                } else if (this.required) {
                    validateField(this);
                }
            });
        });
    });
})();
</script>
