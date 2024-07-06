<?php

require_once "../../config/config.php"; 
require_once "../models/Bibliothecaire.php";


if(isset($_POST['ajouter'])){

extract($_POST);
$biblio = new Bibliothecaire();
$biblio->ajouterLivre($titre,$auteur,$anne_pub,$genre,$nb_exemp);

    #Traitement pris en charge dans la méthode ajouter livre de classe Bibliothecaire

/*	$req = $pdo->prepare("INSERT INTO livres(titre, auteur, anne_pub, genre, nb_exemp)VALUES (:titre, :auteur, :anne_pub, :genre, :nb_exemp)");
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
*/


}