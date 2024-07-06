<?php
require_once "../../config/config.php";
require_once "Personne.php";

class Bibliothecaire extends Personne{

    public function __construct() {
        
    }


    // utilisatation de $GLOBALS[''] pour récupérer la variable depuis config.php
    
    public function ajouterLivre($titre,$auteur,$anne_pub,$genre,$nb_exemp){
    $req = $GLOBALS['pdo']->prepare("INSERT INTO livres(titre, auteur, anne_pub, genre, nb_exemp) VALUES (:titre, :auteur, :anne_pub, :genre, :nb_exemp)");
    $req->bindParam(':titre', $titre);
    $req->bindParam(':auteur', $auteur);
    $req->bindParam(':anne_pub', $anne_pub);
    $req->bindParam(':genre', $genre);
    $req->bindParam(':nb_exemp', $nb_exemp, PDO::PARAM_INT);    

    if($req->execute()){
        echo "Livre ajouté avec succée";
    }else{
        echo "Erreur lors de l'ajout du livre";
    }
    }

    public function modifierLivre(){}
    public function supprimerLivre(){}

    public function enregistrerEmprunt(){}
    public function enregistrerRetour(){}
    public function historiqueEmprunt(){}

}