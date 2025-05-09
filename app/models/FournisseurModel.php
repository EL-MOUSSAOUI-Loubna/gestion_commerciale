<?php
class FournisseurModel {
    public $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getFournisseurs() {
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

    public function getFournisseurById($id) {
        try {
            $query = "SELECT * FROM fournisseurs WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function addFournisseur($nom_ste, $ice, $idf, $adresse, $email, $telephone) {
        try {
            $query = "INSERT INTO fournisseurs (nom_ste, ice, idf, adresse, email, telephone) 
                      VALUES (:nom_ste, :ice, :idf, :adresse, :email, :telephone)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'nom_ste'    => $nom_ste,
                'ice'        => $ice,
                'idf'        => $idf,
                'adresse'    => $adresse,
                'email'     => $email,
                'telephone'  => $telephone,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateFournisseur($id, $nom_ste, $ice, $idf, $adresse, $email, $telephone) {
        try {
            $query = "UPDATE fournisseurs SET 
                      nom_ste = :nom_ste, ice = :ice, idf = :idf, adresse = :adresse, 
                      email = :email, telephone = :telephone
                      WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'id'         => $id,
                'nom_ste'    => $nom_ste,
                'ice'        => $ice,
                'idf'        => $idf,
                'adresse'    => $adresse,
                'email'     => $email,
                'telephone'  => $telephone,
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteFournisseur($id) {
        try {
            $query = "DELETE FROM fournisseurs WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}