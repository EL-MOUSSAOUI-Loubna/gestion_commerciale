<?php
class CategorieModel {
    public $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getCategoryTree($parentId = null) {
        try {
            $query = "SELECT * FROM categories WHERE parent_id " 
                   . ($parentId ? "= ?" : "IS NULL") ;
            $stmt = $this->db->prepare($query);
            $stmt->execute($parentId ? [$parentId] : []);
            
            $tree = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['children'] = $this->getCategoryTree($row['id']);
                $tree[] = $row;
            }
            return $tree;
        } catch (PDOException $e) {
            error_log("Category tree error: " . $e->getMessage());
            return [];
        }
    }

    public function getCategoryById ($id){
        try {
            $query = "SELECT * FROM categories WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Category by ID error: " . $e->getMessage());
            return null;
        }
    }

    public function addCategory($categorie, $categorie_parente) {
        try {
            $parente_id = $categorie_parente ? $categorie_parente : null;
            $query = "INSERT INTO categories (nom, parent_id) VALUES (:categorie, :categorie_parente)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'categorie' => $categorie,
                'categorie_parente' => $parente_id,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateCategory ($id, $categorie, $categorie_parente) {
        try {
            $query = "UPDATE categories SET 
                        nom = :categorie, parent_id = :categorie_parente
                        WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id'    => $id,
                'categorie' => $categorie,
                'categorie_parente' => $categorie_parente,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteCategory($id) {
        try {
            $this->db->beginTransaction();
            
            $this->deleteChildCategories($id);
            
            $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
            $success = $stmt->execute(['id' => $id]);
            
            $this->db->commit();
            return $success;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }
    private function deleteChildCategories($parentId) {
        $stmt = $this->db->prepare("SELECT id FROM categories WHERE parent_id = :parent_id");
        $stmt->execute(['parent_id' => $parentId]);
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->deleteChildCategories($row['id']);
            $delStmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
            $delStmt->execute(['id' => $row['id']]);
        }
    }

    public function renameCategory ($id, $newName) {
        try {
            $query = "UPDATE categories SET nom = :new_name WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id'    => $id,
                'new_name' => $newName,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getProductsOfCategory ($id) {
        try {
            $query = "SELECT id, libelle, reference, prix_u FROM produits WHERE categorie_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}