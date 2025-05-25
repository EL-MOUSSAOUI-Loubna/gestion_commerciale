<!-- No-print buttons -->
<div class="d-flex justify-content-evenly mb-3 gap-2 no-print">
    <!-- Modifier Button -->
    <a href="/stage/bonsLivraison/edit?id=<?= $bonl['id']; ?>" class="btn btn-primary">Modifier</a>

    <!-- Imprimer Button -->
    <button onclick="printInvoice()" class="btn btn-success">Imprimer</button>
</div>

<!-- Printable invoice content -->
<div class="bonl container bg-white p-4 d-block align-content-between" id="printable-bonl">
    <div class="">
        <div class='d-flex'>
            <img src='/stage/public/assets/img/sellm.png' alt='logo sellm' class="logo me-3"
                style="width: 100px; height: 100px; object-fit: contain;" />
            <div class='mt-1'>
                <h2>SellM</h2>
                <p>adresse : mon adresse</p>
                <p>telephone : 0500000000</p>
            </div>
        </div>
        <div class="d-flex justify-content-between pe-3">
            <div class="mt-5" style="">
                <h3>Destinataire</h3>
                <p>nom : <?= $bonl['nom_ste'] ?></p>
                <p style="max-width: 250px">Adresse : <?= $bonl['adresse'] ?></p>
                <p>telephone : <?= $bonl['telephone'] ?></p>
                <p>email : <?= $bonl['email'] ?></p>
            </div>
            <div class="">
                <p>Facture n : <span class="fw-bold"><?= $bonl['num_facture'] ?></span></p>
                <p>Nom Transporteur : <span class="fw-bold"><?= $bonl['nom_transport'] ?></span></p>
                <p>Tel Transporteur : <span class="fw-bold"><?= $bonl['telephone_transport'] ?></span></p>
                <p>Date d'émission : <span class="fw-bold"><?= $bonl['date_emission'] ?></span></p>
                <p>Date de départ :</p>
                <p>Heure de départ :</p>
            </div>
        </div>
    </div>
    <div class="mt-2 bonl-content">
        <p class="text-center mb-2" style="font-size: 21px;">Bon de Livraison n :
            <span style="font-size: 24px; font-weight: bold; color:rgb(81, 89, 141);"><?= $bonl['num_bonl'] ?></span>
        </p>
        <table class='table table-borderless'>
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Designation</th>
                    <th>Qte</th>
                </tr>
            </thead>
            <>
                <?php foreach ($bonl['lignes'] as $ligne): ?>
                    <tr>
                        <td><?= $ligne['reference'] ?></td>
                        <td><?= $ligne['libelle'] ?></td>
                        <td><?= $ligne['qte'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="signature d-flex justify-content-between">
            <p class="text-center pt-2" style="">signature client :</p>
            <p class="text-center pt-2" style="">signature transporteur :</p>
        </div>
    </div>
    <div class="footer d-flex justify-content-evenly pt-2" id="print-footer">
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
    .bonl {
        width: 800px;
        margin: auto;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        padding: 30px;
    }

    .bonl h2 {
        font-size: 28px;
        color: #333;
    }

    .bonl h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .bonl p {
        margin: 2px 0;
        font-size: 14px;
    }

    .bonl table {
        width: 100%;
        margin-top: 15px;
        font-size: 14px;
    }

    .bonl th {
        background-color: #f0f0f0;
        text-transform: uppercase;
        font-size: 13px;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    .bonl td {
        padding: 6px;
        border-bottom: 1px solid #eee;
    }

    .bonl hr {
        margin: 20px 0;
    }

    .bonl .signature {
        padding: 50px 0 80px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bonl .signature p {
        border: 1px solid #aaa;
        width: 220px;
        padding-bottom: 150px;
    }

    .bonl .footer {
        border-top: 1px solid #ddd;
        margin-top: 10px;
    }

    .bonl .footer p {
        font-size: 12px;
        margin: 2px 0;
    }

    /* Print-specific styles */
    @media print {
        /* Hide everything by default */
        body * {
            visibility: hidden;
        }
        
        /* Then show only the printable element and all its children */
        #printable-bonl, #printable-bonl * {
            visibility: visible;
        }
        
        /* Position the printable element at the top of the page */
        #printable-bonl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
            padding: 15px;
            margin: 0;
        }
        
        /* Table pagination settings */
        table { 
            page-break-inside: auto; 
        }
        
        tr { 
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        thead { 
            display: table-header-group; 
        }
        
        tfoot { 
            display: table-footer-group; 
        }
    }

    @page {
        size: A4;
        margin: 15mm;
    }
</style>

<script>
    // Simplified print function without Paged.js to avoid the error
    function printInvoice() {
        window.print();
    }
</script>