<div class='add_bl'>
    <a href="/stage/bonsLivraison" class=" back-button">
        <i class="fas fa-arrow-left"></i>
        Retour à la liste
    </a>
    <div id="clientModal">
        <div class="modal-dialog">
            <form id="initForm" class="modal-content needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title mb-2">Sélectionner le Client et la Date d'émission</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                        <select class="form-select" id="client_id" name="client_id" required>
                            <option value="" disabled selected>-- Choisir un client --</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['nom_ste']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Veuillez sélectionner un client.</div>
                    </div>

                    <div class="mb-3">
                        <label for="date_emission" class="form-label">Date d'émission <span
                                class="text-danger">*</span></label>
                        <input type="date" id="date_emission" name="date_emission" class="form-control"
                            value="<?= date('Y-m-d') ?>" required>
                        <div class="invalid-feedback">Veuillez sélectionner une date d'émission.</div>
                    </div>

                    <div class="mb-3">
                        <label for="num_facture" class="form-label">Numéro de facture <span
                                class="text-danger">*</span></label>
                        <input type="text" id="num_facture" name="num_facture" class="form-control"
                            placeholder="Numéro de facture" required>
                        <div class="invalid-feedback">Veuillez saisir un numéro de facture.</div>
                    </div>

                    <div class="mb-3">
                        <label for="nom_transporteur" class="form-label">Nom du transporteur <span
                                class="text-danger">*</span></label>
                        <input type="text" id="nom_transporteur" name="nom_transporteur" class="form-control"
                            placeholder="Nom du transporteur">
                        <div class="invalid-feedback">Veuillez saisir le nom du transporteur.</div>
                    </div>

                    <div class="mb-3">
                        <label for="telephone_transporteur" class="form-label">Téléphone du transporteur</label>
                        <input type="tel" id="telephone_transporteur" name="telephone_transporteur" class="form-control"
                            placeholder="Téléphone du transporteur">
                        <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Sélectionner</button>
                </div>
            </form>
        </div>
    </div>

    <div id="blPage" class="card" style="display:none;">
        <div class="card-header bg-light">
            <div>
                <div class="mb-2">Client : <span class="info-highlight fw-bold" id="clientInfo"></span></div>
                <div class="mb-2">Date émission : <span class="info-highlight fw-bold" id="dateEm"></span></div>
                <div class="mb-2">Facture n : <span class="info-highlight fw-bold" id="factureNum"></span></div>
            </div>
            <div>
                <div class="mb-2">Transport : <span class="info-highlight fw-bold" id="transportNom"></span></div>
                <div class="mb-2">Téléphone transport : <span class="info-highlight fw-bold" id="transportTel"></span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Formulaire produit -->
            <form id="produitForm" class="row g-3 mb-4">
                <div class="col-md-6">
                    <select class="form-select" name="produit_id" required>
                        <option value="" disabled selected>-- Sélectionner un produit --</option>
                        <?php foreach ($produits as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['libelle']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="quantite" class="form-control" placeholder="Quantité" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-success w-100">Ajouter Produit</button>
                </div>
            </form>

            <!-- Tableau produits -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Référence</th>
                            <th>Produit</th>
                            <th>Qté</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ligneProduits"></tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <!-- Champs cachés -->
            <input type="hidden" id="hiddenClientId">
            <input type="hidden" id="hiddenFactureId">
            <input type="hidden" id="hiddenDateBL">
            <input type="hidden" id="hiddenNumFacture">
            <input type="hidden" id="hiddenNomTransporteur">
            <input type="hidden" id="hiddenTelephoneTransporteur">

            <button id="enregistrerBtn" class="btn btn-primary" type="button">
                <i class="fas fa-save me-2"></i>Enregistrer
            </button>
        </div>
    </div>

    <!-- Notifications -->
    <div id="notification" class="alert alert-dismissible fade" role="alert"
        style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <span id="notificationMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
    </div>
</div>

<style>
    .add_bl #clientModal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050;
        background-color: white;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        width: 600px;
        max-width: 90%;
    }

    .add_bl #clientModal .modal-dialog {
        margin: 0;
        max-width: 100%;
    }

    .add_bl #clientModal .modal-content {
        border: none;
        border-radius: 8px;
    }

    .add_bl #clientModal .modal-header {
        border-bottom: 1px solid #e5e5e5;
        padding: 1.25rem;
        background-color: #f8f9fa;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .add_bl #clientModal .modal-body {
        padding: 1.5rem;
    }

    .add_bl #clientModal .modal-footer {
        border-top: 1px solid #e5e5e5;
        padding: 1rem;
        background-color: #f8f9fa;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .add_bl .modal-backdrop {
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

    .add_bl .card {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-bottom: 2rem;
        margin-top: 2rem
    }

    .add_bl .card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .add_bl .card-body {
        padding: 1.5rem;
    }

    .add_bl .card-footer {
        padding: 1rem 1.25rem;
        background-color: #f8f9fa;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }

    .add_bl .table th {
        background-color: #f8f9fa;
    }

    .add_bl .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .add_bl .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .add_bl .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .add_bl .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .add_bl .info-highlight {
        color: rgb(69, 97, 157);
        font-weight: bold;
    }
</style>

<script src="/stage/public/assets/js/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        let clientNom = '';
        let clientId = '';
        let blDate = '';
        let num_facture = '';
        let nom_transporteur = '';
        let telephone_transporteur = '';
        //let facture_id = null;
        let lignesProduits = [];

        // Show notification function
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

        // Form submission
        $("#initForm").on("submit", function (e) {
            e.preventDefault();

            // Get form values
            clientId = $("select[name='client_id']").val();
            clientNom = $("select[name='client_id'] option:selected").text();
            blDate = $("input[name='date_emission']").val();
            num_facture = $("input[name='num_facture']").val();
            nom_transporteur = $("input[name='nom_transporteur']").val();
            telephone_transporteur = $("input[name='telephone_transporteur']").val();

            // Validate form
            if (!clientId || !blDate || !num_facture) {
                showNotification("Veuillez remplir tous les champs obligatoires.", "danger");
                return false;
            }

            // Validate phone number if provided
            const phoneRegex = /^[0-9]{10,15}$/;
            if (telephone_transporteur && !phoneRegex.test(telephone_transporteur.replace(/\s/g, ''))) {
                showNotification("Le numéro de téléphone n'est pas valide.", "danger");
                return false;
            }

            // Check if facture exists
            $.ajax({
                url: "/stage/bonsLivraison/checkFacture",
                method: "POST",
                data: { num_facture: num_facture },
                dataType: "json",
                success: function (res) {
                    if (res.exists) {
                        let facture_id = res.facture_id;

                        // Set hidden fields
                        $("#hiddenClientId").val(clientId);
                        $("#hiddenFactureId").val(facture_id);
                        $("#hiddenDateBL").val(blDate);
                        $("#hiddenNumFacture").val(num_facture);
                        $("#hiddenNomTransporteur").val(nom_transporteur);
                        $("#hiddenTelephoneTransporteur").val(telephone_transporteur);

                        // Update info displays
                        $("#clientInfo").text(clientNom);
                        $("#factureNum").text(num_facture);
                        $("#dateEm").text(blDate);
                        $("#transportNom").text(nom_transporteur);
                        $("#transportTel").text(telephone_transporteur);

                        // Hide modal, show main page
                        $("#clientModal").hide();
                        $("#blPage").fadeIn();
                    } else {
                        showNotification("Aucune facture trouvée avec ce numéro.", "warning");
                    }
                },
                error: function (xhr) {
                    showNotification("Erreur lors de la vérification : " + xhr.responseText, "danger");
                }
            });
        });

        // Add Product
        $("#produitForm").on("submit", function (e) {
            e.preventDefault();

            const produitId = $(this).find("[name='produit_id']").val();
            const quantite = $(this).find("[name='quantite']").val();

            if (!produitId || !quantite) {
                showNotification("Veuillez sélectionner un produit et indiquer une quantité.", "warning");
                return false;
            }

            $.ajax({
                url: "/stage/bonsLivraison/saveLine",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function (res) {
                    // Add row to table
                    const row = `<tr data-id="${res.produit_id}">
                        <td>${res.reference}</td>
                        <td>${res.libelle}</td>
                        <td>${res.qte}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning btn-modifierQte me-2" data-id="${res.produit_id}">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <button class="btn btn-sm btn-danger btn-supprimer" data-id="${res.produit_id}">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>`;

                    $("#ligneProduits").append(row);

                    // Save line for later
                    lignesProduits.push(res);
                    console.log(ligneProduits);


                    // Reset form
                    $("#produitForm")[0].reset();
                    $("#produitForm select[name='produit_id']").focus();

                    showNotification("Produit ajouté avec succès.", "success");
                },
                error: function (xhr) {
                    showNotification("Erreur lors de l'ajout du produit : " + xhr.responseText, "danger");
                }
            });
        });

        // Delete product row
        $("#ligneProduits").on("click", ".btn-supprimer", function () {
            const id = $(this).data("id");
            console.log(id);


            // Remove from array
            lignesProduits = lignesProduits.filter(item => item.id !== id);

            // Remove from table
            $(this).closest("tr").fadeOut(300, function () {
                $(this).remove();
            });

            showNotification("Produit supprimé avec succès.", "success");

            const row = $(this).closest("tr");
            const produitId = row.data("id");

            // If no more rows, show empty message
            if ($("#ligneProduits tr").length === 0) {
                $("#ligneProduits").html(`
                    <tr>
                        <td colspan="8" class="text-center text-secondary" style="font-size: 14px">Pas de produits enregistrés</td>
                    </tr>
                `);
            }
        });



        // Cancel modification
        $(document).on("click", ".btn-cancel", function () {
            const row = $(this).closest("tr");

            // Restore original HTML
            if (row.data("originalHtml")) {
                row.html(row.data("originalHtml"));
            }
        });

        // Modify product row
        $("#ligneProduits").on("click", ".btn-modifierQte", function () {
            const id = $(this).data("id");
            const row = $(this).closest("tr");
            const currentQte = row.find("td:nth-child(3)").text();

            // Save current row state for cancel action
            row.data("originalHtml", row.html());

            // Replace quantity cell with input
            row.find("td:nth-child(3)").html(`<input type="number" class="form-control form-control-sm edit-qte" value="${currentQte}" min="1" required>`);

            // Replace action buttons with save/cancel buttons
            row.find("td:nth-child(4)").html(`
                <button class="btn btn-sm btn-success btn-save me-2" data-id="${id}">
                    <i class="fas fa-check"></i> Enregistrer
                </button>
                <button class="btn btn-sm btn-secondary btn-cancel">
                    <i class="fas fa-times"></i> Annuler
                </button>
    `);

            // Focus on the quantity input
            row.find(".edit-qte").focus().select();
        });



        $("#ligneProduits").on("click", ".btn-save", function () {
            const id = $(this).data("id");
            const row = $(this).closest("tr");
            const newQte = row.find(".edit-qte").val();

            // Validate input
            if (!newQte || parseInt(newQte) < 1) {
                showNotification("La quantité doit être d'au moins 1.", "warning");
                return;
            }
            lignesProduits = lignesProduits.map(item => {
                if (item.id == id) {
                    item.qte = newQte;
                }
                return item;
            });
            // Update row display
            row.find("td:nth-child(3)").text(newQte);
            row.find("td:nth-child(4)").html(`
                <button class="btn btn-sm btn-warning btn-modifierQte me-2" data-id="${id}">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn btn-sm btn-danger btn-supprimer" data-id="${id}">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
        `);
            showNotification("Quantité modifiée avec succès.", "success");
        });


        // Save Bon de Livraison
        $("#enregistrerBtn").on("click", function () {
            if (lignesProduits.length === 0) {
                showNotification("Veuillez ajouter au moins un produit au bon de livraison.", "warning");
                return;
            }

            const data = {
                client_id: $("#hiddenClientId").val(),
                date_emission: $("#hiddenDateBL").val(),
                facture_id: $("#hiddenFactureId").val(),
                num_facture: $("#hiddenNumFacture").val(),
                nom_transporteur: $("#hiddenNomTransporteur").val(),
                telephone_transporteur: $("#hiddenTelephoneTransporteur").val(),
                lignes: lignesProduits
            };
            console.log(data);

            $.ajax({
                url: "/stage/bonsLivraison/store",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify(data),
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        showNotification("Bon de Livraison enregistré avec succès !", "success");
                        setTimeout(function () {
                            window.location.href = "/stage/bonsLivraison/show?id=" + response.bl_id + "&success=created";
                        }, 1500);
                    } else {
                        showNotification("Erreur lors de l'enregistrement : " + (response.message || "Erreur inconnue"), "danger");
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    showNotification("Erreur lors de l'enregistrement du bon de livraison.", "danger");
                }
            });
            console.log(data);
        });
    });
</script>