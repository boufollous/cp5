<?php

/**
 * Initiation à la POO en PHP
 * Classe Animal
 */
class Animal
{
    // Attributs publics
    public $name;
    public $type;

    // Attributs privés 
    private $dob;
    private $weight;
    private $female;

    // Attributs privé et statique
    protected static $nb = 0;

    // Constantes de classe
    const TYPE_DOG = 'chien';
    const TYPE_CAT = 'chat';
    const TYPE_BIRD = 'oiseau';
    const TYPE_FISH = 'poisson';
    const TYPE_FERRET = 'furet';

    // Constructeur
    public function __construct(string $newName = '', string $newType = '', string $newDob = '1970-01-02', float $newWeight = .2, bool $newFemale = true)
    {
        $this->name = $newName;
        $this->type = $newType;
        $this->setDob($newDob);
        $this->setWeight($newWeight);
        $this->setFemale($newFemale);
        self::$nb++; // incrémente le compteur d'instances
    }

    // Accesseurs et mutateurs
    public function getAge()
    {
        $d1 = strtotime(date('Y-m-d'));
        $d2 = strtotime($this->getDob());
        return floor(($d1 - $d2) / 60 / 60 / 24 / 365.25);
    }

    public function getDob()
    {
        return $this->dob;
    }

    public function setDob(string $newDob)
    {
        // teste si param est une date
        if ((bool) strtotime($newDob)) {
            $this->dob = $newDob;
        } else {
            throw new Exception(__CLASS__ . ' : Le paramètre doit être une date.');
        }
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight(float $newWeight)
    {
        // teste si le poids est cohérent
        if ($newWeight < .2 || $newWeight > 1000) {
            throw new Exception(__CLASS__ . ' : Le poids doit être compris entre 200g et 1t.');
        } else {
            $this->weight = $newWeight;
        }
    }

    public function getFemale()
    {
        return $this->female;
    }

    public function setFemale(bool $newFemale)
    {
        $this->female = $newFemale;
    }

    // Méthode SPEAK : cri de l'animal selon son type
    public function speak(): string
    {
        switch (strtolower($this->type)) {
            case Animal::TYPE_DOG:
                return 'Ouaaaaaf';
                break;
            case Animal::TYPE_CAT:
                return 'Miaouuuu';
                break;
            case Animal::TYPE_BIRD:
                return 'Cui cuiiiiiiii';
                break;
            case Animal::TYPE_FISH:
                return 'Bluuuuuub';
                break;
            case Animal::TYPE_FERRET:
                return 'lesfurets.com';
                break;
            default:
                return 'Pfffffft';
        }
    }

    // Méthode EAT qui fait manger un animal
    public function eat(Animal $prey)
    {
        $this->setWeight($this->getWeight() + $prey->getWeight());
    }

    // Méthode statique qui affiche le nb d'instances de la classe en cours
    public static function countInstances()
    {
        return self::$nb;
    }

    // Destructeur
    public function __destruct()
    {
        self::$nb--; // décrémente le compteur d'instances
        return $this->name . ' est parti';
    }
}
