<div class='add_facture'>
<!-- Bootstrap modal -->
<div id="clientModal">
  <div class="modal-dialog">
    <form id="initForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title mb-4">Sélectionner le Client et la Date d'émission</h5>
      </div>
      <div class="modal-body">
        <select class="form-select" name="client_id" required>
          <option disabled selected>-- Choisir un client --</option>
          <?php foreach ($clients as $client): ?>
            <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['nom_ste']) ?></option>
          <?php endforeach; ?>
        </select>
        <input type="date" name="date_emission" class="form-control mt-3" value="<?= date('Y-m-d') ?>" required>
      </div>
      <div class="modal-footer mt-4">
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
    <input type="number" name="remise" class="form-control" placeholder="Remise (%)" min="0" max="100" value="0">
    <button type="submit" class="btn btn-success">Ajouter Produit</button>
  </form>

  <!-- Info client/date -->
  <div id="clientInfo" class="mb-2 fw-bold"></div>

  <!-- Tableau produits -->
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Produit</th><th>Qte</th><th>Prix U</th><th>Remise</th><th>HT</th><th>TTC</th>
      </tr>
    </thead>
    <tbody id="ligneProduits"></tbody>
  </table>

  <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <div class="payment-methods">
        <label class="fw-bold mb-2">Mode de paiement:</label>
        <div class="d-flex flex-wrap gap-3 mt-1">
            <div class="form-check">
                <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox" id="paiement-espece" value="espèce">
                <label class="form-check-label" for="paiement-espece">Espèce</label>
            </div>
            <div class="form-check">
                <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox" id="paiement-cheque" value="chèque">
                <label class="form-check-label" for="paiement-cheque">Chèque</label>
            </div>
            <div class="form-check">
                <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox" id="paiement-carte" value="carte">
                <label class="form-check-label" for="paiement-carte">Carte</label>
            </div>
            <div class="form-check">
                <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox" id="paiement-effet" value="effet">
                <label class="form-check-label" for="paiement-effet">Effet</label>
            </div>
            <div class="form-check">
                <input class="form-check-input payment-method-checkbox border-secondary" type="checkbox" id="paiement-autre" value="autre"">
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

  <!-- Bouton enregistrer -->
    <input type="hidden" id="hiddenClientId">
    <input type="hidden" id="hiddenDateFacture">

    <button id="enregistrerBtn" class="btn btn-primary" type="button">Enregistrer la facture</button>
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
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
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

  .add_facture .payment-methods {
    border-radius: 0.25rem;
    padding: 0.5rem 0;
    }
    .add_facture .form-check {
        margin-right: 0.5rem;
    }
</style>