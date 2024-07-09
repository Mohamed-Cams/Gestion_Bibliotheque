<?php

class Personne
{
    private $nom;
    private $prenom;
    private $email;
    private $mdp;
    private $role;
    private $nb_emp;

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    /* public function __construct($nom, $prenom, $email, $telephone, $adresse) {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->email = $email;
            $this->telephone = $telephone;
            $this->adresse = $adresse;
    } */

    public function authentifier()
    {
    }
    public function rerchercher()
    {
    }
    public function consulter()
    {
    }

    public function setNom($nom)
    {
        $nom = $nom;
    }
    public function setPrenom($prenom)
    {
        $prenom = $prenom;
    }
    public function setEmail($email)
    {
        $email = $email;
    }
    public function setMdp($mdp)
    {
        $mdp = $mdp;
    }
    public function setRole($role)
    {
        $role = $role;
    }

    public function setNbEmp($nb_emp)
    {
        $nb_emp = $nb_emp;
    }

    public function getNom()
    {
        return self::$nom;
    }
    public function getPrenom()
    {
        return  self::$prenom;
    }
    public function getEmail($email)
    {
        return self::$email;
    }
    public function getMdp($mdp)
    {
        return self::$mdp;
    }
    public function getRole($role)
    {
        return self::$role;
    }

    public function getNbEmp($email)
    {
        try {
            $sql = "SELECT nb_emp FROM personnes WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $nb_emp = $stmt->fetchColumn();
            return $nb_emp;
        } catch (PDOException $e) {
            // Gérer les erreurs PDO ici
            return false;
        }
    }

    public function updateNbEmpruntEmp($email, $amount)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE personnes SET nb_emp = nb_emp + :amount WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Gérer l'erreur PDO
            return false;
        }
    }
}
