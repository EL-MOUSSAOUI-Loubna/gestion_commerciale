<div class="d-flex justify-content-evenly mb-3 gap-2">
    <!-- Modifier Button -->
    <a href="/factures/edit?id=<?= $facture['id'] ?>" class="btn btn-primary">Modifier</a>
    
    <!-- Imprimer Button -->
    <button onclick="window.print()" class="btn btn-success">Imprimer</button>
</div>


<div class="facture container bg-white p-4 d-block align-content-between">
    <div class="">
        <div class='d-flex'>
            <img src= '/stage/public/assets/img/sellm.png' alt='logo sellm' class="logo me-3" style="width: 100px; height: 100px; object-fit: contain;" /> 
            <h2 class='mt-4'>SellM</h2>
        </div>
        <div class="d-flex justify-content-between">
            <div class="mt-5">
                <h3>facture à l'intention de :</h3>
                <p>nom : <?= $facture['nom_ste'] ?></p>
                <p style="max-width: 250px">adresse : <?= $facture['adresse'] ?></p>
                <p>telephone : <?= $facture['telephone'] ?></p>
                <p>email : <?= $facture['email'] ?></p>
            </div>
            <div >
                <p>facture n : <span style="font-size: 28px; font-weight: bold; color:rgb(81, 89, 141);"><?= $facture['num_facture'] ?></span></p>
                <p>date emission : <?= $facture['date_emission'] ?></p>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <h1 class="text-center mb-2">Facture</h1>
        <table class='table table-borderless'>
            <thead>
                <th>Designation</th>
                <th>Qte</th>
                <th>P.U</th>
                <th>Remise</th>
                <th>HT</th>
                <th>TTC</th>
            </thead>
            <tbody>
                <?php foreach($facture['lignes'] as $ligne): ?>
                <tr>
                    <td><?= $ligne['libelle'] ?></td>
                    <td><?= $ligne['qte'] ?></td>
                    <td><?= $ligne['prix_u'] ?> dh</td>
                    <td><?= $ligne['remise'] ?> %</td>
                    <td><?= $ligne['ht'] ?> dh</td>
                    <td><?= $ligne['ttc'] ?> dh</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <div class="d-flex justify-content-end">
            <div class="me-4">
                <p>Total HT :</p>
                <p>Total TTC :</p>
            </div>
            <div>
                <p><?= $facture['total_ht'] ?> dh</p>
                <p><?= $facture['total_ttc'] ?> dh</p>
            </div>
        </div>
        <div class="signature">
            <p>mode de payement :</p>
            <input type="checkbox" <?php echo in_array('espèce', $facture['modes_pay']) ? 'checked' : ''; ?> disabled> <span class='me-2'>espèce</span>
            <input type="checkbox" <?php echo in_array('chèque', $facture['modes_pay']) ? 'checked' : ''; ?> disabled> <span class='me-2'>chèque</span>
            <input type="checkbox" <?php echo in_array('carte', $facture['modes_pay']) ? 'checked' : ''; ?> disabled> <span class='me-2'>carte</span>
            <input type="checkbox" <?php echo in_array('effet', $facture['modes_pay']) ? 'checked' : ''; ?> disabled> <span class='me-2'>effet</span>
            <input type="checkbox" <?php echo in_array('autre', $facture['modes_pay']) ? 'checked' : ''; ?> disabled> <span>autre</span>
        </div>
    </div>
    <div class="footer d-flex justify-content-evenly pt-2">
        <div class="">
            <p>ice : <?= $facture['ice'] ?></p>
            <p>if : <?= $facture['idf'] ?></p>
        </div>
        <div>
            <p>adresse : notre adresse, Marrakech, Morocco</p>
            <p>telephone : 0500000000</p>
        </div>
        <div>
            <p>email : contact@sellm.ma</p>
            <p>siteweb : w.sellm.ma</p>
        </div>
    </div>
</div>

<style>
    .facture {
        width: 800px;
        margin: auto;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        padding: 30px;
    }

    .facture h2 {
        font-size: 28px;
        color: #333;
    }

    .facture h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .facture p {
        margin: 2px 0;
        font-size: 14px;
    }

    .facture table {
        width: 100%;
        margin-top: 15px;
        font-size: 14px;
    }

    .facture th {
        background-color: #f0f0f0;
        text-transform: uppercase;
        font-size: 13px;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    .facture td {
        padding: 6px;
        border-bottom: 1px solid #eee;
    }

    .facture hr {
        margin: 20px 0;
    }

    .facture .signature {
        height: 100px;
    }

    .facture .footer {
        border-top: 1px solid #ddd;
        margin-top: 80px;
    }

    .facture .footer p {
        font-size: 12px;
        margin: 2px 0;
    }
</style>
