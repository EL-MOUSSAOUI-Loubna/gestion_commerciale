<!-- This would be in your index.php view for clients -->
<div class="container">
    <h1>Liste des Produits</h1>

    <div class="mb-3">
        <a href="/sggi/produits/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un produit
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 'created':
                    echo 'Produit ajouté avec succès.';
                    break;
                case 'updated':
                    echo 'Produit modifié avec succès.';
                    break;
                case 'deleted':
                    echo 'Produit supprimé avec succès.';
                    break;
                default:
                    echo 'Opération réussie.';
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
            switch ($_GET['error']) {
                case 'delete_failed':
                    echo 'Erreur lors de la suppression du produit.';
                    break;
                default:
                    echo 'Une erreur est survenue.';
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-3 rounded-3">
        <table class="table table-striped" id="produitsTable">
            <thead>
                <tr>
                    <th>reference</th>
                    <th>Libellé</th>
                    <th>Qte alerte</th>
                    <th>P.U</th>
                    <th>categorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?= htmlspecialchars($produit['reference']) ?></td>
                            <td><?= htmlspecialchars($produit['libelle']) ?></td>
                            <td><?= htmlspecialchars($produit['qte_alerte']) ?></td>
                            <td><?= htmlspecialchars($produit['prix_u']) ?></td>
                            <td><?= htmlspecialchars($produit['nom_categorie']) ?></td>
                            <td class="d-flex">
                                <!-- Show button -->
                                <a href="/sggi/produits/show?id=<?= $produit['id'] ?>" class="btn btn-info btn-sm me-1"
                                    title="Détails">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit button -->
                                <a href="/sggi/produits/edit?id=<?= $produit['id'] ?>" class="btn btn-warning btn-sm me-1"
                                    title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete button (form with POST method) -->
                                <form method="post" action="/sggi/produits/delete" class="d-inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit?');">
                                    <?php if (isset($_SESSION['csrf_token'])): ?>
                                        <input type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <?php endif; ?>
                                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>