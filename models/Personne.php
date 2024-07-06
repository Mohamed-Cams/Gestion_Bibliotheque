<?php

class Personne {
    private $nom;
    private $prenom;
    private $email;
    private $mdp;
    private $role;

    public function __construct($nom,$pre,$email,$mdp,$role)
    {
        self::$nom = $nom;
        self::$prenom = $pre;
        self::$email = $email;
        self::$mdp = $mdp;
        self::$role = $role;
    }

    public function authentifier(){}
    public function rerchercher(){}
    public function consulter(){}

    public function setNom($nom){
        $nom = $nom;
    }
    public function setPrenom($prenom){
        $prenom = $prenom;
    }
    public function setEmail($email){
        $email = $email;
    }
    public function setMdp($mdp){
        $mdp = $mdp;
    }
    public function setRole($role){
        $role = $role;
    }

    public function getNom(){
        return self::$nom;
    }
     public function getPrenom(){
        return  self::$prenom;
    }
    public function getEmail($email){
        return self::$email;
    }
    public function getMdp($mdp){
        return self::$mdp;
    }
    public function getRole($role){
        return self::$role;
    }
}