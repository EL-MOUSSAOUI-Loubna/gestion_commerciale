<!-- This would be in your index.php view for clients -->
<div class="container">
    <h1>Liste des Clients</h1>
    
    <div class="mb-3">
        <a href="/stage/clients/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un client
        </a>
    </div>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php 
                switch($_GET['success']) {
                    case 'created': echo 'Client ajouté avec succès.'; break;
                    case 'updated': echo 'Client modifié avec succès.'; break;
                    case 'deleted': echo 'Client supprimé avec succès.'; break;
                    default: echo 'Opération réussie.';
                }
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                switch($_GET['error']) {
                    case 'delete_failed': echo 'Erreur lors de la suppression du client.'; break;
                    default: echo 'Une erreur est survenue.';
                }
            ?>
        </div>
    <?php endif; ?>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom Société</th>
                <th>ICE</th>
                <th>Téléphone</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($clients)): ?>
                <tr>
                    <td colspan="6" class="text-center">Aucun client trouvé</td>
                </tr>
            <?php else: ?>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['id']) ?></td>
                    <td><?= htmlspecialchars($client['nom_ste']) ?></td>
                    <td><?= htmlspecialchars($client['ice']) ?></td>
                    <td><?= htmlspecialchars($client['telephone']) ?></td>
                    <td><?= htmlspecialchars($client['email']) ?></td>
                    <td class="d-flex">
                        <!-- Show button -->
                        <a href="/stage/clients/show?id=<?= $client['id'] ?>" class="btn btn-info btn-sm me-1" title="Détails">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <!-- Edit button -->
                        <a href="/stage/clients/edit?id=<?= $client['id'] ?>" class="btn btn-warning btn-sm me-1" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <!-- Delete button (form with POST method) -->
                        <form method="post" action="/stage/clients/delete" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client?');">
                            <?php if (isset($_SESSION['csrf_token'])): ?>
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                            <?php endif; ?>
                            <input type="hidden" name="id" value="<?= $client['id'] ?>">
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