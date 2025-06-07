<div class='add_facture'>
    <a href="/sggi/factures" class="back-button">
        <i class="fas fa-arrow-left"></i>
        Retour à la liste
    </a>
    <div id="clientModal" class="modal-custom" style="display: none;">
        <div class="modal-dialog">
            <form id="clientForm" class="modal-content needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title mb-4">
                        <span id="modalTitleAction">Sélectionner</span> le Client et la Date d'émission
                    </h5>
                </div>
                <div class="modal-body">
                    <select class="form-select" name="client_id" id="clientSelect" required>
                        <option value="" disabled selected>-- Choisir un client --</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['nom_ste']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Veuillez sélectionner un client.</div>

                    <input type="date" name="date_emission" id="dateEmission" class="form-control mt-3"
                        value="<?= date('Y-m-d') ?>" required>
                    <div class="invalid-feedback">Veuillez sélectionner une date.</div>
                </div>
                <div class="modal-footer mt-4">
                    <button type="submit" class="btn btn-primary">
                        <span id="submitBtnText">Sélectionner</span>
                    </button>
                    <button type="button" id="cancelClientBtn" class="btn btn-secondary ms-2" style="display: none;">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <div id="facturePage" style="display:none;" class='card'>

        <!-- Client Info Display -->
        <div id="clientInfo" class="card-header bg-light" style="display: none;">
            <div>
                Client : <span id="clientCurrentInfo" style="color:rgb(69, 97, 157); font-weight: bold;"></span> |
                Date : <span id="dateCurrentInfo" style="color: rgb(69, 97, 157); font-weight: bold;"></span>
            </div>
            <button id="editClientBtn" class="btn btn-outline-secondary btn-sm">Modifier</button>
        </div>

        <!-- Formulaire produit -->
        <div class="card-body">
            <form id="produitForm" class="row g-3 mb-4 needs-validation" novalidate>
                <div class="col-md-4">
                    <label class="">produit :</label>
                    <select class="form-select" name="produit_id" required>
                        <option value="" disabled selected>-- Choisir un produit --</option>
                        <?php foreach ($produits as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['libelle']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="">quantité :</label>
                    <input type="number" name="quantite" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <label class="">remise (%) :</label>
                    <input type="number" name="remise" class="form-control" min="0" max="100" value="0">
                </div>
                <button type="submit" class="btn btn-success col-md-2" style="height: 40px; align-self: flex-end;">Ajouter Produit</button>
            </form>

            <!-- Tableau produits -->
            <table class="table table-striped table-bordered">
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
                <tbody id="ligneProduits"></tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <div class="payment-methods">
                    <label class="fw-bold mb-2">Mode de paiement:</label>
                    <div class="d-flex flex-wrap gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox"
                                id="paiement-espece" value="espèce">
                            <label class="form-check-label" for="paiement-espece">Espèce</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox"
                                id="paiement-cheque" value="chèque">
                            <label class="form-check-label" for="paiement-cheque">Chèque</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox"
                                id="paiement-carte" value="carte">
                            <label class="form-check-label" for="paiement-carte">Carte</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox"
                                id="paiement-effet" value="effet">
                            <label class="form-check-label" for="paiement-effet">Effet</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox"
                                id="paiement-autre" value="autre">
                            <label class="form-check-label" for="paiement-autre">Autre</label>
                        </div>
                    </div>
                </div>
                <!-- Totals -->
                <div id="totals" class="text-end">
                    <p class="mb-1"><strong>Total HT: </strong><span id="totalHT">0</span> dh</p>
                    <p class="mb-0"><strong>Total TTC: </strong><span id="totalTTC">0</span> dh</p>
                </div>
            </div>
        </div>

        <div class="card-footer text-start">
            <!-- Hidden fields for storing client data -->
            <input type="hidden" id="hiddenClientId">
            <input type="hidden" id="hiddenDateFacture">

            <button id="enregistrerBtn" class="btn btn-primary" type="button">Enregistrer la facture</button>
        </div>
    </div>
</div>



<style>
    .add_facture #clientModal {
        position: absolute;
        top: 200px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1050;
        background-color: white;
        border: 1px solid #ddd;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        width: 600px;
        padding: 20px;
    }

    .add_facture #clientModal .modal-dialog {
        margin: 0;
        max-width: 100%;
    }

    .add_facture .modal-backdrop {
        display: none !important;
    }

    .back-button {
        position: relative;
        z-index: 1060;
        margin-top: 1rem;
        margin-bottom: 1.5rem;
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
        display: inline-flex;
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

    .add_facture .payment-methods {
        border-radius: 0.25rem;
        padding: 0.5rem 0;
    }

    .add_facture .form-check {
        margin-right: 0.5rem;
    }

    .add_bl .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-bottom: 2rem;
        margin-top: 2rem
    }

    .add_facture .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .add_facture .card-body {
        padding: 1.5rem;
    }

    .add_facture .card-footer {
        padding: 1rem 1.25rem;
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    .add_facture .table th {
        background-color: #f8f9fa;
    }

    .add_facture .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .add_facture .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .add_facture .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .add_facture .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .add_facture .info-highlight {
        color: rgb(69, 97, 157);
        font-weight: bold;
    }
</style>
<script src="/sggi/public/assets/js/jquery-3.6.0.min.js"></script>

<script>
    let clientNom = '';
    let factureDate = '';
    let lignesProduits = [];
    let totalHT = 0;
    let totalTTC = 0;

    let isEditing = false;

    // Initialize the page
    $(document).ready(function () {
        // Show client modal on page load for initial selection
        if (!$("#hiddenClientId").val()) {
            showClientModal(false);
        }

        // Edit client button event
        $("#editClientBtn").on("click", function () {
            showClientModal(true);
        });

        // Cancel button event
        $("#cancelClientBtn").on("click", function () {
            $("#clientModal").hide();
        });

        // Client form submission
        $("#clientForm").on("submit", function (e) {
            e.preventDefault();

            // Form validation
            if (!this.checkValidity()) {
                e.stopPropagation();
                $(this).addClass('was-validated');
                return;
            }

            // Get client data
            const selectedClientId = $("#clientSelect").val();
            const selectedClientName = $("#clientSelect option:selected").text();
            const selectedDate = $("#dateEmission").val();

            // Update hidden fields
            $("#hiddenClientId").val(selectedClientId);
            $("#hiddenDateFacture").val(selectedDate);

            // Update display
            $("#clientCurrentInfo").text(selectedClientName);
            $("#dateCurrentInfo").text(selectedDate);

            // Hide modal and show invoice form
            $("#clientModal").hide();
            $("#clientInfo").show();
            $("#facturePage").show();
        });
    });

    // Function to show client modal
    function showClientModal(editing) {
        isEditing = editing;

        // Update UI based on whether we're editing or creating
        if (editing) {
            $("#modalTitleAction").text("Modifier");
            $("#submitBtnText").text("Enregistrer");
            $("#cancelClientBtn").show();

            // Pre-select current values
            const currentClientId = $("#hiddenClientId").val();
            const currentDate = $("#hiddenDateFacture").val();

            if (currentClientId) {
                $("#clientSelect").val(currentClientId);
            }

            if (currentDate) {
                $("#dateEmission").val(currentDate);
            }
        } else {
            $("#modalTitleAction").text("Sélectionner");
            $("#submitBtnText").text("Sélectionner");
            $("#cancelClientBtn").hide();
        }

        // Show the modal
        $("#clientModal").show();
    }

    function validateField(input) {
        if (!input.value) {
            input.classList.add('is-invalid');
            return false;
        }
        input.classList.remove('is-invalid');
        return true;
    }

    document.querySelectorAll('.needs-validation').forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();

            let isValid = true;

            Array.from(form.elements).forEach(element => {
                if (element.required && !element.value.trim()) {
                    element.classList.add('is-invalid');
                    isValid = false;
                }
            });

            if (isValid) {
                if (form.id === 'initForm') {
                    let selectedClient = $("select[name='client_id'] option:selected");
                    clientNom = selectedClient.text();
                    factureDate = $("input[name='date_emission']").val();

                    $("#hiddenClientId").val(selectedClient.val());
                    $("#hiddenDateFacture").val(factureDate);

                    //$("#clientInfo").html(`Client : <span style='color:rgb(69, 97, 157); font-weight: bold;'>${clientNom}</span> | Date : <span style='color:rgb(69, 97, 157); font-weight: bold;'>${factureDate}</span>`);
                    $("#clientCurrentInfo").text(clientNom);
                    $("#dateCurrentInfo").text(factureDate);

                    $("#clientModal").hide();
                    $("#facturePage").show();
                } else {
                    // For other forms, let them handle their own submit
                    return true;
                }
            } else {
                form.classList.add('was-validated');
            }
        }, false);

        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function () {
                if (this.required) {
                    validateField(this);
                }
            });
        });
    });

    $("#produitForm").on("submit", function (e) {
        e.preventDefault();

        // Simple validation
        let isValid = true;
        $(this).find('[required]').each(function () {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (!isValid) return;

        $.ajax({
            url: "/sggi/factures/saveLine",
            method: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (res) {
                addProductRow(res);
                lignesProduits.push(res);
                updateTotals();

                $("#produitForm")[0].reset();
                $("select[name='produit_id']").val('').change();
            },
            error: function (xhr) {
                alert("Erreur lors de l'ajout du produit : " + xhr.responseText);
            }
        });
    });

    function addProductRow(res) {
        const row = `<tr data-id="${res.produit_id}">
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
        return row;
    }


    // Product row editing
    $("#ligneProduits").on("click", ".btn-modifier", function () {
        const row = $(this).closest("tr");

        const produitId = row.data("id");
        const produitName = row.find("td:eq(0)").text();
        const qte = row.find("td:eq(1)").text();
        const prixU = row.find("td:eq(2)").text().replace(" dh", "");
        const remise = row.find("td:eq(3)").text().replace(" %", "");
        const tva = parseFloat(row.find("td:eq(5)").text().replace(" %", ""));

        row.data("original", row.html());

        row.html(`
            <td width='20%'><span class="edit-produit" data-id="${produitId}">${produitName}</span></td>
            <td width='10%'><input type="number" class="form-control form-control-sm edit-qte" value="${qte}" min="1"></td>
            <td width='10%'><span class="edit-prix" data-value="${prixU}">${prixU} dh</span></td>
            <td width='10%'><input type="number" class="form-control form-control-sm edit-remise" value="${remise}" min="0" max="100"></td>
            <td width='12%' class="edit-ht">${(prixU * qte * (1 - remise / 100)).toFixed(2)} dh</td>
            <td width='10%' class="edit-tva">${tva} %</td>
            <td width='13%' class="edit-ttc">${(prixU * qte * (1 - remise / 100) * (1 + tva / 100)).toFixed(2)} dh</td>
            <td width='15%'>
                <button class="btn btn-sm btn-success save-edit">Enregistrer</button>
                <button class="btn btn-sm btn-secondary cancel-edit">Annuler</button>
            </td>
        `);

        // Add event listeners for automatic calculation
        row.find(".edit-qte, .edit-prix, .edit-remise, .edit-produit").on("change input", function () {
            calculateRowValues(row);
        });
    });


    function calculateRowValues(row) {
        const qte = parseFloat(row.find(".edit-qte").val()) || 0;
        const prixU = parseFloat(row.find(".edit-prix").data("value")) || 0;
        const remise = parseFloat(row.find(".edit-remise").val()) || 0;
        const tva = parseFloat(row.find(".edit-tva").text().replace(" %", "")) || 0;

        // Calculate HT
        const ht = prixU * qte * (1 - remise / 100);
        // Calculate TTC
        const ttc = ht * (1 + tva / 100);

        // Update displayed values
        row.find(".edit-ht").text(ht.toFixed(2) + " dh");
        row.find(".edit-ttc").text(ttc.toFixed(2) + " dh");
    }


    // Save edited row
    $("#ligneProduits").on("click", ".save-edit", function () {
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
        const ligneIndex = lignesProduits.findIndex(l => l.produit_id == produitId);
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
            console.log("Updated lignesProduits:", lignesProduits);
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
        row.attr("data-id", produitId);

        // Update totals
        updateTotals();
    });


    // Cancel editing
    $("#ligneProduits").on("click", ".cancel-edit", function () {
        const row = $(this).closest("tr");
        row.html(row.data("original"));
    });


    $("#ligneProduits").on("click", ".btn-supprimer", function () {
        if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
            //const produit_id = $(this).data("id");
            const row = $(this).closest("tr");
            const produitId = row.data("id");
            console.log("produit id to be deleted is : ", produitId);
            // Remove from array
            //lignesProduits = lignesProduits.filter(item => item.id !== produit_id);
            lignesProduits = lignesProduits.filter(l => l.produit_id != produitId);

            row.fadeOut(300, function () {
                $(this).remove();

                // If no more rows, show empty message
                if ($("#ligneProduits tr").length === 0) {
                    $("#ligneProduits").html(`
          <tr>
            <td colspan="8" class="text-center text-secondary" style="font-size: 14px">Pas de produits enregistrés</td>
          </tr>
        `);
                }
            });

            updateTotals();

            //alert("Produit supprimé avec succès.", "success");
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


    $("#enregistrerBtn").on("click", function () {
        let selectedPaymentMethods = [];

        $('.payment-method-checkbox:checked').each(function () {
            selectedPaymentMethods.push($(this).val());
        });

        const data = {
            client_id: $("#hiddenClientId").val(),
            date_emission: $("#hiddenDateFacture").val(),
            lignes: lignesProduits,
            total_ht: parseFloat(totalHT.toFixed(2)),
            total_ttc: parseFloat(totalTTC.toFixed(2)),
            modes_paiement: selectedPaymentMethods.join(',')
        };
        console.log(data);

        $.ajax({
            url: "/sggi/factures/store",
            method: "POST",
            contentType: "application/json", // Make sure this is set
            data: JSON.stringify(data),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    alert("Facture enregistrée avec succès !");
                    window.location.href = "/sggi/factures/show?id=" + response.facture_id + "&success=created";
                } else {
                    alert("Erreur lors de l'enregistrement : " + (response.message || "Erreur inconnue"));
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert("Erreur lors de l'enregistrement : " + xhr.responseText);
            }
        });
    }); 
</script>