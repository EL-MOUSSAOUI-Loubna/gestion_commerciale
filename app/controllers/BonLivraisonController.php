<?php
require_once MODEL_PATH . '/BonLivraisonModel.php';

class BonLivraisonController
{
    private $bonLivraisonModel;

    public function __construct($db)
    {
        $this->bonLivraisonModel = new BonLivraisonModel($db);
    }

    public function index()
    {
        $factures = $this->bonLivraisonModel->getBonsL();
        $content_view = 'pages/factures/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function create()
    {
        $clients = $this->bonLivraisonModel->getClients();
        $produits = $this->bonLivraisonModel->getProduits();
        $content_view = 'pages/bonsLivraison/add';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid JSON data: ' . json_last_error_msg()
            ]);
            return;
        }
        if (
            !isset($data['client_id']) || !isset($data['date_emission']) || !isset($data['num_facture']) ||
            !isset($data['lignes'])
        ) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing required fields'
            ]);
            return;
        }

        $clientId = $data['client_id'];
        $date_emission = $data['date_emission'];
        $num_facture = $data['num_facture'];
        $lignes = $data['lignes'];

        $resultat = $this->bonLivraisonModel->addBonL(
            $clientId,
            $date_emission,
            $num_facture,
            $lignes,
        );

        if ($resultat) {
            echo json_encode(['success' => true, 'facture_id' => $resultat]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database insert failed']);
            //header('Location: /stage/factures/add?error=create_failed');
        }
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $facture = $this->bonLivraisonModel->getBonLById($id);
        $clients = $this->bonLivraisonModel->getClients();
        $produits = $this->bonLivraisonModel->getProduits();
        $content_view = 'pages/factures/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function update()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
            http_response_code(400);
            echo "Cette action nécessite une requête AJAX";
            return;
        }

        try {
            $facture_id = $_POST['facture_id'] ?? null;
            $client_id = $_POST['client_id'] ?? null;
            $date_emission = $_POST['date_emission'] ?? null;
            $total_ht = $_POST['total_ht'] ?? 0;
            $total_ttc = $_POST['total_ttc'] ?? 0;
            $modes_paiement = $_POST['modes_paiement'] ?? '';
            $lignes = $_POST['lignes'] ?? [];

            if (!$facture_id || !$client_id || !$date_emission || empty($lignes)) {
                throw new Exception("Données incomplètes pour la facture");
            }

            $factureData = [
                'id' => $facture_id,
                'client_id' => $client_id,
                'date_emission' => $date_emission,
                'total_ht' => $total_ht,
                'total_ttc' => $total_ttc,
                'modes_paiement' => $modes_paiement
            ];

            $this->bonLivraisonModel->updateBonL($factureData, $lignes);

            header('Content-Type: application/json');
            echo json_encode(['success' => true]);

        } catch (Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function delete()
    {
        $success = $this->bonLivraisonModel->deleteBonL($_POST['id']);
        if ($success) {
            header('Location: /stage/factures?success=deleted');
        } else {
            header('Location: /stage/factures?error=delete_failed');
        }
    }

    public function show()
    {
        $facture = $this->bonLivraisonModel->getBonLById($_GET['id']);
        $content_view = 'pages/factures/show';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function saveLine()
    {
        $produit = $this->bonLivraisonModel->getProduitById($_POST['produit_id']);
        $qte = intval($_POST['quantite']);
        

        echo json_encode([
            'produit_id' => $_POST['produit_id'],
            'reference' => $produit['reference'],
            'libelle' => $produit['libelle'],
            'qte' => $qte,
        ]);
    }

    public function checkFacture() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_facture'])) {
            $num = trim($_POST['num_facture']);
            $id = $this->bonLivraisonModel->checkNumFacture($num);
            $exists = $id ? true : false;
    
            echo json_encode(['exists' => $exists, 'facture_id' => $id]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Requête invalide']);
        }
    }
    
}