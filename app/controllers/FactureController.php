<?php
require_once MODEL_PATH . '/FactureModel.php';

class FactureController {
    private $factureModel;
    
    public function __construct($db) {
        $this->factureModel = new FactureModel($db);
    }

    // List all clients
    public function index() {
        $factures = $this->factureModel->getFactures();
        $content_view = 'pages/factures/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Show create form
    public function create() {
        $clients = $this->factureModel->getClients();
        $produits = $this->factureModel->getProduits();
        $content_view = 'pages/factures/add';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Store new client (POST)
    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                'success' => false, 
                'message' => 'Invalid JSON data: ' . json_last_error_msg()
            ]);
            return;
        }
        // Validate required fields
        if (!isset($data['client_id']) || !isset($data['date_emission']) || !isset($data['lignes']) || 
            !isset($data['total_ht']) || !isset($data['total_ttc'])) {
            echo json_encode([
                'success' => false, 
                'message' => 'Missing required fields'
            ]);
            return;
        }

        $clientId = $data['client_id'];
        $date_emission = $data['date_emission'];
        $lignes = $data['lignes'];
        $total_ht = $data['total_ht'];
        $total_ttc = $data['total_ttc'];
        $modes_paiement = isset($data['modes_paiement']) ? $data['modes_paiement'] : '';
        
        $resultat = $this->factureModel->addFacture($clientId, $date_emission, $lignes,
         $total_ht, $total_ttc, $modes_paiement);

        if ($resultat) {
            echo json_encode(['success' => true, 'facture_id' => $resultat]);
            // Don't use header() redirect here since this is an AJAX call
            // The client-side JS will handle the redirect if needed
            //header('Location: /stage/factures?success=created');
        } else {
            echo json_encode(['success' => false, 'error' => 'Database insert failed']);
            //header('Location: /stage/factures/add?error=create_failed');
        }
    }

    // Show edit form
    public function edit() {
        $facture = $this->factureModel->getFactureById($_GET['id']);
        $content_view = 'pages/factures/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Update client (POST)
    public function update() {
        $success = $this->factureModel->updateFacture(
        );
        if ($success) {
            header('Location: /stage/factures?success=updated');
        } else {
            header('Location: /stage/clients/factures?id='.$_POST['id'].'&error=update_failed');
        }
    }

    // Delete client (POST)
    public function delete() {
        $success = $this->factureModel->deleteFacture($_POST['id']);
        if ($success) {
            header('Location: /stage/factures?success=deleted');
        } else {
            header('Location: /stage/factures?error=delete_failed');
        }
    }

    // Show single client
    public function show() {
        $facture = $this->factureModel->getFactureById($_GET['id']);
        $content_view = 'pages/factures/show';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function saveLine() {
        $produit = $this->factureModel->getProduitById($_POST['produit_id']);
        $qte = intval($_POST['quantite']);
        $remise = intval($_POST['remise']);

        $pu_remise = $produit['prix_u'] * (1 - $remise / 100);
        $ht = $pu_remise * $qte;
        $tva_val = $ht * ($produit['ttva'] / 100);
        $ttc = $ht + $tva_val;
        //$remise_val = $ht * ($remise / 100);
        //$ht_remise = $ht - $remise_val;
        //$ttc = $ht_remise * (1 + $produit['ttva'] / 100);

        echo json_encode([
            'produit_id' => $_POST['produit_id'],
            'libelle' => $produit['libelle'],
            'qte' => $qte,
            'prix_u' => $produit['prix_u'],
            'ttva' => $produit['ttva'],
            'ht' => round($ht, 2),
            'remise' => $remise,
            'ttc' => round($ttc, 2)
        ]);
    }
}