<?php
class Livre
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getNbExemplaires($livre_id)
    {
        try {
            $sql = "SELECT nb_exemp FROM livres WHERE id = :livre_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->execute();
            $nb_exemplaires = $stmt->fetchColumn();

            return $nb_exemplaires;
        } catch (PDOException $e) {
            return "Erreur PDO : " . $e->getMessage();
        }
    }

    public function updateNbExemplairesEmp($livre_id, $amount)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE livres SET nb_exemp = nb_exemp - :amount WHERE id = :livre_id");
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}
