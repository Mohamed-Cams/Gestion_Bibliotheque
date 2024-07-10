<?php
require_once "../../config/config.php";
require_once "Personne.php";

class Bibliothecaire extends Personne
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;

        // Vérifie la session à chaque initialisation du contrôleur
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../acceuil.php");
            exit;
        }
    }



    public function ajouterLivre($titre, $auteur, $anne_pub, $genre, $nb_exemp, $p_couverture)
    {
        $req = $GLOBALS['pdo']->prepare("INSERT INTO livres (titre, auteur, anne_pub, genre, nb_exemp,p_couverture) VALUES (:titre, :auteur, :anne_pub, :genre, :nb_exemp, :p_couverture)");
        $req->bindParam(':titre', $titre);
        $req->bindParam(':auteur', $auteur);
        $req->bindParam(':anne_pub', $anne_pub);
        $req->bindParam(':genre', $genre);
        $req->bindParam(':nb_exemp', $nb_exemp, PDO::PARAM_INT);
        $req->bindParam(':nb_exemp', $nb_exemp, PDO::PARAM_INT);
        $req->bindParam(':p_couverture', $p_couverture);
        $req->execute();
    }

    public function listerLivre()
    {
        $req = $GLOBALS['pdo']->query("SELECT * FROM livres");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierLivre($id, $titre, $auteur, $anne_pub, $genre, $nb_exemp, $p_couverture)
    {
        $req = $GLOBALS['pdo']->prepare("UPDATE livres SET titre=:titre, auteur=:auteur, anne_pub=:anne_pub, genre=:genre, nb_exemp=:nb_exemp, p_couverture=:p_couverture WHERE id=:id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':titre', $titre);
        $req->bindParam(':auteur', $auteur);
        $req->bindParam(':anne_pub', $anne_pub);
        $req->bindParam(':genre', $genre);
        $req->bindParam(':nb_exemp', $nb_exemp, PDO::PARAM_INT);
        $req->bindParam(':p_couverture', $p_couverture);
        $req->execute();
    }
    public function modifierPersonne($email, $role, $nom, $prenom, $nb_emp, $mdp)
    {
        $req = $GLOBALS['pdo']->prepare("UPDATE personnes SET nom=:nom, prenom=:prenom, mdp=:mdp, nb_emp=:nb_emp, role=:role WHERE email=:email");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':mdp', $mdp);
        $req->bindParam(':email', $email);
        $req->bindParam(':role', $role, PDO::PARAM_INT);
        $req->bindParam(':nb_emp', $nb_emp, PDO::PARAM_INT);
        $req->execute();
    }

    public function supprimerLivre($id)
    {
        $req = $GLOBALS['pdo']->prepare("DELETE FROM livres WHERE id = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->execute();
    }
    public function supprimerPersonne($email)
    {
        $req = $GLOBALS['pdo']->prepare("DELETE FROM personnes WHERE email = :email");
        $req->bindParam(':email', $email);
        $req->execute();
    }

    /* public function historiqueEmprunt($fk_utilisateur) {
        $req = $GLOBALS['pdo']->prepare("SELECT * FROM emprunts WHERE fk_utilisateur= :fk_utilisateur ORDER BY date_emprunt DESC");
        $req->bindParam(':fk_utilisateur', $fk_utilisateur	, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } */

    public function historiqueEmprunt()
    {
        $sql = "SELECT *,
                    DATE_ADD(date_emprunt, INTERVAL 30 DAY) AS date_retour_max,
                    CASE
                        WHEN date_retour > DATE_ADD(date_emprunt, INTERVAL 30 DAY) THEN 'Rendu après délai'
                        ELSE 'Rendu avant délai'
                        END AS etat
                FROM emprunts
                ORDER BY date_emprunt DESC";

        $stmt = $GLOBALS['pdo']->prepare($sql);
        $historique = $stmt->execute();
        // $historique = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $historique;
    }
    // Check Point 
    public function listerUtilisateurs()
    {
        $req = $GLOBALS['pdo']->query("SELECT * FROM personnes");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }




    public function getAllUtilisateurs()
    {
        // Exemple d'exécution d'une requête pour récupérer tous les utilisateurs
        $query = "SELECT * FROM personnes";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllLivres()
    {
        global $pdo;
        $req = $pdo->query("SELECT Livre_id, Titre_livre FROM livre");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($user_id)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM users WHERE User_id = :user_id");
        $req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function getLivreById($livre_id)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM livre WHERE Livre_id = :livre_id");
        $req->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmpruntExist($user_id, $livre_id)
    {
        global $pdo;
        $req = $pdo->prepare("SELECT * FROM emprunts WHERE user_id = :user_id AND livre_id = :livre_id AND date_retour IS NULL");
        $req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterEmprunt($user_id, $livre_id, $date_emprunt)
    {
        global $pdo;
        $req = $pdo->prepare("INSERT INTO emprunts (user_id, livre_id, date_emprunt) VALUES (:user_id, :livre_id, :date_emprunt)");
        $req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
        $req->bindParam(':date_emprunt', $date_emprunt, PDO::PARAM_STR);
        $req->execute();
    }

    public function decrementerExemplaires($livre_id)
    {
        global $pdo;
        $req = $pdo->prepare("UPDATE livre SET Nb_des_exemplaires = Nb_des_exemplaires - 1 WHERE Livre_id = :livre_id");
        $req->bindParam(':livre_id', $livre_id, PDO::PARAM_INT);
        $req->execute();
    }

    public function incrementerEmprunts($user_id)
    {
        global $pdo;
        $req = $pdo->prepare("UPDATE users SET Nb_emprunt = Nb_emprunt + 1 WHERE User_id = :user_id");
        $req->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $req->execute();
    }
    public function ajouterPersonne($nom, $prenom, $email, $mdp, $role)
    {
        $req = $GLOBALS['pdo']->prepare("INSERT INTO personnes (nom, prenom, email, mdp, role,nb_emp) VALUES (:nom, :prenom, :email, :mdp, :role,0)");
        $req->bindParam(':nom', $nom);
        $req->bindParam(':prenom', $prenom);
        $req->bindParam(':email', $email);
        $req->bindParam(':mdp', $mdp);
        $req->bindParam(':role', $role, PDO::PARAM_INT);
        $req->execute();
    }

    public function getHistoriqueEmprunts()
    {
        $sql = "SELECT *,
                DATE_ADD(date_emprunt, INTERVAL 30 DAY) AS date_retour_max,
                CASE
                    WHEN date_retour > DATE_ADD(date_emprunt, INTERVAL 30 DAY) THEN 'Rendu après délai'
                    ELSE 'Rendu avant délai'
                END AS etat
                FROM emprunts
                ORDER BY date_emprunt DESC";
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmpruntsEnCours()
    {
        $sql = "SELECT *,
                DATE_ADD(date_emprunt, INTERVAL 30 DAY) AS date_retour_max
                FROM emprunts
                ORDER BY date_emprunt DESC";
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
