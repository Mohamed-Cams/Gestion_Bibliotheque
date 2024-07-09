<?php
require_once "../../config/config.php";
require_once "Personne.php";

class Bibliothecaire extends Personne
{

    public function __construct()
    {
    }

    /* public function __construct($nom, $prenom, $email, $telephone, $adresse) {
        parent::__construct($nom, $prenom, $email, $telephone, $adresse);
    } */

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
        $req = $GLOBALS['pdo']->prepare("UPDATE livres SET titre = :titre, auteur = :auteur, anne_pub = :anne_pub, genre = :genre, nb_exemp = :nb_exemp, p_couverture = :p_couverture WHERE id = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
        $req->bindParam(':titre', $titre);
        $req->bindParam(':auteur', $auteur);
        $req->bindParam(':anne_pub', $anne_pub);
        $req->bindParam(':genre', $genre);
        $req->bindParam(':nb_exemp', $nb_exemp, PDO::PARAM_INT);
        $req->bindParam(':p_couverture', $p_couverture);
        $req->execute();
    }

    public function supprimerLivre($id)
    {
        $req = $GLOBALS['pdo']->prepare("DELETE FROM livres WHERE id = :id");
        $req->bindParam(':id', $id, PDO::PARAM_INT);
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
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listerUtilisateurs()
    {
        $req = $GLOBALS['pdo']->query("SELECT * FROM personnes");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEmpruntsEnCours()
    {
        global $pdo;
        $req = $pdo->query("SELECT * FROM emprunts WHERE date_retour IS NULL");
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllUsers()
    {
        global $pdo;
        $req = $pdo->query("SELECT User_id, Nom, Prenom FROM users");
        return $req->fetchAll(PDO::FETCH_ASSOC);
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
}
