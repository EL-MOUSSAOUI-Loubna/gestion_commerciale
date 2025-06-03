<?php
require_once MODEL_PATH . '/FournisseurModel.php';

class FournisseurController {
    private $fournisseurModel;
    
    public function __construct($db) {
        $this->fournisseurModel = new FournisseurModel($db);
    }

    // List all clients
    public function index() {
        $fournisseurs = $this->fournisseurModel->getFournisseurs();
        $content_view = 'pages/fournisseurs/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Show create form
    public function create() {
        $content_view = 'pages/fournisseurs/add';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Store new client (POST)
    public function store() {
        $success = $this->fournisseurModel->addFournisseur(
            $_POST['nom_ste'] ?? '',
            $_POST['ice'] ?? '',
            $_POST['idf'] ?? '',
            $_POST['adresse'] ?? '',
            $_POST['email'] ?? '',
            $_POST['telephone'] ?? '',
        );
        if ($success) {
            header('Location: /sggi/fournisseurs?success=created');
        } else {
            header('Location: /sggi/fournisseurs/add?error=create_failed');
        }
    }

    // Show edit form
    public function edit() {
        $fournisseur = $this->fournisseurModel->getFournisseurById($_GET['id']);
        $content_view = 'pages/fournisseurs/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Update client (POST)
    public function update() {
        $success = $this->fournisseurModel->updateFournisseur(
            $_POST['id'],
            $_POST['nom_ste'] ?? '',
            $_POST['ice'] ?? '',
            $_POST['idf'] ?? '',
            $_POST['adresse'] ?? '',
            $_POST['email'] ?? '',
            $_POST['telephone'] ?? '',
        );
        if ($success) {
            header('Location: /sggi/fournisseurs?success=updated');
        } else {
            header('Location: /sggi/fournisseurs/edit?id='.$_POST['id'].'&error=update_failed');
        }
    }

    // Delete client (POST)
    public function delete() {
        $success = $this->fournisseurModel->deleteFournisseur($_POST['id']);
        if ($success) {
            header('Location: /sggi/fournisseurs?success=deleted');
        } else {
            header('Location: /sggi/fournisseurs?error=delete_failed');
        }
    }

    // Show single client
    public function show() {
        $fournisseur = $this->fournisseurModel->getFournisseurById($_GET['id']);
        $content_view = 'pages/fournisseurs/show';
        include VIEW_PATH . '/layouts/main.php';
    }
}
