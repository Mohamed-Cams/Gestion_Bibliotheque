<?php


class Emprunt
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouterEmprunt($user_email, $livre_id)
    {
        $date_emprunt = date('Y-m-d H:i:s');
        $date_retour_prevue = date('Y-m-d H:i:s', strtotime('+30 days'));

        try {
            // Check number of current borrowings
            $sql = "SELECT COUNT(*) FROM emprunts WHERE fk_utilisateur = :user_email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->execute();
            $nb_emprunts = $stmt->fetchColumn();

            if ($nb_emprunts >= 5) {
                throw new Exception("L'utilisateur a dépassé la limite des emprunts.");
            }

            // Check number of available copies
            $sql = "SELECT nb_exemp FROM livres WHERE id = :livre_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->execute();
            $nb_exemp = $stmt->fetchColumn();

            if ($nb_exemp <= 0) {
                throw new Exception("Pas d'exemplaires disponibles pour ce livre.");
            }

            // Insert new borrowing record
            $sql = "INSERT INTO emprunts (fk_utilisateur, fk_livre, date_emprunt, date_retour_prevue)
                    VALUES (:user_email, :livre_id, :date_emprunt, :date_retour_prevue)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->bindParam(':date_emprunt', $date_emprunt, PDO::PARAM_STR);
            $stmt->bindParam(':date_retour_prevue', $date_retour_prevue, PDO::PARAM_STR);
            $stmt->execute();

            // Update number of available copies
            $sql = "UPDATE livres SET nb_exemp = nb_exemp - 1 WHERE id = :livre_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->execute();

            return "Emprunt ajouté avec succès.";
        } catch (PDOException $e) {
            throw new Exception("Erreur PDO : " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function existeEmprunt($user_email, $livre_id)
    {
        try {
            $sql = "SELECT * FROM emprunts WHERE fk_utilisateur = :user_email AND fk_livre = :livre_id AND date_retour IS NULL";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function rendreEmprunt($user_email, $livre_id, $date_retour)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("UPDATE emprunts SET date_retour = :date_retour WHERE fk_utilisateur = :user_email AND fk_livre = :livre_id AND date_retour IS NULL");
            $stmt->execute(['date_retour' => $date_retour, 'user_email' => $user_email, 'livre_id' => $livre_id]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Emprunt non trouvé ou déjà retourné.");
            }

            $stmt = $this->pdo->prepare("UPDATE livres SET nb_exemp = nb_exemp + 1 WHERE id = :livre_id");
            $stmt->execute(['livre_id' => $livre_id]);

            $stmt = $this->pdo->prepare("UPDATE personnes SET nb_emprunts = nb_emprunts - 1 WHERE email = :user_email");
            $stmt->execute(['user_email' => $user_email]);

            $this->pdo->commit();

            return "Emprunt rendu avec succès.";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }



    public function getLivresEnCoursPourUtilisateur($user_email)
    {
        $sql = "SELECT l.id, l.titre
                FROM emprunts e
                INNER JOIN livres l ON e.fk_livre = l.id
                WHERE e.fk_utilisateur = :user_email
                AND e.date_retour IS NULL";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
