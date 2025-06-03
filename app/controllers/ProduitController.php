<?php
require_once MODEL_PATH . '/ProduitModel.php';

class ProduitController {
    private $produitModel;
    
    public function __construct($db) {
        $this->produitModel = new ProduitModel($db);
    }

    public function index() {
        $produits = $this->produitModel->getProduits();
        $content_view = 'pages/produits/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function create() {
        $categories = $this->produitModel->getCategories();
        $fournisseurs = $this->produitModel->getFournisseurs();
        $content_view = 'pages/produits/add';
        include VIEW_PATH . '/layouts/main.php';
    }

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
            header('Location: /sggi/produits?success=created');
        } else {
            header('Location: /sggi/produits/add?error=create_failed');
        }
    }

    public function edit() {
        $produit = $this->produitModel->getProduitById($_GET['id']);
        $categories = $this->produitModel->getCategories();
        $fournisseurs = $this->produitModel->getFournisseurs();
        $content_view = 'pages/produits/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

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
            header('Location: /sggi/produits?success=updated');
        } else {
            header('Location: /sggi/produits/edit?id='.$_POST['id'].'&error=update_failed');
        }
    }

    public function delete() {
        $success = $this->produitModel->deleteProduit($_POST['id']);
        if ($success) {
            header('Location: /sggi/produits?success=deleted');
        } else {
            header('Location: /sggi/produits?error=delete_failed');
        }
    }

    public function show() {
        $produit = $this->produitModel->getProduitById($_GET['id']);
        $category = $this->produitModel->getCategoryOfProduct($_GET['id']);
        $fournisseur = $this->produitModel->getFournisseurOfProduct($_GET['id']);
        $content_view = 'pages/produits/show';
        include VIEW_PATH . '/layouts/main.php';
    }
}
