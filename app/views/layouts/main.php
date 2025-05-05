<?php // At the top of the form page (add.php):
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
    <link href="/stage/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/stage/public/assets/css/all.min.css" rel="stylesheet">
    
    <link href="/stage/public/assets/datatables/datatables.min.css" rel="stylesheet">
    <link href="/stage/public/assets/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="/stage/public/assets/css/app.css" rel="stylesheet">

</head>

<body>

    <?php include __DIR__ . '/sidebar.php'; ?>

    <?php include __DIR__ . '/navbar.php'; ?>

    <div class="main-content">
        <div class="container-fluid" style="overflow-x: auto;">
            <?php include VIEW_PATH. '/' . $content_view . '.php'; ?>
        </div>
    </div>

    <?php include __DIR__ . '/b_nav.php'; ?>
    <?php include __DIR__ . '/footer.php'; ?>

<script src="/stage/public/assets/js/jquery-3.6.0.min.js"></script>
<script>
  let clientNom = '';
  let factureDate = '';
  let lignesProduits = [];
  let totalHT = 0; 
    let totalTTC = 0;

  $("#initForm").on("submit", function(e) {
        e.preventDefault();
        let selectedClient = $("select[name='client_id'] option:selected");
        clientNom = selectedClient.text();
        factureDate = $("input[name='date_emission']").val();

        $("#hiddenClientId").val(selectedClient.val());
        $("#hiddenDateFacture").val(factureDate);

        $("#clientInfo").html(`Client : ${clientNom} | Date : ${factureDate}`);
        $("#clientModal").hide();
        $("#facturePage").show();
  });


  $("#produitForm").on("submit", function(e) {
    e.preventDefault();
    $.ajax({
        url: "/stage/factures/saveLine",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(res) {
            let row = `<tr>
                <td>${res.libelle}</td>
                <td>${res.qte}</td>
                <td>${res.prix_u} dh</td>
                <td>${parseFloat(res.remise).toFixed(2)} %</td>
                <td>${res.ht} dh</td>
                <td>${res.ttc} dh</td>
            </tr>`;
            $("#ligneProduits").append(row);

            totalHT += parseFloat(res.ht);  // Add to the total HT
            totalTTC += parseFloat(res.ttc); // Add to the total TTC

             // Update the displayed totals
             $("#totalHT").text(totalHT.toFixed(2));  // Update total HT
            $("#totalTTC").text(totalTTC.toFixed(2)); // Update total TTC

            // Save line for later
            lignesProduits.push(res);
            } ,
        error: function(xhr) {
            alert("Erreur lors de l'ajout du produit : " + xhr.responseText);
        }
    });
  });

  $("#enregistrerBtn").on("click", function() {
    let selectedPaymentMethods = [];

    $('.payment-method-checkbox:checked').each(function() {
        selectedPaymentMethods.push($(this).val());
    });

    const data = {
        client_id: $("#hiddenClientId").val(),
        date_emission: $("#hiddenDateFacture").val(),
        lignes: lignesProduits,
        total_ht : parseFloat(totalHT.toFixed(2)),  // Ensure consistent decimal precision
        total_ttc: parseFloat(totalTTC.toFixed(2)),
        modes_paiement: selectedPaymentMethods.join(',')
    };
    console.log(data);

    $.ajax({
        url: "/stage/factures/store", // adjust to match your routing system
        method: "POST",
        contentType: "application/json", // Make sure this is set
        data: JSON.stringify(data),
        dataType: "json",
        success: function(response) {
        if (response.success) {
            alert("Facture enregistrée avec succès !");
            window.location.href = "/stage/factures/show?id=" + response.facture_id + "&success=created";
        } else {
            alert("Erreur lors de l'enregistrement : " + (response.message || "Erreur inconnue"));
        }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        alert("Erreur lors de l'enregistrement : " + xhr.responseText);
        }
    });
    });
</script>

<script>
    $(document).ready(function() {
    $('#facturesTable').DataTable();
    $('#clientsTable').DataTable();
    $('#produitsTable').DataTable();

    
});
</script>
    <script src="/stage/public/assets/js/app.js"></script>
    <script src="/stage/public/assets/datatables/datatables.min.js"></script>
    <script src="/stage/public/assets/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="/stage/public/assets/datatables/datatables.min.js"></script>
    <script src="/stage/public/assets/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>