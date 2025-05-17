<div class='edit_facture'>
    <div class="position-relative mb-4">
        <a href="/stage/factures" class="back-button">
        <i class="fas fa-arrow-left"></i>
            Retour à la liste
        </a>
        <p class="facture-label text-center m-0">
            Facture n° <span class="facture-num"><?= $facture['num_facture'] ?></span>
        </p>
    </div>


<div class="card">

<!-- Info client/date avec bouton modifier -->
<div class="card-header bg-light d-flex justify-content-between align-items-center mb-3">
        <div id="clientInfo">
            Client : <span id="clientCurrentInfo" style="color:rgb(69, 97, 157); font-weight: bold;"><?= htmlspecialchars($facture['nom_ste']) ?></span> |
            Date : <span id="dateCurrentInfo" style="color: rgb(69, 97, 157); font-weight: bold;"><?= $facture['date_emission'] ?></span>
        </div>
        <button id="editClientBtn" class="btn btn-outline-secondary btn-sm">Modifier</button>
    </div>

    <div class="card-body">
    <!-- Formulaire produit -->
    <form id="produitForm" class="row g-3 mb-4">
        <div class="col-md-4">
        <label class="">produit :</label>
        <select class="form-select" name="produit_id" required>
            <?php foreach ($produits as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['libelle']) ?></option>
            <?php endforeach; ?>
        </select>
        </div>
        <div class="col-md-3">
        <label class="">quantité :</label>
        <input type="number" name="quantite" class="form-control" placeholder="Quantité" min="1" required>
            </div>
            <div class="col-md-3">
            <label class="">remise (%) :</label>
        <input type="number" name="remise" class="form-control" placeholder="Remise (%)" min="0" max="100" value="0">
            </div>
        <button type="submit" class="btn btn-success col-md-2" style="height: 40px; align-self: flex-end;">Ajouter Produit</button>
    </form>


    <!-- Modal pour modifier client/date -->
    <div id="clientModal" class="modal-custom">
        <div class="modal-dialog">
            <form id="editClientForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-4">Modifier le Client et la Date d'émission</h5>
                </div>
                <div class="modal-body">
                    <select class="form-select" name="client_id" id="clientSelect" required>
                        <option value="" disabled>-- Choisir un client --</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client['id'] ?>" <?= $client['id'] == $facture['client_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($client['nom_ste']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="date" name="date_emission" id="dateEmission" class="form-control mt-3" value="<?= $facture['date_emission'] ?>" required>
                </div>
                <div class="modal-footer mt-4 gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" id="cancelEditBtn">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <div class="facture_details">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Qte</th>
                    <th>Prix U</th>
                    <th>Remise</th>
                    <th>HT</th>
                    <th>TVA</th>
                    <th>TTC</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ligneProduits">
                <?php if (isset($facture['lignes'])) { ?>
                    <?php foreach ($facture['lignes'] as $ligne): ?>
                        <tr data-id="<?= $ligne['produit_id'] ?>" data-tva="<?= $ligne['ttva'] ?>">
                            <td width="25%"><?= htmlspecialchars($ligne['libelle']) ?></td>
                            <td width="8%"><?= $ligne['qte'] ?></td>
                            <td width="13%"><?= number_format($ligne['prix_u'], 2) ?> dh</td>
                            <td width="5%"><?= $ligne['remise'] ?> %</td>
                            <td width="13%"><?= number_format($ligne['ht'], 2) ?> dh</td>
                            <td width="8%"><?= $ligne['ttva'] ?> %</td>
                            <td width="13%"><?= number_format($ligne['ttc'], 2) ?> dh</td>
                            <td width="15%">
                                <button class="btn btn-sm btn-warning btn-modifier">Modifier</button>
                                <button class="btn btn-sm btn-danger btn-supprimer">Supprimer</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="8" class="text-center text-secondary" style="font-size: 14px">Pas de produits enregistrés</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div class="payment-methods">
                <label class="fw-bold mb-2">Mode de paiement:</label>
                <div class="d-flex flex-wrap gap-3 mt-1">
                    <?php 
                    $modes_pay = isset($facture['modes_pay']) ? $facture['modes_pay'] : [];
                    $modes = ['espèce', 'chèque', 'carte', 'effet', 'autre'];
                    ?>
                    <?php foreach ($modes as $mode): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input mode-paiement" type="checkbox" 
                                   id="mode-<?= $mode ?>" value="<?= $mode ?>"
                                   <?= in_array($mode, $modes_pay) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="mode-<?= $mode ?>"><?= $mode ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Totals -->
            <div id="totals" class="text-end">
                <p class="mb-1"><strong>Total HT: </strong><span id="totalHT"><?= isset($facture['total_ht']) ? number_format($facture['total_ht'], 2) : '0.00' ?></span> dh</p>
                <p class="mb-0"><strong>Total TTC: </strong><span id="totalTTC"><?= isset($facture['total_ttc']) ? number_format($facture['total_ttc'], 2) : '0.00' ?></span> dh</p>
            </div>
        </div>
    </div>
    </div>

    <div class="card-footer text-start">

    <!-- Hidden fields -->
    <input type="hidden" id="hiddenClientId" value="<?= $facture['client_id'] ?>">
    <input type="hidden" id="hiddenDateFacture" value="<?= $facture['date_emission'] ?>">
    <input type="hidden" id="factureId" value="<?= $facture['id'] ?>">

    <button id="enregistrerBtn" type="button" class='btn btn-primary'>Enregistrer les modifications</button>
                    </div>
</div>
                    </div>

<style>
    .main-content {
        position: relative;
    }

    .modal-custom {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .modal-dialog {
        width: 600px;
        max-width: 90%;
        padding: 20px;
        background-color: #fff;
        border-radius: 0.2rem;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.2s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .edit_facture .modal-custom .modal-content {
        width: 100%;
    }

    .edit_facture .payment-methods {
        padding: 0.5rem 0;
    }

    .edit_facture .form-check {
        margin-right: 0.5rem;
    }

    .edit_facture .action-icons {
        cursor: pointer;
    }

    .edit_facture .action-icons:hover {
        color: #0d6efd;
    }

    .edit_facture .position-relative {
        position: relative;
    }

    .edit_facture .facture-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 500;
        font-size: 1rem;
        color: #333;
    }

    .edit_facture .facture-num {
        font-size: 1.4rem;
        font-weight: bold;
        color:rgb(49, 74, 129);
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

    .edit_facture .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-bottom: 2rem;
        margin-top: 2rem
    }

    .edit_facture .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .edit_facture .card-body {
        padding: 1.5rem;
    }

    .edit_facture .card-footer {
        padding: 1rem 1.25rem;
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    .edit_facture .table th {
        background-color: #f8f9fa;
    }

    .edit_facture .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .edit_facture .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .edit_facture .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .edit_facture .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .edit_facture .info-highlight {
        color: rgb(69, 97, 157);
        font-weight: bold;
    }

</style>

<script src="/stage/public/assets/js/jquery-3.6.0.min.js"></script>


<script>
$(document).ready(function() {
    let clientNom = '<?= htmlspecialchars($facture["nom_ste"]) ?>';
    let factureDate = '<?= $facture["date_emission"] ?>';
    let lignesProduits = <?= json_encode($facture['lignes'] ?? []) ?>;
    let totalHT = <?= $facture['total_ht'] ?? 0 ?>;
    let totalTTC = <?= $facture['total_ttc'] ?? 0 ?>;
    let factureId = <?= $facture['id'] ?>;

    // Initialize totals display
    updateTotals();

    // Edit client/date modal
    $("#editClientBtn").on("click", function() {
        $("#clientModal").css("display", "flex");
    });

    $("#cancelEditBtn").on("click", function() {
        $("#clientModal").css("display", "none");
    });

    $("#editClientForm").on("submit", function(e) {
        e.preventDefault();
        clientNom = $("#clientSelect option:selected").text();
        factureDate = $("#dateEmission").val();
        
        $("#clientCurrentInfo").text(clientNom);
        $("#dateCurrentInfo").text(factureDate);
        $("#hiddenClientId").val($("#clientSelect").val());
        $("#hiddenDateFacture").val(factureDate);
        
        $("#clientModal").css("display", "none");
    });

    function showNotification(message, type) {
            const notification = $("#notification");
            $("#notificationMessage").text(message);

            notification
                .removeClass("alert-success alert-danger alert-warning")
                .addClass("alert-" + type)
                .addClass("show")
                .show();

            setTimeout(function () {
                notification.removeClass("show").hide();
            }, 5000);
        }

    // Add product
    $("#produitForm").on("submit", function(e) {
        e.preventDefault();
        const formData = $(this).serializeArray();
        
        $.ajax({
            url: "/stage/factures/saveLine",
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(res) {
                addProductRow(res);
                lignesProduits.push(res);
                updateTotals();
            },
            error: function(xhr) {
                alert("Erreur lors de l'ajout du produit : " + xhr.responseText);
            }
        });
    });

    function addProductRow(res) {
        const row = `<tr data-id="${res.produit_id}" data-tva="${res.ttva}">
            <td>${res.libelle}</td>
            <td>${res.qte}</td>
            <td>${res.prix_u} dh</td>
            <td>${parseFloat(res.remise).toFixed(2)} %</td>
            <td>${res.ht} dh</td>
            <td>${res.ttva} %</td>
            <td>${res.ttc} dh</td>
            <td>
                <button class="btn btn-sm btn-warning btn-modifier">Modifier</button>
                <button class="btn btn-sm btn-danger btn-supprimer">Supprimer</button>
            </td>
        </tr>`;
        
        // Remove empty row if it exists
        if ($("#ligneProduits tr").length === 1 && $("#ligneProduits tr td").length === 1) {
            $("#ligneProduits").empty();
        }
        
        $("#ligneProduits").append(row);
    }

    // Product row editing
    $("#ligneProduits").on("click", ".btn-modifier", function() {
        const row = $(this).closest("tr");
        
        const produitId = row.data("id");
        const produitName = row.find("td:eq(0)").text();
        const qte = row.find("td:eq(1)").text();
        const prixU = row.find("td:eq(2)").text().replace(" dh", "");
        const remise = row.find("td:eq(3)").text().replace(" %", "");
        const tva = row.data("tva");
        
        row.data("original", row.html());
        
        row.html(`
            <td width='20%'><span class="edit-produit" data-id="${produitId}">${produitName}</span></td>
            <td width='10%'><input type="number" class="form-control form-control-sm edit-qte" value="${qte}" min="1"></td>
            <td width='10%'><span class="edit-prix" data-value="${prixU}">${prixU} dh</span></td>
            <td width='10%'><input type="number" class="form-control form-control-sm edit-remise" value="${remise}" min="0" max="100"></td>
            <td width='12%' class="edit-ht">${(prixU * qte * (1 - remise/100)).toFixed(2)} dh</td>
            <td width='10%' class="edit-tva">${tva} %</td>
            <td width='13%' class="edit-ttc">${(prixU * qte * (1 - remise/100) * (1 + tva/100)).toFixed(2)} dh</td>
            <td width='15%'>
                <button class="btn btn-sm btn-success save-edit">Enregistrer</button>
                <button class="btn btn-sm btn-secondary cancel-edit">Annuler</button>
            </td>
        `);
        
        // Add event listeners for automatic calculation
        row.find(".edit-qte, .edit-prix, .edit-remise, .edit-produit").on("change input", function() {
            calculateRowValues(row);
        });
    });

    function calculateRowValues(row) {
        const qte = parseFloat(row.find(".edit-qte").val()) || 0;
        const prixU = parseFloat(row.find(".edit-prix").data("value")) || 0;
        const remise = parseFloat(row.find(".edit-remise").val()) || 0;
        const tva = parseFloat(row.find(".edit-tva").text().replace(" %", "")) || 0;
        
        // Calculate HT
        const ht = prixU * qte * (1 - remise/100);
        // Calculate TTC
        const ttc = ht * (1 + tva/100);
        
        // Update displayed values
        row.find(".edit-ht").text(ht.toFixed(2) + " dh");
        row.find(".edit-ttc").text(ttc.toFixed(2) + " dh");
    }

    // Save edited row
    $("#ligneProduits").on("click", ".save-edit", function() {
        const row = $(this).closest("tr");
        const produitId = row.find(".edit-produit").data("id");
        const produitName = row.find(".edit-produit").text();
        const qte = parseFloat(row.find(".edit-qte").val());
        const prixU = parseFloat(row.find(".edit-prix").data("value"));
        const remise = parseFloat(row.find(".edit-remise").val());
        const tva = parseFloat(row.find(".edit-tva").text().replace(" %", ""));
        const ht = parseFloat(row.find(".edit-ht").text().replace(" dh", ""));
        const ttc = parseFloat(row.find(".edit-ttc").text().replace(" dh", ""));
        
        // Update the local array
        const ligneIndex = lignesProduits.findIndex(l => l.produit_id == row.data("id"));
        if (ligneIndex !== -1) {
            lignesProduits[ligneIndex] = {
                produit_id: produitId,
                libelle: produitName,
                qte: qte,
                prix_u: prixU,
                remise: remise,
                ht: ht,
                ttva: tva,
                ttc: ttc
            };
        }
        
        // Update the row display
        row.html(`
            <td>${produitName}</td>
            <td>${qte}</td>
            <td>${prixU.toFixed(2)} dh</td>
            <td>${remise} %</td>
            <td>${ht.toFixed(2)} dh</td>
            <td>${tva} %</td>
            <td>${ttc.toFixed(2)} dh</td>
            <td>
                <button class="btn btn-sm btn-warning btn-modifier">Modifier</button>
                <button class="btn btn-sm btn-danger btn-supprimer">Supprimer</button>
            </td>
        `);
        
        // Update data attributes
        row.data("id", produitId);
        row.data("tva", tva);
        
        // Update totals
        updateTotals();
    });

    // Cancel editing
    $("#ligneProduits").on("click", ".cancel-edit", function() {
        const row = $(this).closest("tr");
        row.html(row.data("original"));
    });

    // Delete row
    $("#ligneProduits").on("click", ".btn-supprimer", function() {
        if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
            const row = $(this).closest("tr");
            const produitId = row.data("id");
            
            // Remove from local array
            lignesProduits = lignesProduits.filter(l => l.produit_id != produitId);
            
            row.remove();
            updateTotals();
            
            // If no more rows, show empty message
            if ($("#ligneProduits tr").length === 0) {
                $("#ligneProduits").html(`
                    <tr>
                        <td colspan="8" class="text-center text-secondary" style="font-size: 14px">Pas de produits enregistrés</td>
                    </tr>
                `);
            }
        }
    });

    function updateTotals() {
        totalHT = 0;
        totalTTC = 0;
        
        lignesProduits.forEach(ligne => {
            totalHT += parseFloat(ligne.ht);
            totalTTC += parseFloat(ligne.ttc);
        });
        
        $("#totalHT").text(totalHT.toFixed(2));
        $("#totalTTC").text(totalTTC.toFixed(2));
    }

    // Save all changes
    // Save all changes
    $("#enregistrerBtn").on("click", function() {

        const btn = $(this);
        btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...');

        // Collect payment methods
        let selectedPaymentMethods = [];
        $('.mode-paiement:checked').each(function() {
            selectedPaymentMethods.push($(this).val());
        });

        // Prepare the data structure
        const data = {
            facture_id: factureId,
            client_id: $("#hiddenClientId").val(),
            date_emission: $("#hiddenDateFacture").val(),
            lignes: [],
            total_ht: totalHT,
            total_ttc: totalTTC,
            modes_paiement: selectedPaymentMethods.join(',')
        };

        // Collect all product lines (both existing and newly added)
        $("#ligneProduits tr").each(function() {
            // Skip the empty row if present
            if ($(this).find("td").length === 1) return;

            const produitId = $(this).data("id");
            const tva = $(this).data("tva");
            
            data.lignes.push({
                produit_id: produitId,
                qte: parseFloat($(this).find("td:eq(1)").text()),
                prix_u: parseFloat($(this).find("td:eq(2)").text().replace(" dh", "")),
                remise: parseFloat($(this).find("td:eq(3)").text().replace(" %", "")),
                ht: parseFloat($(this).find("td:eq(4)").text().replace(" dh", "")),
                ttva: tva,
                ttc: parseFloat($(this).find("td:eq(6)").text().replace(" dh", ""))
            });
        });

        // Send to server
        $.ajax({
            url: "/stage/factures/update",
            method: "POST",
            data: data,
            success: function(response) {
                if (response.success) {
                    showNotification("Facture modifiée avec succès", "success");
                    window.location.href = "/stage/factures/show?id=" + factureId + "&success=updated";
                } else {
                    //alert("Erreur lors de la mise à jour : " + (response.message || "Erreur inconnue"));
                    showNotification("Erreur lors de la mise à jour : " + (response.message || "Erreur inconnue"), "danger");
                }
            },
            error: function(xhr) {
                alert("Erreur lors de la mise à jour : " + xhr.responseText);
            }
        }).always(function() {
            btn.prop("disabled", false).text("Enregistrer les modifications");
        });

    });
});
</script>