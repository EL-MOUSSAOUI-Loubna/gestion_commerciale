<div class="category-details">
    <a href="/stage/categories" class="back-button">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <div class="category-header">
        <h3><?= htmlspecialchars($category['nom']) ?></h3>
    </div>

    <div class="products-section">
        <p class="section-title">Produits</p>

        <table class="product-table" id="categorieProduits">
            <thead>
                <tr>
                    <th width="20%">Référence</th>
                    <th width="55%">Libellé</th>
                    <th width="25%">Prix Unitaire</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?= htmlspecialchars($produit['reference']) ?></td>
                            <td><a href="/stage/produits/show?id=<?= $produit['id'] ?>" target="_blank"
                                    class="product-link"><?= htmlspecialchars($produit['libelle']) ?></a></td>
                            <td><?= number_format($produit['prix_u'], 2, ',', ' ') ?> dh</td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .category-details {
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        max-width: 1200px;
        margin: 20px auto;
        padding: 25px;
        background-color: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .category-header {
        margin-top: 18px;
        padding-bottom: 18px;
        margin-bottom: 25px;
        border-bottom: 1px solid #f0f0f0;
    }

    .category-header h3 {
        color: #3a3a3a;
        font-size: 22px;
        margin: 0;
        font-weight: 500;
        letter-spacing: 0.3px;
        position: relative;
        padding-bottom: 10px;
    }

    .section-title {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 15px;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .product-table th {
        background-color: #f8f9fa;
        color: #495057;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    .product-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eaeaea;
        color: #333;
    }

    .product-table tr:hover {
        background-color: #f8f9fa;
    }

    .product-link {
        color: #3498db;
        text-decoration: none;
        transition: color 0.2s;
    }

    .product-link:hover {
        color: #2980b9;
        text-decoration: underline;
    }

    .no-products {
        text-align: center;
        color: #7f8c8d;
        padding: 20px !important;
        font-style: italic;
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-table {
            display: block;
            overflow-x: auto;
        }

        .category-details {
            padding: 15px;
        }
    }
</style>