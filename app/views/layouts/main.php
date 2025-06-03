<?php
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/header.php'; ?>
    <!-- CSS -->
    <link href="/sggi/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sggi/public/assets/css/all.min.css" rel="stylesheet">

    <link href="/sggi/public/assets/datatables/datatables.min.css" rel="stylesheet">
    <link href="/sggi/public/assets/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="/sggi/public/assets/css/app.css" rel="stylesheet">

</head>

<body>

    <?php include __DIR__ . '/sidebar.php'; ?>

    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="main-content">
        <div class="container-fluid" style="overflow-x: auto;">
            <?php include VIEW_PATH . '/' . $content_view . '.php'; ?>
        </div>
    </div>

    <?php include __DIR__ . '/b_nav.php'; ?>

    <script src="/sggi/public/assets/js/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function () {
            $('#facturesTable').DataTable({
                language: {
                    emptyTable: "Aucune facture trouvée"
                }
            });
            $('#clientsTable').DataTable({
                language: {
                    emptyTable: "Aucun client trouvé"
                }
            });
            $('#produitsTable').DataTable({
                language: {
                    emptyTable: "Aucun produit trouvé"
                }
            });
            $('#categorieProduits').DataTable({
                language: {
                    emptyTable: "Aucun produit trouvé pour cette catégorie"
                }
            });
            $('#fournisseursTable').DataTable({
                language: {
                    emptyTable: "Aucun fournisseur trouvé"
                }
            });
            $('#bonslTable').DataTable({
                language: {
                    emptyTable: "Aucun bon de livraison trouvé"
                }
            });

        });
    </script>
    <script src="/sggi/public/assets/js/app.js"></script>
    <script src="/sggi/public/assets/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="/sggi/public/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/sggi/public/assets/datatables/datatables.min.js"></script>

    
</body>

</html>