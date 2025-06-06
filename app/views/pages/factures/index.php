<div class="container">
    <h1>Liste des Factures</h1>
    <div class="my-4">
        <a href="/sggi/factures/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une facture
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 'created':
                    echo 'Factures ajoutée avec succès.';
                    break;
                case 'updated':
                    echo 'Factures modifiée avec succès.';
                    break;
                case 'deleted':
                    echo 'Factures supprimée avec succès.';
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
                    echo 'Erreur lors de la suppression de la facture.';
                    break;
                default:
                    echo 'Une erreur est survenue.';
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-3 rounded-3">
    <table class="table table-striped mt-4" id="facturesTable">
        <thead>
            <tr>
                <th>Facture n</th>
                <th>Client</th>
                <th>Date d'émission</th>
                <th>total TTC</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                <?php foreach ($factures as $facture): ?>
                    <tr>
                        <td><?= htmlspecialchars($facture['num_facture']) ?></td>
                        <td><?= htmlspecialchars($facture['nom_ste']) ?></td>
                        <td><?= htmlspecialchars($facture['date_emission']) ?></td>
                        <td><?= htmlspecialchars($facture['total_ttc']) ?></td>
                        <td class="d-flex">
                            <!-- Show button -->
                            <a href="/sggi/factures/show?id=<?= $facture['id'] ?>" class="btn btn-info btn-sm me-1"
                                title="Détails">
                                <i class="fas fa-eye"></i>
                            </a>

                            <!-- Edit button -->
                            <a href="/sggi/factures/edit?id=<?= $facture['id'] ?>" class="btn btn-warning btn-sm me-1"
                                title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>

                            <!-- Delete button -->
                            <form method="post" action="/sggi/facture/delete" class="d-inline"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette facture?');">
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
        </tbody>
    </table></div>
</div>