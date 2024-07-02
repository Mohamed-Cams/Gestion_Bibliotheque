<?php

class Utilisateur extends Personne{

    public function __construct($nom,$pre,$email,$mdp,$role) {
        parent::__construct($nom,$pre,$email,$mdp,$role);
    }

    public function emprunter(){}
    public function retourner(){}
    
}
