<?php
class FactureModel {
    public $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getFactures() {
        try {
            $query = "SELECT f.id, f.num_facture, f.date_emission, f.total_ht, f.total_ttc, c.nom_ste FROM factures f INNER JOIN clients c ON f.client_id = c.id ORDER BY f.created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getFactureById($id) {
        try {
            $query = "SELECT f.*, c.id as client_id, c.nom_ste, c.ice, c.idf, c.adresse, c.email, c.telephone FROM factures f INNER JOIN clients c 
            ON f.client_id = c.id WHERE f.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            $facture = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$facture) {
                return false;
            }
            
            if (isset($facture['modes_pay'])) {
                $facture['modes_pay'] = explode(',', $facture['modes_pay']);
            } else {
                $facture['modes_pay'] = [];
            }

            $linesQuery = "SELECT lf.qte, lf.remise, lf.prix_u, lf.ht, lf.ttva, lf.ttc, p.id as produit_id, p.libelle 
            FROM lignes_facture lf 
            INNER JOIN produits p ON lf.produit_id = p.id 
            WHERE lf.facture_id = :id";
            $stmt = $this->db->prepare($linesQuery);
            $stmt->execute(['id' => $id]);
            $facture['lignes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $facture;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function addFacture($clientId, $date_emission, $lignes, $total_ht, $total_ttc, $modes_paiement) {
        try {
            $this->db->beginTransaction();

            $query = "INSERT INTO factures (client_id, date_emission, total_ht, total_ttc, modes_pay)
                      VALUES (:client_id, :date_emission, :total_ht, :total_ttc, :modes_pay)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
               'client_id' => $clientId,
               'date_emission' => $date_emission,
               'total_ht' => $total_ht,
               'total_ttc' => $total_ttc,
               'modes_pay' => $modes_paiement
            ]);
            $facture_id = $this->db->lastInsertId();

            $year = date('Y', strtotime($date_emission));
            $num_facture = "FAC-$year-" . str_pad($facture_id, 5, '0', STR_PAD_LEFT);

            $updateQuery = "UPDATE factures SET num_facture = :num WHERE id = :id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([
                'num' => $num_facture,
                'id' => $facture_id
            ]);

            $query2 = "INSERT INTO lignes_facture (facture_id, produit_id, qte, remise, prix_u, ttva, ht, ttc)
                      VALUES (:facture_id, :produit_id, :qte, :remise, :prix_u, :ttva, :ht, :ttc)";
                    
            $stmtLines = $this->db->prepare($query2);
            foreach ($lignes as $ligne) {
                $stmtLines->execute([
                    'facture_id' => $facture_id,
                    'produit_id' =>  $ligne['produit_id'],
                    'qte' =>  $ligne['qte'],
                    'remise' =>  $ligne['remise'],
                    'prix_u' =>  $ligne['prix_u'],
                    'ttva' =>  $ligne['ttva'],
                    'ht' =>  $ligne['ht'],
                    'ttc' =>  $ligne['ttc']
                ]);
            }
            
            $this->db->commit();
            return $facture_id;

        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateFacture($factureData, $lignes)
{
    try {
        $this->db->beginTransaction();

        $stmt = $this->db->prepare("UPDATE factures SET client_id = :client_id, 
        date_emission = :date_emission, total_ht = :total_ht, total_ttc = :total_ttc, 
        modes_pay = :modes_paiement WHERE id = :id");
        $stmt->execute([
            'client_id' => $factureData['client_id'],
            'date_emission' => $factureData['date_emission'],
            'total_ht' => $factureData['total_ht'],
            'total_ttc' => $factureData['total_ttc'],
            'modes_paiement' => $factureData['modes_paiement'],
            'id' => $factureData['id']
        ]);

        $stmt = $this->db->prepare("DELETE FROM lignes_facture WHERE facture_id = :facture_id");
        $stmt->execute(['facture_id' => $factureData['id']]);

        $stmt = $this->db->prepare("INSERT INTO lignes_facture (facture_id, produit_id, qte, prix_u, 
            remise, ht, ttva, ttc) VALUES (:facture_id, :produit_id, :qte, :prix_u, 
            :remise, :ht, :ttva, :ttc)");

        foreach ($lignes as $ligne) {
            $stmt->execute([
                'facture_id' => $factureData['id'],
                'produit_id' => $ligne['produit_id'],
                'qte' => $ligne['qte'],
                'prix_u' => $ligne['prix_u'],
                'remise' => $ligne['remise'],
                'ht' => $ligne['ht'],
                'ttva' => $ligne['ttva'],
                'ttc' => $ligne['ttc']
            ]);
        }

        $this->db->commit();

    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}


    public function deleteFacture($id) {
        try {
            $query = "DELETE FROM factures WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
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

    public function getProduits() {
        try {
            $query = "SELECT id, libelle FROM produits";
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
}