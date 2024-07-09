<?php
require_once '../../config/config.php';
require_once '../../models/Emprunt.php';
require_once '../../models/Personne.php';
require_once '../../models/Livre.php';

class EmpruntController
{
    private $empruntModel;
    private $pdo;
    private $personne;
    private $livre;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->personne = new Personne($pdo);
        $this->livre = new Livre($pdo);
        $this->empruntModel = new Emprunt($pdo);
    }

    public function ajouterEmprunt()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Assurez-vous que la session est démarrée
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'utilisateur') {
                $_SESSION['ErrorMessage'] = "Vous devez être connecté en tant qu'utilisateur pour ajouter un emprunt.";
                return;
            }

            // Utiliser l'email de l'utilisateur pour l'ID
            $user_email = $_SESSION['user_id'];
            $livre_id = $_POST['id'];

            try {
                // Start transaction
                if (!$this->pdo->inTransaction()) {
                    $this->pdo->beginTransaction();
                }

                // Check the number of current borrowings
                $nb_emprunt = $this->personne->getNbEmprunt($user_email);

                // Check the number of available copies
                $nb_exemplaires = $this->livre->getNbExemplaires($livre_id);

                if ($nb_emprunt >= 5) {
                    $_SESSION['ErrorMessage'] = "L'utilisateur a dépassé la limite des emprunts.";
                } else if ($nb_exemplaires <= 0) {
                    $_SESSION['ErrorMessage'] = "Pas d'exemplaires disponibles pour ce livre.";
                } else {
                    // Check if the borrowing record already exists
                    $empruntModel = new Emprunt($this->pdo);
                    if ($empruntModel->existeEmprunt($user_email, $livre_id)) {
                        $_SESSION['ErrorMessage'] = "Emprunt déjà enregistré.";
                    } else {
                        // Insert the new borrowing record
                        $message = $empruntModel->ajouterEmprunt($user_email, $livre_id);
                        $nb_exemplaires = $this->livre->updateNbExemplairesEmp($livre_id, 1);
                        $nb_emprunt = $this->personne->updateNbEmpruntEmp($user_email, 1);
                        $_SESSION['SuccessMessage'] = $message;
                    }
                }

                // Commit transaction
                $this->pdo->commit();
            } catch (PDOException $e) {
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                $_SESSION['ErrorMessage'] = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
            } catch (Exception $e) {
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                $_SESSION['ErrorMessage'] = $e->getMessage();
            }
        }
    }

    public function rendreEmprunt()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
                $_SESSION['ErrorMessage'] = "Vous devez être connecté en tant qu'admin pour rendre un emprunt.";
                header("Location: ../views/bibliothecaire/admin_page.php");
                exit;
            }

            $user_email = $_POST['fk_utilisateur'];
            $livre_id = $_POST['id'];
            $date_retour = $_POST['date_retour'];

            try {
                $message = $this->empruntModel->rendreEmprunt($user_email, $livre_id, $date_retour);
                $_SESSION['SuccessMessage'] = $message;
            } catch (Exception $e) {
                $_SESSION['ErrorMessage'] = $e->getMessage();
            }
            echo "changer";
            //header("Location: ../../views/bibliothecaire/supprimerLivre.php");
            //exit;
        }
    }

    public function getLivresEmpruntes($user_email)
    {
        /*  return $this->empruntModel->getLivresEmpruntes($user_email); */
    }

    public function getLivresEnCoursPourUtilisateur($user_email)
    {
        return $this->empruntModel->getLivresEnCoursPourUtilisateur($user_email);
    }

    public function getUtilisateursAvecEmprunts()
    {
        $sql = "SELECT e.fk_utilisateur, p.prenom FROM emprunts e JOIN personnes p ON e.fk_utilisateur = p.email WHERE e.date_retour IS NULL";
        $stmt = $this->pdo->prepare($sql);
        //$stmt->execute(['user_email' => $user_email]);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
