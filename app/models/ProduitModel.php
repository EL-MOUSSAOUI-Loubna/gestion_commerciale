<?php
class ProduitModel {
    public $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getProduits() {
        try {
            $query = "SELECT * FROM produits";
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

    public function addProduit($libelle, $reference, $description_p, $prix_u, $qte, $ttva, $u_mesure, $categorie, $fournisseur, $image_p) {
        try {
            $query = "INSERT INTO produits (libelle, reference, description_p, prix_u, qte, ttva, u_mesure, categorie, fournisseur, image_p) 
                      VALUES (:libelle, :reference, :description_p, :prix_u, :qte, :ttva, :u_mesure, :categorie, :fournisseur, :image_p)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'libelle'    => $libelle,
                'reference'  => $reference,
                'description_p'        => $description_p,
                'prix_u'    => $prix_u,
                'qte'     => $qte,
                'ttva'  => $ttva,
                'u_mesure'       => $u_mesure,
                'categorie' => $categorie,
                'fournisseur' => $fournisseur,
                'image_p'       => $image_p,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateProduit($id, $libelle, $reference, $description_p, $prix_u, $qte, $ttva, $u_mesure, $categorie, $fournisseur, $image_p) {
        try {
            $query = "UPDATE produits SET 
                        libelle = :libelle, reference = :reference, description_p = :description_p, 
                        prix_u = :prix_u, qte = :qte, ttva = :ttva, u_mesure = :u_mesure, 
                        categorie = :categorie, fournisseur = :fournisseur, image_p = :image_p
                        WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id'    => $id,
                'libelle'    => $libelle,
                'reference'  => $reference,
                'description_p'        => $description_p,
                'prix_u'    => $prix_u,
                'qte'     => $qte,
                'ttva'  => $ttva,
                'u_mesure'       => $u_mesure,
                'categorie' => $categorie,
                'fournisseur' => $fournisseur,
                'image_p'       => $image_p,
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
}