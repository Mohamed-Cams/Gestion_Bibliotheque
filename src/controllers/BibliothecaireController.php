<?php
require_once "../../config/config.php";
require_once '../models/Bibliothecaire.php';

class BibliothecaireController
{

    private $bibliothecaire;

    public function __construct()
    {
        $this->bibliothecaire = new Bibliothecaire(); // Initialisation de l'instance de Bibliothecaire
    }

    public function ajouterLivre()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titre = $_POST['titre'];
            $auteur = $_POST['auteur'];
            $anne_pub = $_POST['anne_pub'];
            $genre = $_POST['genre'];
            $nb_exemp = $_POST['nb_exemp'];
            $p_couverture = $_POST['p_couverture'];
            $this->bibliothecaire->ajouterLivre($titre, $auteur, $anne_pub, $genre, $nb_exemp, $p_couverture);

            header("Location: ../views/admin_page.php");
        }
    }

    public function modifierLivre($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titre = $_POST['titre'];
            $auteur = $_POST['auteur'];
            $anne_pub = $_POST['anne_pub'];
            $genre = $_POST['genre'];
            $nb_exemp = $_POST['nb_exemp'];
            $p_couverture = $_POST['p_couverture'];
            $this->bibliothecaire->modifierLivre($id, $titre, $auteur, $anne_pub, $genre, $nb_exemp, $p_couverture);
        }
        include '../views/bibliothecaire/modifierLivre.php';
    }

    public function supprimerLivre($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->bibliothecaire->supprimerLivre($id);
        }
        include '../views/bibliothecaire/supprimerLivre.php';
    }

    public function listeLivres()
    {
        $livres = $this->bibliothecaire->listerLivre();
        include '../views/bibliothecaire/listeLivres.php';
    }

    /* public function historiqueEmprunt($emprunteur_id) {
        $historique = $this->bibliothecaire->historiqueEmprunt($emprunteur_id);
        include '../views/bibliothecaire/historiqueEmprunt.php';
    } */

    public function historiqueEmprunt()
    {
        $historique = $this->bibliothecaire->historiqueEmprunt();
        include '../views/bibliothecaire/historiqueEmprunt.php';
    }

    public function listerUtilisateurs()
    {
        $personnes = $this->bibliothecaire->listerUtilisateurs();
        include '../views/bibliothecaire/listerUtilisateurs.php';
    }

    public function empruntsEnCours()
    {
        $historique = $this->bibliothecaire->getEmpruntsEnCours();
        include '../views/bibliothecaire/empruntsEnCours.php';
    }

    public function ajoutEmprunt()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_POST['User_id'];
            $livre_id = $_POST['Livre_id'];
            $date_emprunt = date('Y-m-d H:i:s');

            $errorMessage = "";
            $successMessage = "";

            $user = $this->bibliothecaire->getUserById($user_id);
            $livre = $this->bibliothecaire->getLivreById($livre_id);

            if ($user['Nb_emprunt'] >= 5) {
                $errorMessage = "Utilisateur a dépassé la limite des emprunts";
            } elseif ($livre['Nb_des_exemplaires'] <= 0) {
                $errorMessage = "Pas d'exemplaires disponibles pour ce livre pour le moment";
            } else {
                $empruntExist = $this->bibliothecaire->checkEmpruntExist($user_id, $livre_id);
                if ($empruntExist) {
                    $errorMessage = "Emprunt déjà existant";
                } else {
                    $this->bibliothecaire->ajouterEmprunt($user_id, $livre_id, $date_emprunt);
                    $this->bibliothecaire->decrementerExemplaires($livre_id);
                    $this->bibliothecaire->incrementerEmprunts($user_id);
                    $successMessage = "Vous avez ajouté un emprunt avec succès";
                }
            }

            include '../views/bibliothecaire/ajouterEmprunt.php';
        } else {
            include '../views/bibliothecaire/ajouterEmprunt.php';
        }
    }

    public function logout()
    {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Détruire toutes les variables de session
        $_SESSION = array();

        // Détruire la session
        session_destroy();

        // Rediriger vers la page de connexion ou la page d'accueil
        header("Location: ../acceuil");
        exit;
    }
}
