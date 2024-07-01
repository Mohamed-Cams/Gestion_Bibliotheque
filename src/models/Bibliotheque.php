<?php

class Bibliotheque{
    public $nom;
    public static $livres = array();

    public function getLivre(){
        return self::$livres;
    }
}