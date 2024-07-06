<?

class Role
{
    private $id;
    private $nom;

    public function setId($id)
    {
        $id = $id;
    }
    public function setNom($nom)
    {
        $nom = $nom;
    }

    public function getId()
    {
        return self::$id;
    }
    public function getNom()
    {
        return self::$nom;
    }

}