<?php
class BonLivraisonModel
{
    public $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function getBonsL()
    {
        try {
            $query = "SELECT bl.id, bl.num_bonl, bl.date_emission, bl.nom_transport, f.num_facture, c.nom_ste FROM bonslivraison bl INNER JOIN clients c 
            ON bl.client_id = c.id INNER JOIN factures f ON f.id = bl.facture_id ORDER BY bl.created_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getBonLById($id)
    {
        try {
            $query = "SELECT bl.*, c.id as client_id, c.nom_ste, c.adresse, c.email, c.telephone FROM bonslivraison bl INNER JOIN clients c 
            ON bl.client_id = c.id WHERE bl.id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            $bonl = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$bonl) {
                return false;
            }

            $f = "SELECT f.num_facture FROM factures f INNER JOIN bonslivraison bl ON f.id = bl.facture_id WHERE bl.id = :id";
            $res = $this->db->prepare($f);
            $res->execute(["id"=> $id]);
            $num_factureArray = $res->fetch(PDO::FETCH_ASSOC);
            $bonl['num_facture'] = $num_factureArray ? $num_factureArray['num_facture'] : null;
            
            $linesQuery = "SELECT lbl.qte, p.id as produit_id, p.libelle, p.reference FROM lignes_bl lbl 
            INNER JOIN produits p ON lbl.produit_id = p.id WHERE lbl.bl_id = :id";
            $stmt = $this->db->prepare($linesQuery);
            $stmt->execute(['id' => $id]);
            $bonl['lignes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $bonl;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function addBonL($clientId, $date_emission, $facture_id, $nom_transport, $telephone_transport, $lignes)
    {
        try {
            $this->db->beginTransaction();

            $query = "INSERT INTO bonslivraison (client_id, date_emission, facture_id, nom_transport, telephone_transport)
                      VALUES (:client_id, :date_emission, :facture_id, :nom_transport, :telephone_transport)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'client_id' => $clientId,
                'date_emission' => $date_emission,
                'facture_id' => $facture_id,
                'nom_transport' => $nom_transport,
                'telephone_transport' => $telephone_transport
            ]);
            $bl_id = $this->db->lastInsertId();

            $year = date('Y', strtotime($date_emission));
            $num_bl = "BL-$year-" . str_pad($bl_id, 5, '0', STR_PAD_LEFT);

            $updateQuery = "UPDATE bonslivraison SET num_bonl = :num_bonl WHERE id = :id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->execute([
                'num_bonl' => $num_bl,
                'id' => $bl_id
            ]);

            $query2 = "INSERT INTO lignes_bl (bl_id, produit_id, qte)
                      VALUES (:bl_id, :produit_id, :qte)";

            $stmtLines = $this->db->prepare($query2);
            foreach ($lignes as $ligne) {
                $stmtLines->execute([
                    'bl_id' => $bl_id,
                    'produit_id' => $ligne['produit_id'],
                    'qte' => $ligne['qte'],
                ]);
            }

            $this->db->commit();
            return $bl_id;

        } catch (PDOException $e) {
            $this->db->rollback();
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function updateBonL($bonlData, $lignes)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("UPDATE bonslivraison SET client_id = :client_id, date_emission = :date_emission, facture_id = :facture_id, 
            nom_transport = :nom_transport, telephone_transport = :telephone_transport WHERE id = :id");
            $stmt->execute([
                'client_id' =>$bonlData['client_id'],
                'facture_id' => $bonlData['facture_id'],
                'date_emission' => $bonlData['date_emission'],
                'nom_transport' => $bonlData['nom_transport'],
                'telephone_transport' => $bonlData['telephone_transport'],
                'id' => $bonlData['id']
            ]);

            $stmt = $this->db->prepare("DELETE FROM lignes_bl WHERE bl_id = :bl_id");
            $stmt->execute(['bl_id' => $bonlData['id']]);

            $stmt = $this->db->prepare("INSERT INTO lignes_bl (bl_id, produit_id, qte) VALUES (:bl_id, :produit_id, :qte)");

            foreach ($lignes as $ligne) {
                $stmt->execute([
                    'bl_id' => $bonlData['id'],
                    'produit_id' => $ligne['produit_id'],
                    'qte' => $ligne['qte'],
                ]);
            }

            $this->db->commit();

        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }


    public function deleteBonL($id)
    {
        try {
            $query = "DELETE FROM bonslivraison WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute(['id' => $id]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getClients()
    {
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

    public function getClientById($id)
    {
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

    public function getProduits()
    {
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

    public function getProduitById($id)
    {
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

    /*public function checkNumFacture($num)
    {
        try {
            $sql = "SELECT id FROM factures WHERE num_facture LIKE :num_facture";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['num_facture' => $num]);
            return (bool) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur DB : " . $e->getMessage());
            return false;
        }
    }*/

    public function getFactureId ($num_facture){
        try {
            $sql = "SELECT id FROM factures WHERE num_facture LIKE :num_facture";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['num_facture' => $num_facture]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur DB : " . $e->getMessage());
            return false;
        }
    }
}