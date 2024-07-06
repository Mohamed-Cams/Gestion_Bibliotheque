<?php

class Livre{

    private $id;
    private $titre;
    private $auteur;
    private $anne_pub;
    private $genre;
    private $nb_exemp;

    public function getId(){
        return self::$id;
    }
    public function getTitre(){
        return self::$titre;
    }
    public function getAuteur(){
        return self::$auteur;
    }
    public function getAnne(){
        return self::$anne_pub;
    }
    public function getGenre(){
        return self::$genre;
    }
    public function getExemplaire(){
        return self::$nb_exemp;
    }
}