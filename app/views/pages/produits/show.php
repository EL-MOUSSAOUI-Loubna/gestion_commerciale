<div>
    <h1>produit : <?= $produit['libelle'] ?></h1>
    <p>reference: <?= $produit['reference'] ?></p>
    <p>description: <?= $produit['description_p'] ?></p>
    <p>pu: <?= $produit['prix_u'] ?> par <?= $produit['u_mesure'] ?></p>
    <p>qte: <?= $produit['qte'] ?></p>
    <p>categorie: <?= $produit['categorie'] ?></p>
    <p>fournisseur: <?= $produit['fournisseur'] ?></p>
    <p>image: <?= $produit['image_p'] ?></p>
    <a href="/stage/produits">Retour à la liste des produits</a>
    <br><hr><br>

    <div class="accordion" id="listecategories">
    <div>
        <mg src="https://demo.joinposter.com/upload/pos_cdb_4/menu/category_1609750292_32.JPG" alt="Image 1">
        <p>categorie 1</p>
    </div>

    <div class="accordion-item border-0">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#categoriess">
                <div>
                    <mg src="https://demo.joinposter.com/upload/pos_cdb_4/menu/category_1609750292_32.JPG" alt="Image 1">
                    <p>categorie 1</p>
                </div>
            </button>
        </h2>
        <div id="categoriess" class="accordion-collapse collapse" data-bs-parent="#listecategories">
            <button class="accordion-body p-0">
                <div>
                    <mg src="https://demo.joinposter.com/upload/pos_cdb_4/menu/category_1609750292_32.JPG" alt="Image 1">
                    <p>categorie 1</p>
                </div>
            </button>
        </div>
    </div>
</div>
</div>