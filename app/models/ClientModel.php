<?php
class ClientModel {
    public $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getClients() {
        try {
            $query = "SELECT * FROM clients";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getClientById($id) {
        try {
            $query = "SELECT * FROM clients WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function addClient($nom_ste, $ice, $idf, $adresse, $email, $telephone) {
        try {
            $query = "INSERT INTO clients (nom_ste, ice, `idf`, adresse, email, telephone, logo) 
                      VALUES (:nom_ste, :ice, :idf, :adresse, :email, :telephone,)";
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

    public function updateClient($id, $nom_ste, $ice, $idf, $adresse, $email, $telephone) {
        try {
            $query = "UPDATE clients SET 
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

    public function deleteClient($id) {
        try {
            $query = "DELETE FROM clients WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
}