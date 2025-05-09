<?php
require_once MODEL_PATH . '/CategorieModel.php';

class CategorieController
{
    private $categorieModel;

    public function __construct($db)
    {
        $this->categorieModel = new CategorieModel($db);
    }

    public function index()
    {
        $categories = $this->categorieModel->getCategoryTree();
        $content_view = 'pages/categories/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function store() {
        $success = $this->categorieModel->addCategory(
            $_POST['categoryName'] ?? '',
            $_POST['parentCategory'] ?? '',
        );
        if ($success) {
            header('Location: /stage/categories?success=created');
        } else {
            header('Location: /stage/categories?error=create_failed');
        }
    }

    /*public function edit($id)
    {
        $categorie = $this->categorieModel->getCategoryById($id);
        $content_view = 'pages/categories/index';
        include VIEW_PATH . '/layouts/main.php';
    }*/

    /*public function update()
    {
        $success = $this->categorieModel->updateCategory(
            $_POST['id'],
            $_POST['categorie'] ?? '',
            $_POST['categorie_parente'] === '' ? null : $_POST['categorie_parente'],
        );
        if ($success) {
            header('Location: /stage/categories?success=updated');
        } else {
            header('Location: /stage/categories?id=' . $_POST['id'] . '&error=update_failed');
        }
    }*/

    public function delete() {
        $success = $this->categorieModel->deleteCategory($_POST['id']);
        if ($success) {
            header('Location: /stage/categories?success=deleted');
        } else {
            header('Location: /stage/categories?error=delete_failed');
        }
    }

    public function rename(){
        $success = $this->categorieModel->renameCategory($_POST['id'], $_POST['categoryName']);
        if ($success) {
            header('Location: /stage/categories?success=renamed');
        } else {
            header('Location: /stage/categories?error=rename_failed');
        }
    }

    public function show() {
        $category = $this->categorieModel->getCategoryById($_GET['id']);
        $produits = $this->categorieModel->getProductsOfCategory($_GET['id']);
        $content_view = 'pages/categories/show';
        include VIEW_PATH . '/layouts/main.php';
    }
}