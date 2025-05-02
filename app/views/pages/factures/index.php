<div class="container">
    <h1>Liste des Factures</h1>
    
    <div class="mb-3">
        <a href="/stage/factures/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une facture
        </a>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php 
                switch($_GET['success']) {
                    case 'created': echo 'Factures ajoutée avec succès.'; break;
                    case 'updated': echo 'Factures modifiée avec succès.'; break;
                    case 'deleted': echo 'Factures supprimée avec succès.'; break;
                    default: echo 'Opération réussie.';
                }
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                switch($_GET['error']) {
                    case 'delete_failed': echo 'Erreur lors de la suppression de la facture.'; break;
                    default: echo 'Une erreur est survenue.';
                }
            ?>
        </div>
    <?php endif; ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Facture n</th>
                <th>Client</th>
                <th>Date émission</th>
                <th>total TTC</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($factures)): ?>
                <tr>
                    <td colspan="5" class="text-center">Aucune facture trouvée</td>
                </tr>
            <?php else: ?>
                <?php foreach ($factures as $facture): ?>
                <tr>
                    <td><?= htmlspecialchars($facture['num_facture']) ?></td>
                    <td><?= htmlspecialchars($facture['nom_ste']) ?></td>
                    <td><?= htmlspecialchars($facture['ice']) ?></td>
                    <td><?= htmlspecialchars($facture['telephone']) ?></td>
                    <td class="d-flex">
                        <!-- Show button -->
                        <a href="/stage/factures/show?id=<?= $facture['id'] ?>" class="btn btn-info btn-sm me-1" title="Détails">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <!-- Edit button -->
                        <a href="/stage/factures/edit?id=<?= $facture['id'] ?>" class="btn btn-warning btn-sm me-1" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <!-- Delete button (form with POST method) -->
                        <form method="post" action="/stage/facture/delete" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette facture?');">
                            <?php if (isset($_SESSION['csrf_token'])): ?>
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <?php endif; ?>
                            <input type="hidden" name="id" value="<?= $facture['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>