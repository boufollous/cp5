<?php
include_once('animal.class.php');

class Human extends Animal
{
    // Attribut privé
    private $fname;

    // Constructeur
    public function __construct(string $newFname, string $newName, string $newDob, float $newWeight, bool $newFemale)
    {
        // Assigne la valeur des paramètres aux attributs de la fille
        $this->setFname($newFname);
        // Assigne la valeur des paramètres aux attributs de la  mère
        $this->name = $newName;
        $this->setDob($newDob);
        $this->setWeight($newWeight);
        $this->setFemale($newFemale);
        // Incrémente le nb d'instances de la classe mère
        parent::$nb++;
    }

    // Accesseurs/Mutateurs
    public function getFname()
    {
        return $this->fname;
    }

    public function setWeight(float $newWeight)
    {
        // teste si le poids est cohérent
        if ($newWeight < .5 || $newWeight > 650) {
            throw new Exception(__CLASS__ . ' : Le poids doit être compris entre 500g et 650kg.');
        } else {
            $this->weight = $newWeight;
        }
    }

    public function setFname(string $newFname)
    {
        $this->fname = $newFname;
    }

    // Destructeur
    public function __destruct()
    {
        // Décrémente le nb d'instances de la classe mère
        parent::$nb--;
    }
}
