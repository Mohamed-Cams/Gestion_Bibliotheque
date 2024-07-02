<?php

class Bibliothecaire extends Personne{

    public function __construct($nom,$pre,$email,$mdp,$role) {
        parent::__construct($nom,$pre,$email,$mdp,$role);
    }

    public function ajouterLivre(){}
    public function modifierLivre(){}
    public function supprimerLivre(){}

    public function enregistrerEmprunt(){}
    public function enregistrerRetour(){}
    public function historiqueEmprunt(){}

}