<div class="d-flex justify-content-evenly mb-3 gap-2 no-print">
    <!-- Modifier Button -->
    <a href="/factures/edit?id=<?= $facture['id'] ?>" class="btn btn-primary">Modifier</a>
    
    <!-- Imprimer Button -->
    <button onclick="window.print()" class="btn btn-success">Imprimer</button>
</div>


<div class="facture container bg-white p-4 d-block align-content-between" id="printable-invoice">
    <div class="">
        <div class='d-flex'>
            <img src= '/stage/public/assets/img/sellm.png' alt='logo sellm' class="logo me-3" style="width: 100px; height: 100px; object-fit: contain;" /> 
            <div class='mt-1'>
                <h2 >SellM</h2>
                <p>adresse :</p>
                <p>telephone :</p>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="mt-5">
                <h3>Destinataire :</h3>
                <p>nom : nom</p>
                <p style="max-width: 250px">adresse : adresse</p>
                <p>telephone : tel</p>
                <p>email : email</p>
            </div>
            <div>
                <div>
                    <p>Bon de Livraison N : <span style="font-size: 25px; font-weight: bold; color:rgb(81, 89, 141);">BON-2025-0012</span></p>
                    <p>Date de départ : </p>
                    <p>Heure de départ : </p>
                </div>
                <div class="text-end">
                    <p>Nom du Transporteur : nom</p>
                    <p>Tel du Transporteur : 050000000</p>
                    <p>Nom du Transporteur : nom</p>
                </div>
            </div>
        </div>
    </div>
    <?php
    // Example data
    $rows = [];
    for ($i = 1; $i <= 10; $i++) {
        $rows[] = [
            'id' => $i,
            'name' => 'Item ' . $i,
            'description' => 'Description of item ' . $i
        ];
    }
    ?>
    <div class="mt-2 invoice-content">
        <h2 class="text-center mb-2">Bon de Livraison</h2>
        <table class='table table-borderless'>
            <thead>
                <tr>
                    <th>Designation</th>
                    <th>Reference</th>
                    <th>Qte</th>
                </tr>
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

                <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <div class="signature d-flex justify-content-between mt-5">
            <p class=" text-center pt-2" style="">signature client :</p>
            <p class=" text-center pt-2" style="">signature transporteur :</p>
        </div>
    </div>
    <div class="footer d-flex justify-content-evenly pt-2">
        <div class="">
            <p>ice : 000222111555</p>
            <p>if : 369874521</p>
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
    /* Regular styles for screen display */
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
        border: 1px solid #aaa;
        width: 220px; 
        padding-bottom: 150px;
    }

    .facture .footer {
        border-top: 1px solid #ddd;
        margin-top: 10px;
    }

    .facture .footer p {
        font-size: 12px;
        margin: 2px 0;
    }
    
</style>