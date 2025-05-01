<!-- Bootstrap modal -->
<div class="modal show" id="clientModal" tabindex="-1" style="display: block;" aria-hidden="true">
  <div class="modal-dialog">
    <form id="initForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sélectionner Client et Date</h5>
      </div>
      <div class="modal-body">
        <select class="form-select" name="client_id" required>
          <option disabled selected>-- Choisir un client --</option>
          <?php foreach ($clients as $client): ?>
            <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['nom_ste']) ?></option>
          <?php endforeach; ?>
        </select>
        <input type="date" name="date_facture" class="form-control mt-3" value="<?= date('Y-m-d') ?>" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Sélectionner</button>
      </div>
    </form>
  </div>
</div>

<div id="facturePage" style="display:none;">
  <!-- Formulaire produit -->
  <form id="produitForm" class="d-flex gap-2 mb-3">
    <select class="form-select" name="produit_id" required>
      <?php foreach ($produits as $p): ?>
        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['libelle']) ?></option>
      <?php endforeach; ?>
    </select>
    <input type="number" name="quantite" class="form-control" placeholder="Quantité" min="1" required>
    <input type="number" name="remise" class="form-control" placeholder="Remise (%)" min="0" max="100">
    <button type="submit" class="btn btn-success">Ajouter Produit</button>
  </form>

  <!-- Info client/date -->
  <div id="clientInfo" class="mb-2 fw-bold"></div>

  <!-- Tableau produits -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Produit</th><th>Qte</th><th>Prix U</th><th>HT</th><th>Remise</th><th>TTC</th>
      </tr>
    </thead>
    <tbody id="ligneProduits"></tbody>
  </table>

  <!-- Bouton enregistrer -->
  <button class="btn btn-primary">Enregistrer la facture</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  let clientNom = '';
  let factureDate = '';

  $("#initForm").on("submit", function(e) {
    e.preventDefault();
    clientNom = $("select[name='client_id'] option:selected").text();
    factureDate = $("input[name='date_facture']").val();

    $("#clientInfo").html(`Client : ${clientNom} | Date : ${factureDate}`);
    $("#clientModal").hide();
    $("#facturePage").show();
  });

  $("#produitForm").on("submit", function(e) {
  e.preventDefault();
  $.ajax({
    url: "/stage/factures/saveLine", // make sure this matches your folder
    method: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function(res) {
      let row = `<tr>
        <td>${res.libelle}</td>
        <td>${res.qte}</td>
        <td>${res.prix_u} €</td>
        <td>${res.ht} €</td>
        <td>${parseFloat(res.remise).toFixed(2)} €</td>
        <td>${res.ttc} €</td>
      </tr>`;
      $("#ligneProduits").append(row);
    },
    error: function(xhr) {
      alert("Erreur lors de l'ajout du produit : " + xhr.responseText);
    }
  });
});

</script>
