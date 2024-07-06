<?

class Administrateur extends Bibliothecaire{

    public function __construct($nom,$pre,$email,$mdp,$role) {
        parent::__construct($nom,$pre,$email,$mdp,$role);
    }
    public function attribuerRole(){}
    public function enregistrerUtilisateur(){}
    
}