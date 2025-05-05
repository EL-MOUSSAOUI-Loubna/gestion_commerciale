<?php
require_once MODEL_PATH . '/ProduitModel.php';

class ProduitController {
    private $produitModel;
    
    public function __construct($db) {
        $this->produitModel = new ProduitModel($db);
    }

    // List all clients
    public function index() {
        $produits = $this->produitModel->getProduits();
        $content_view = 'pages/produits/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Show create form
    public function create() {
        $content_view = 'pages/produits/add';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Store new client (POST)
    public function store() {
        $success = $this->produitModel->addProduit(
            $_POST['libelle'] ?? '',
            $_POST['reference'] ?? '',
            $_POST['description_p'] ?? '',
            $_POST['prix_u'] ?? '',
            $_POST['ttva'] ?? '',
            $_POST['categorie'] ?? '',
            $_POST['fournisseur'] ?? '',
        );
        if ($success) {
            header('Location: /stage/produits?success=created');
        } else {
            header('Location: /stage/produits/add?error=create_failed');
        }
    }

    // Show edit form
    public function edit() {
        $produit = $this->produitModel->getProduitById($_GET['id']);
        $content_view = 'pages/produits/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Update client (POST)
    public function update() {
        $success = $this->produitModel->updateProduit(
            $_POST['id'],
            $_POST['libelle'],
            $_POST['reference'] ?? '',
            $_POST['description_p'] ?? '',
            $_POST['prix_u'] ?? '',
            $_POST['ttva'] ?? '',
            $_POST['categorie'] ?? '',
            $_POST['fournisseur'] ?? '',
        );
        if ($success) {
            header('Location: /stage/produits?success=updated');
        } else {
            header('Location: /stage/produits/edit?id='.$_POST['id'].'&error=update_failed');
        }
    }

    // Delete client (POST)
    public function delete() {
        $success = $this->produitModel->deleteProduit($_POST['id']);
        if ($success) {
            header('Location: /stage/produits?success=deleted');
        } else {
            header('Location: /stage/produits?error=delete_failed');
        }
    }

    // Show single client
    public function show() {
        $produit = $this->produitModel->getProduitById($_GET['id']);
        $content_view = 'pages/produits/show';
        include VIEW_PATH . '/layouts/main.php';
    }
}
