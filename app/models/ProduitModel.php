<?php
class ProduitModel {
    public $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getProduits() {
        try {
            $query = "SELECT p.*, c.nom AS nom_categorie FROM produits p LEFT JOIN categories c ON p.categorie_id = c.id";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getProduitById($id) {
        try {
            $query = "SELECT * FROM produits WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function addProduit($libelle, $reference, $description_p, $prix_u, $ttva, $qte_alerte, $categorie_id, $fournisseur_id) {
        try {
            $query = "INSERT INTO produits (libelle, reference, description_p, prix_u, ttva, qte_alerte, categorie_id, fournisseur_id) 
                      VALUES (:libelle, :reference, :description_p, :prix_u, :ttva, :qte_alerte, :categorie_id, :fournisseur_id)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'libelle'    => $libelle,
                'reference'  => $reference,
                'description_p'        => $description_p,
                'prix_u'    => $prix_u,
                'ttva'  => $ttva,
                'qte_alerte' => $qte_alerte,
                'categorie_id' => $categorie_id,
                'fournisseur_id' => $fournisseur_id,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateProduit($id, $libelle, $reference, $description_p, $prix_u, $ttva, $qte_alerte, $categorie_id, $fournisseur_id) {
        try {
            $query = "UPDATE produits SET 
                        libelle = :libelle, reference = :reference, description_p = :description_p, 
                        prix_u = :prix_u, ttva = :ttva, qte_alerte = :qte_alerte,
                        categorie_id = :categorie_id, fournisseur_id = :fournisseur_id
                        WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id'    => $id,
                'libelle'    => $libelle,
                'reference'  => $reference,
                'description_p'        => $description_p,
                'prix_u'    => $prix_u,
                'ttva'  => $ttva,
                'qte_alerte' => $qte_alerte,
                'categorie_id' => $categorie_id,
                'fournisseur_id' => $fournisseur_id,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduit($id) {
        try {
            $query = "DELETE FROM produits WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getCategories (){
        try {
            $query = "SELECT * FROM categories";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getFournisseurs (){
        try {
            $query = "SELECT * FROM fournisseurs";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
    public function getCategoryOfProduct ($id){
        try {
            $query = "SELECT c.nom FROM categories c INNER JOIN produits p ON c.id = p.categorie_id WHERE p.id = :id ";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getFournisseurOfProduct ($id){
        try {
            $query = "SELECT f.nom_ste FROM fournisseurs f INNER JOIN produits p ON f.id = p.fournisseur_id WHERE p.id = :id ";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

}