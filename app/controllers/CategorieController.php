<?php
require_once MODEL_PATH . '/CategorieModel.php';

class CategorieController {
    private $categorieModel;

    public function __construct($db) {
        $this->categorieModel = new CategorieModel($db);
    }

    public function index() {
        $categories = $this->categorieModel->getCategoryTree();
        $content_view = 'pages/categories/index';
        include VIEW_PATH . '/layouts/main.php';    
    }

    public function store() {
        $success = $this->categorieModel->addCategory(
            $_POST['categorie'] ?? '',
            $_POST['categorie_parente'] === '' ? null : $_POST['categorie_parente'],
        );

        if ($success) {
            header('Location: /stage/categories?success=created');
        } else {
            header('Location: /stage/categories?error=create_failed');
        }
    }

    public function edit ($id) {
        $categorie = $this->categorieModel->getCategoryById($id);
        $content_view = 'pages/categories/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function update() {
        $success = $this->categorieModel->updateCategory(
            $_POST['id'],
            $_POST['categorie'] ?? '',
            $_POST['categorie_parente'] === '' ? null : $_POST['categorie_parente'],
        );
        if ($success) {
            header('Location: /stage/categories?success=updated');
        } else {
            header('Location: /stage/categories?id='.$_POST['id'].'&error=update_failed');
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        
        try {
            error_log('Received token: ' . ($_POST['csrf_token'] ?? 'NULL'));
            error_log('Session token: ' . ($_SESSION['csrf_token'] ?? 'NULL'));
            // 1. Verify CSRF
            if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                throw new Exception('Invalid CSRF token', 403);
            }
    
            // 2. Validate ID
            $id = $_POST['id'] ?? null;
            if (!$id || !is_numeric($id)) {
                throw new Exception('Invalid category ID', 400);
            }
    
            // 3. Delete from database
            if (!$this->categorieModel->deleteCategory($id)) {
                throw new Exception('Database deletion failed', 500);
            }
    
            echo json_encode(['success' => true]);
            
        } catch (Exception $e) {
            http_response_code($e->getCode() ?: 500);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}