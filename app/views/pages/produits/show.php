<div class="product-details">
    <?php if (isset($produit) && is_array($produit)): ?>
        <div class="product-card">
            <h1 class="product-title"><?= htmlspecialchars($produit['libelle'] ?? 'Produit non spécifié') ?></h1>

            <div class="product-grid">
                <div class="detail-group">
                    <span class="detail-label">Référence</span>
                    <span class="detail-value"><?= htmlspecialchars($produit['reference'] ?? 'N/A') ?></span>
                </div>

                <div class="detail-group">
                    <span class="detail-label">Prix unitaire</span>
                    <span class="detail-value price"><?= isset($produit['prix_u']) ? number_format($produit['prix_u'], 2, ',', ' ') . ' dh' : 'N/A' ?></span>
                </div>

                <div class="detail-group full-width">
                    <span class="detail-label">Description</span>
                    <p class="detail-value"><?= htmlspecialchars($produit['description_p'] ?? 'Aucune description fournie') ?></p>
                </div>

                <div class="detail-group">
                    <span class="detail-label">Catégorie</span>
                    <span class="detail-value category"><?= htmlspecialchars($category['nom'] ?? 'Non classé') ?></span>
                </div>

                <div class="detail-group">
                    <span class="detail-label">Fournisseur</span>
                    <span class="detail-value supplier"><?= htmlspecialchars($produit['fournisseur'] ?? 'Non renseigné') ?></span>
                </div>
            </div>

            <a href="/stage/produits" class="back-button">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    <?php else: ?>
        <div class="error-message">
            <i class="far fa-info-circle"></i>
            <p>Produit introuvable.</p>
        </div>
    <?php endif; ?>
</div>

<style>

    .product-details {
        max-width: 800px;
        margin: 2rem auto;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .product-card {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .product-title {
        color: #1f2937;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .product-grid {
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

    .detail-value.price {
        font-weight: 600;
        color: #2563eb;
    }

    .detail-value.category,
    .detail-value.supplier {
        background: #dbeafe;
        color: #2563eb;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
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
        color:  #dc2626;
        border-radius: 0.5rem;
        border: 1px solid  #dc2626;
    }

    .error-message i {
        flex-shrink: 0;
    }

    .error-message p {
        margin: 0;
        font-weight: 500;
    }

    @media (max-width: 640px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>