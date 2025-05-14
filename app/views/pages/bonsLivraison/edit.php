<div class='edit_bonl'>
    <div class="position-relative mb-4">
        <a href="/stage/bonsLivraison" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Retour à la liste
        </a>
        <p class="facture-label text-center m-0">
            Bon de Livraison n° <span class="bonl-num"><?= $bonl['num_bonl'] ?></span>
        </p>
    </div>


    <!-- Formulaire produit -->
    <form id="produitForm" class="d-flex gap-2 mb-3">
        <select class="form-select" name="produit_id" required>
            <?php foreach ($produits as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['libelle']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="quantite" class="form-control" placeholder="Quantité" min="1" required>
        <button type="submit" class="btn btn-success">Ajouter Produit</button>
    </form>

    <!-- Info client/date avec bouton modifier -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div id="clientInfo">
            Client : <span id="clientCurrentInfo"
                style="color:rgb(69, 97, 157); font-weight: bold;"><?= htmlspecialchars($bonl['nom_ste']) ?></span> |
            Date : <span id="dateCurrentInfo"
                style="color: rgb(69, 97, 157); font-weight: bold;"><?= $bonl['date_emission'] ?></span> |
            facture n : <span id="numFactureCurrentInfo"
                style="color: rgb(69, 97, 157); font-weight: bold;"><?= $bonl['nom_transport'] ?></span> |
            transport : <span id="nomTransportCurrentInfo"
                style="color: rgb(69, 97, 157); font-weight: bold;"><?= $bonl['nom_transport'] ?></span> |
            tel transport : <span id="telephoneTransportCurrentInfo"
                style="color: rgb(69, 97, 157); font-weight: bold;"><?= $bonl['telephone_transport'] ?></span>
        </div>
        <button id="editClientBtn" class="btn btn-outline-secondary btn-sm">Modifier</button>
    </div>

    <!-- Modal pour modifier client/date -->
    <div id="clientModal" class="modal-custom">
        <div class="modal-dialog">
            <form id="editClientForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-4">Modifier le Client et la Date d'émission</h5>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="client_id" class="form-label">Client <span class="text-danger">*</span></label>
                        <select class="form-select" name="client_id" id="clientSelect" required>
                            <option value="" disabled>-- Choisir un client --</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client['id'] ?>" <?= $client['id'] == $bonl['client_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($client['nom_ste']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Veuillez sélectionner un client.</div>
                    </div>

                    <div class="mb-3">
                        <label for="date_emission" class="form-label">Date d'émission <span
                                class="text-danger">*</span></label>
                        <input type="date" name="date_emission" id="dateEmission" class="form-control"
                            value="<?= $bonl['date_emission'] ?>" required>
                        <div class="invalid-feedback">Veuillez sélectionner une date d'émission.</div>
                    </div>

                    <div class="mb-3">
                        <label for="numFacture" class="form-label">Numéro de facture <span
                                class="text-danger">*</span></label>
                        <input type="text" id="numFacture" name="num_facture" class="form-control"
                            value="<?= $bonl['num_facture'] ?>" required>
                        <div class="invalid-feedback">Veuillez saisir un numéro de facture.</div>
                    </div>

                    <div class="mb-3">
                        <label for="nomTransporteur" class="form-label">Nom du transporteur <span
                                class="text-danger">*</span></label>
                        <input type="text" id="nomTransporteur" name="nom_transporteur" class="form-control"
                        value="<?= $bonl['nom_transport'] ?>" >
                    </div>

                    <div class="mb-3">
                        <label for="telephoneTransporteur" class="form-label">Téléphone du transporteur</label>
                        <input type="tel" id="telephoneTransporteur" name="telephone_transporteur" class="form-control"
                        value="<?= $bonl['telephone_transport'] ?>">
                        <div class="invalid-feedback">Veuillez saisir un numéro de téléphone valide.</div>
                    </div>
                </div>


        </div>
        <div class="modal-footer mt-4 gap-2">
            <button type="button" class="btn btn-secondary" id="cancelEditBtn">Annuler</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
        </form>
    </div>
</div>

<div class="bonl_details">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Produit</th>
                <th>Qte</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="ligneProduits">
            <?php if (isset($bonl['lignes'])) { ?>
                <?php foreach ($bonl['lignes'] as $ligne): ?>
                    <tr data-id="<?= $ligne['produit_id'] ?>">
                        <td width="25%"><?= htmlspecialchars($ligne['reference']) ?></td>
                        <td width="25%"><?= htmlspecialchars($ligne['libelle']) ?></td>
                        <td width="8%"><?= $ligne['qte'] ?></td>
                        <td width="15%">
                            <button class="btn btn-sm btn-danger btn-supprimer">Supprimer</button>
                            <button class="btn btn-sm btn-warning btn-modifier">Modifier</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php } else { ?>
                <tr>
                    <td colspan="8" class="text-center text-secondary" style="font-size: 14px">Pas de produits enregistrés
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Hidden fields -->
<input type="hidden" id="hiddenClientId" value="<?= $bonl['client_id'] ?>">
<input type="hidden" id="hiddenDateBonl" value="<?= $bonl['date_emission'] ?>">
<input type="hidden" id="hiddenNumFacture" value="<?= $bonl['num_facture'] ?>">
<input type="hidden" id="hiddenNomTransport" value="<?= $bonl['nom_transport'] ?>">
<input type="hidden" id="hiddenTelephoneTransport" value="<?= $bonl['telephone_transport'] ?>">

<input type="hidden" id="factureId" value="<?= $bonl['id'] ?>">

<button id="enregistrerBtn" type="button">Enregistrer les modifications</button>
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
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .edit_bonl .modal-custom .modal-content {
        width: 100%;
    }

    .edit_bonl .payment-methods {
        padding: 0.5rem 0;
    }

    .edit_bonl .form-check {
        margin-right: 0.5rem;
    }

    .edit_bonl .action-icons {
        cursor: pointer;
    }

    .edit_bonl .action-icons:hover {
        color: #0d6efd;
    }

    .edit_bonl .position-relative {
        position: relative;
    }

    .edit_bonl .facture-label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 500;
        font-size: 1rem;
        color: #333;
    }

    .edit_bonl .bonl-num {
        font-size: 1.4rem;
        font-weight: bold;
        color: rgb(49, 74, 129);
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

    .edit_bonl #enregistrerBtn {
        background-color: rgb(87, 118, 187);
        padding: 7px 11px;
        border-radius: 4px;
        border: none;
        color: white;
        transition: background-color 0.2s ease;
    }

    .edit_bonl #enregistrerBtn:hover {
        background-color: rgb(55, 79, 136);
    }
