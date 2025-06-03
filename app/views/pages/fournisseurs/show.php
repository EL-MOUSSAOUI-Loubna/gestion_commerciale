<div class="fournisseur-details">
    <?php if (isset($fournisseur) && is_array($fournisseur)): ?>
        <div class="fournisseur-card">
            <h1 class="fournisseur-title"><?= htmlspecialchars($fournisseur['nom_ste'] ?? 'Fournisseur non spécifié') ?></h1>

            <div class="fournisseur-grid">
                <div class="detail-group">
                    <span class="detail-label">ICE</span>
                    <span class="detail-value"><?= htmlspecialchars($fournisseur['ice'] ?? 'N/A') ?></span>
                </div>

                <div class="detail-group">
                    <span class="detail-label">IDF</span>
                    <span class="detail-value"><?= htmlspecialchars($fournisseur['idf'] ?? 'N/A') ?></span>
                </div>

                <div class="detail-group full-width">
                    <span class="detail-label">Adresse</span>
                    <p class="detail-value"><?= htmlspecialchars($fournisseur['adresse'] ?? 'Non renseignée') ?></p>
                </div>

                <div class="detail-group">
                    <span class="detail-label">Téléphone</span>
                    <span class="detail-value contact"><?= htmlspecialchars($fournisseur['telephone'] ?? 'N/A') ?></span>
                </div>

                <div class="detail-group">
                    <span class="detail-label">Email</span>
                    <span class="detail-value contact"><?= htmlspecialchars($fournisseur['email'] ?? 'Non renseigné') ?></span>
                </div>
            </div>

            <a href="/sggi/fournisseurs" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    <?php else: ?>
        <div class="error-message">
            <i class="far fa-info-circle"></i>
            <p>Fournisseur introuvable.</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .fournisseur-details {
        max-width: 800px;
        margin: 2rem auto;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .fournisseur-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .fournisseur-title {
        color: #1f2937;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .fournisseur-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .detail-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .detail-group.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        color: #1f2937;
        font-size: 1rem;
    }

    .detail-value.contact {
        background: #f0fdf4;
        color: #16a34a;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        display: inline-block;
        width: fit-content;
        font-size: 0.875rem;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background-color: white;
        color: #2563eb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s ease;
    }

    .back-button:hover {
        background-color: #dbeafe;
        border-color: #2563eb;
    }

    .back-button i {
        transition: transform 0.15s ease;
    }

    .back-button:hover i {
        transform: translateX(-2px);
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background-color: #fee2e2;
        color: #dc2626;
        border-radius: 0.5rem;
        border: 1px solid #dc2626;
    }

    .error-message i {
        flex-shrink: 0;
    }

    .error-message p {
        margin: 0;
        font-weight: 500;
    }

    @media (max-width: 640px) {
        .fournisseur-grid {
            grid-template-columns: 1fr;
        }
    }
</style>