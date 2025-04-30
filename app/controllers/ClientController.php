<?php
require_once MODEL_PATH . '/ClientModel.php';

class ClientController {
    private $clientModel;
    
    public function __construct($db) {
        $this->clientModel = new ClientModel($db);
    }

    // List all clients
    public function index() {
        $clients = $this->clientModel->getClients();
        $content_view = 'pages/clients/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Show create form
    public function create() {
        $content_view = 'pages/clients/add';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Store new client (POST)
    public function store() {
        $success = $this->clientModel->addClient(
            $_POST['nom_ste'] ?? '',
            $_POST['ice'] ?? '',
            $_POST['idf'] ?? '',
            $_POST['adresse'] ?? '',
            $_POST['email'] ?? '',
            $_POST['telephone'] ?? '',
            $_POST['logo'] ?? ''
        );
        if ($success) {
            header('Location: /stage/clients?success=created');
        } else {
            header('Location: /stage/clients/add?error=create_failed');
        }
    }

    // Show edit form
    public function edit() {
        $client = $this->clientModel->getClientById($_GET['id']);
        $content_view = 'pages/clients/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

    // Update client (POST)
    public function update() {
        $success = $this->clientModel->updateClient(
            $$_POST['id'],
            $_POST['nom_ste'] ?? '',
            $_POST['ice'] ?? '',
            $_POST['idf'] ?? '',
            $_POST['adresse'] ?? '',
            $_POST['email'] ?? '',
            $_POST['telephone'] ?? '',
            $_POST['logo'] ?? ''
        );
        if ($success) {
            header('Location: /stage/clients?success=updated');
        } else {
            header('Location: /stage/clients/edit?id='.$_POST['id'].'&error=update_failed');
        }
    }

    // Delete client (POST)
    public function delete() {
        $success = $this->clientModel->deleteClient($_POST['id']);
        if ($success) {
            header('Location: /stage/clients?success=deleted');
        } else {
            header('Location: /stage/clients?error=delete_failed');
        }
    }

    // Show single client
    public function show() {
        $client = $this->clientModel->getClientById($_GET['id']);
        $content_view = 'pages/clients/show';
        include VIEW_PATH . '/layouts/main.php';
    }
}

/*class ClientController {
    private $clientModel;

    public function __construct($dbConnection) {
        $this->clientModel = new ClientModel($dbConnection);
    }

    public function index() {
        $clients = $this->clientModel->getClients();
        $content_view = 'pages/clients/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function create() {
        $content_view = 'pages/clients/add';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->clientModel->addClient(
                $_POST['nom_ste'] ?? '',
                $_POST['ice'] ?? '',
                $_POST['if'] ?? '',
                $_POST['adresse'] ?? '',
                $_POST['email'] ?? '',
                $_POST['telephone'] ?? '',
                $_POST['logo'] ?? ''
            );
            header('Location: /clients' . ($success ? '?added' : '?error'));
            exit;
        }
        $this->create(); // Fallback to form if not POST
    }

    public function edit($id) {
        $client = $this->clientModel->getClientById($id);
        if (!$client) {
            header('Location: /clients?not_found');
            exit;
        }
        $content_view = 'pages/clients/edit';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->clientModel->updateClient(
                $id,
                $_POST['nom_ste'] ?? '',
                $_POST['ice'] ?? '',
                $_POST['if'] ?? '',
                $_POST['adresse'] ?? '',
                $_POST['email'] ?? '',
                $_POST['telephone'] ?? '',
                $_POST['logo'] ?? ''
            );
            header('Location: /clients/edit?id=' . $id . ($success ? '&updated' : '&error'));
            exit;
        }
        $this->edit($id); // Fallback to form if not POST
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $success = $this->clientModel->deleteClient($_POST['id']);
            
            header('Location: /clients' . ($success ? '?deleted' : '?error'));
            exit;
        }
        $this->index(); // Fallback to list if not POST
    }
    
}*/