</style>

<script src="/stage/public/assets/js/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function () {
        let clientNom = '<?= htmlspecialchars($bonl["nom_ste"]) ?>';
        let bonlDate = '<?= $bonl["date_emission"] ?>';
        let numFacture = '<?= htmlspecialchars($bonl["num_facture"]) ?>';
        let nomTransport = '<?= htmlspecialchars($bonl["nom_transport"]) ?>';
        let telephoneTransport = '<?= htmlspecialchars($bonl["telephone_transport"]) ?>';

        let lignesProduits = <?= json_encode($bonl['lignes'] ?? []) ?>;
        let bonlId = <?= $bonl['id'] ?>;

        // Edit client/date modal
        $("#editClientBtn").on("click", function () {
            $("#clientModal").css("display", "flex");
        });

        $("#cancelEditBtn").on("click", function () {
            $("#clientModal").css("display", "none");
        });

        $("#editClientForm").on("submit", function (e) {
            e.preventDefault();
            clientNom = $("#clientSelect option:selected").text();
            bonlDate = $("#dateEmission").val();
            numFacture = $("#numFacture").val();
            nomTransport = $("#nomTransport").val();
            telephoneTransport = $("#telephoneTransport").val();

            $("#clientCurrentInfo").text(clientNom);
            $("#dateCurrentInfo").text(bonlDate);
            $("#numFactureCurrentInfo").text(numFacture);
            $("#nomTransportCurrentInfo").text(nomTransport);
            $("#telephoneTransportCurrentInfo").text(telephoneTransport);

            $("#hiddenClientId").val($("#clientSelect").val());
            $("#hiddenDateBonl").val(bonlDate);
            $("#hiddenNumFacture").val(numFacture);
            $("#hiddenNomTransport").val(nomTransport);
            $("#hiddenNomTransport").val(telephoneTransport);

            $("#clientModal").css("display", "none");
        });

        // Add product
        $("#produitForm").on("submit", function (e) {
            e.preventDefault();
            const formData = $(this).serializeArray();

            $.ajax({
                url: "/stage/bonsLivraison/saveLine",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    addProductRow(res);
                    lignesProduits.push(res);
                },
                error: function (xhr) {
                    alert("Erreur lors de l'ajout du produit : " + xhr.responseText);
                }
            });
        });

        function addProductRow(res) {
            const row = `<tr data-id="${res.produit_id}">
            <td>${res.reference}</td>
            <td>${res.libelle}</td>
            <td>${res.qte}</td>
            <td>
                <button class="btn btn-sm btn-danger btn-supprimer">Supprimer</button>
                <button class="btn btn-sm btn-warning btn-modifier">Modifier</button>
            </td>
        </tr>`;

            // Remove empty row if it exists
            if ($("#ligneProduits tr").length === 1 && $("#ligneProduits tr td").length === 1) {
                $("#ligneProduits").empty();
            }

            $("#ligneProduits").append(row);
        }

        // Product row editing
        $("#ligneProduits").on("click", ".btn-modifier", function () {
            const row = $(this).closest("tr");

            const produitId = row.data("id");
            const reference = row.find("td:eq(0)").text();
            const produitName = row.find("td:eq(1)").text();
            const qte = row.find("td:eq(2)").text();

            row.data("original", row.html());

            row.html(`
            <td width='20%'><span class="edit-reference">${reference}</span></td>
            <td width='20%'><span class="edit-produit" data-id="${produitId}">${produitName}</span></td>
            <td width='10%'><input type="number" class="form-control form-control-sm edit-qte" value="${qte}" min="1"></td>
            <td width='15%'>
                <button class="btn btn-sm btn-success save-edit">Enregistrer</button>
                <button class="btn btn-sm btn-secondary cancel-edit">Annuler</button>
            </td>
        `);
        });

        // Save edited row
        $("#ligneProduits").on("click", ".save-edit", function () {
            const row = $(this).closest("tr");
            const produitId = row.find(".edit-produit").data("id");
            const reference = row.find(".edit-reference").text();
            const produitName = row.find(".edit-produit").text();
            const qte = parseFloat(row.find(".edit-qte").val());

            // Update the local array
            const ligneIndex = lignesProduits.findIndex(l => l.produit_id == row.data("id"));
            if (ligneIndex !== -1) {
                lignesProduits[ligneIndex] = {
                    produit_id: produitId,
                    reference: reference,
                    libelle: produitName,
                    qte: qte,
                };
            }

            // Update the row display
            row.html(`
            <td>${reference}</td>
            <td>${produitName}</td>
            <td>${qte}</td>
            <td>
                <button class="btn btn-sm btn-danger btn-supprimer">Supprimer</button>
                <button class="btn btn-sm btn-warning btn-modifier">Modifier</button>
            </td>
        `);

            // Update data attributes
            row.data("id", produitId);

        });

        // Cancel editing
        $("#ligneProduits").on("click", ".cancel-edit", function () {
            const row = $(this).closest("tr");
            row.html(row.data("original"));
        });

        // Delete row
        $("#ligneProduits").on("click", ".btn-supprimer", function () {
            if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
                const row = $(this).closest("tr");
                const produitId = row.data("id");

                // Remove from local array
                lignesProduits = lignesProduits.filter(l => l.produit_id != produitId);

                row.remove();

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

        // Save all changes
        $("#enregistrerBtn").on("click", function () {

            const btn = $(this);
            btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enregistrement...');

            // Prepare the data structure
            const data = {
                facture_id: factureId,
                client_id: $("#hiddenClientId").val(),
                date_emission: $("#hiddenDateBonl").val(),
                num_facture: $("#hiddenNumFacture").val(),
                nom_transport: $("#hiddenNomTransport").val(),
                telephone_transport: $("#hiddenTelephoneTransport").val(),
                lignes: [],
            };

            // Collect all product lines (both existing and newly added)
            $("#ligneProduits tr").each(function () {
                // Skip the empty row if present
                if ($(this).find("td").length === 1) return;

                const produitId = $(this).data("id");
                const tva = $(this).data("tva");

                data.lignes.push({
                    reference: reference,
                    produit_id: produitId,
                    quantite: parseFloat($(this).find("td:eq(2)").text()),
                });
            });

            // Send to server
            $.ajax({
                url: "/stage/bonsLivraison/update",
                method: "POST",
                data: data,
                success: function (response) {
                    if (response.success) {
                        alert("Facture mise à jour avec succès !");
                        window.location.href = "/stage/bonsLivraison/show?id=" + factureId + "&success=updated";
                    } else {
                        alert("Erreur lors de la mise à jour : " + (response.message || "Erreur inconnue"));
                    }
                },
                error: function (xhr) {
                    alert("Erreur lors de la mise à jour : " + xhr.responseText);
                }
            }).always(function () {
                btn.prop("disabled", false).text("Enregistrer les modifications");
            });

        });
    });
</script>