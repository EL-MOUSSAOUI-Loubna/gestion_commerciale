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
        $bonsl = $this->bonLivraisonModel->getBonsL();
        $content_view = 'pages/bonslivraison/index';
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
        if (!isset($data['client_id']) || !isset($data['date_emission']) || !isset($data['facture_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Données incomplètes'
            ]);
            return;
        }

        if (!is_array($data['lignes']) || count($data['lignes']) === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Pas de produit selectionné'
            ]);
            return;
        }

        $clientId = $data['client_id'];
        $date_emission = $data['date_emission'];
        $facture_id = $data['facture_id'];
        $nom_transport = $data['nom_transporteur'] ?? '';
        $telephone_transport = $data['telephone_transporteur'] ?? '';
        $lignes = $data['lignes'];

        $bl_id = $this->bonLivraisonModel->addBonL(
            $clientId,
            $date_emission,
            $facture_id,
            $nom_transport,
            $telephone_transport,
            $lignes
        );

        if ($bl_id) {
            echo json_encode(['success' => true, 'bl_id' => $bl_id]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database insert failed']);
            //header('Location: /stage/factures/add?error=create_failed');
        }
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $bonl = $this->bonLivraisonModel->getBonLById($id);
        $clients = $this->bonLivraisonModel->getClients();
        $produits = $this->bonLivraisonModel->getProduits();
        $content_view = 'pages/bonsLivraison/edit';
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
            $num_facture = $_POST['num_facture'] ?? null;
            $bonl_id = $_POST['bl_id'] ?? null;
            $client_id = $_POST['client_id'] ?? null;
            $date_emission = $_POST['date_emission'] ?? null;
            $nom_transport = $_POST['nom_transport'] ?? null;
            $telephone_transport = $_POST['telephone_transport'] ?? null;
            $lignes = $_POST['lignes'] ?? [];

            $facture_id = $this->bonLivraisonModel->getFactureId($num_facture);


            if (!$bonl_id || !$num_facture || !$client_id || !$date_emission || empty($lignes)) {
                throw new Exception("Données incomplètes");
            }

            $bonlData = [
                'id' => $bonl_id,
                'facture_id' => $facture_id,
                'client_id' => $client_id,
                'date_emission' => $date_emission,
                'nom_transport' => $nom_transport,
                'telephone_transport' => $telephone_transport
            ];

            $this->bonLivraisonModel->updateBonL($bonlData, $lignes);

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
            header('Location: /stage/bonsLivraison?success=deleted');
        } else {
            header('Location: /stage/bonsLivraison?error=delete_failed');
        }
    }

    public function show()
    {
        $bonl = $this->bonLivraisonModel->getBonLById($_GET['id']);
        $content_view = 'pages/bonsLivraison/show';
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
            $id = $this->bonLivraisonModel->getFactureId($num);
            $exists = $id ? true : false;
    
            echo json_encode(['exists' => $exists, 'facture_id' => $id]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Requête invalide']);
        }
    }
    
}