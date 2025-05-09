<div class="container">
    <h1>Liste des Fournisseurs</h1>

    <div class="mb-3">
        <a href="/stage/fournisseurs/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un fournisseur
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 'created':
                    echo 'Fournisseur ajouté avec succès.';
                    break;
                case 'updated':
                    echo 'Fournisseur modifié avec succès.';
                    break;
                case 'deleted':
                    echo 'Fournisseur supprimé avec succès.';
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
                    echo 'Erreur lors de la suppression du fournisseur.';
                    break;
                default:
                    echo 'Une erreur est survenue.';
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="bg-white p-3 rounded-3">

        <table class="table table-striped" id="fournisseursTable">
            <thead>
                <tr>
                    <th>Nom Société</th>
                    <th>ICE</th>
                    <th>Téléphone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($fournisseurs)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun fournisseurs trouvé</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($fournisseurs as $fournisseur): ?>
                        <tr>
                            <td><?= htmlspecialchars($fournisseur['nom_ste']) ?></td>
                            <td><?= htmlspecialchars($fournisseur['ice']) ?></td>
                            <td><?= htmlspecialchars($fournisseur['telephone']) ?></td>
                            <td><?= htmlspecialchars($fournisseur['email']) ?></td>
                            <td class="d-flex">
                                <!-- Show button -->
                                <a href="/stage/fournisseurs/show?id=<?= $fournisseur['id'] ?>" class="btn btn-info btn-sm me-1"
                                    title="Détails">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit button -->
                                <a href="/stage/fournisseurs/edit?id=<?= $fournisseur['id'] ?>" class="btn btn-warning btn-sm me-1"
                                    title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete button (form with POST method) -->
                                <form method="post" action="/stage/fournisseurs/delete" class="d-inline"
                                    onsubmit="return confirm('Êtes-vous sûre de vouloir supprimer ce fournisseur?');">
                                    <?php if (isset($_SESSION['csrf_token'])): ?>
                                        <input type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <?php endif; ?>
                                    <input type="hidden" name="id" value="<?= $fournisseur['id'] ?>">
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
</div>