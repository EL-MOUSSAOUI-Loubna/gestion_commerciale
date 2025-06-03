<style>
    /* Change header background & text color */
#bonslTable thead th {
    background-color:rgb(244, 244, 244);
    color: black;
    font-weight: bold;
}

/* Change row hover effect */
#bonslTable tbody tr:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}

/* Change pagination buttons style */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.3em 0.8em;
    border-radius: 4px;
    margin: 0 2px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background:rgb(92, 67, 151) !important;
    color: white !important;
    border: none;
}

/* Remove default search input border */
.dataTables_filter input {
    border: 1px solid #ddd !important;
    border-radius: 4px;
    padding: 5px;
}
</style>

<div class="container">
    <div id="notification" class="alert alert-dismissible fade" role="alert"
        style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <span id="notificationMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>

    <h2>Liste des Bons de Livraison</h2>
    <div class="my-4 d-block self-end">
        <a href="/sggi/bonsLivraison/add" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un bon de livraison
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <script>
            $(document).ready(function() {
                showNotification('<?php 
                    switch ($_GET['success']) {
                        case 'delete_success':
                            echo 'Bon de Livraison supprimé avec succès.';
                            break;
                        default:
                            echo 'Opération réussie.';
                    }
                ?>', 'success');
            });
        </script>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <script>
            $(document).ready(function() {
                showNotification('<?php 
                    switch ($_GET['error']) {
                        case 'delete_failed':
                            echo 'Erreur lors de la suppression du Bon de Livraison.';
                            break;
                        default:
                            echo 'Une erreur est survenue.';
                    }
                ?>', 'danger');
            });
        </script>
    <?php endif; ?>

    <div class="bg-white p-3 rounded-3">
        <table class="table table-striped mt-4" id="bonslTable" style="overflow: scroll;">
            <thead>
                <tr>
                    <th>Bon L num</th>
                    <th>Date d'émission</th>
                    <th>Client</th>
                    <th>Facture num</th>
                    <th>Transport</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach ($bonsl as $bonl): ?>
                        <tr>
                            <td><?= htmlspecialchars($bonl['num_bonl']) ?></td>
                            <td><?= htmlspecialchars($bonl['date_emission']) ?></td>
                            <td><?= htmlspecialchars($bonl['nom_ste']) ?></td>
                            <td><?= htmlspecialchars($bonl['num_facture']) ?></td>
                            <td><?= htmlspecialchars($bonl['nom_transport']) ?></td>
                            <td class="d-flex">
                                <!-- Show button -->
                                <a href="/sggi/bonsLivraison/show?id=<?= $bonl['id'] ?>" class="btn btn-info btn-sm me-1"
                                    title="Détails">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit button -->
                                <a href="/sggi/bonsLivraison/edit?id=<?= $bonl['id'] ?>" class="btn btn-warning btn-sm me-1"
                                    title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete button -->
                                <form method="post" action="/sggi/bonsLivraison/delete" class="d-inline"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette facture?');">
                                    <?php if (isset($_SESSION['csrf_token'])): ?>
                                        <input type="hidden" name="csrf_token"
                                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                    <?php endif; ?>
                                    <input type="hidden" name="id" value="<?= $bonl['id'] ?>">
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

<script>
    function showNotification(message, type) {
            const notification = $("#notification");
            $("#notificationMessage").text(message);

            notification
                .removeClass("alert-success alert-danger")
                .addClass("alert-" + type)
                .addClass("show")
                .show();

            setTimeout(function () {
                notification.removeClass("show").hide();
            }, 5000);
        }
</script>