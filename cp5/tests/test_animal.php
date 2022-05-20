<?php
include_once('../class/animal.class.php');
include_once('../class/human.class.php');

echo '<h2>Instanciation : ANIMAL</h2>';
$pet1 = new Animal();
var_dump($pet1);
$pet1->name = 'Milou';
// $pet1->dob = '1925-05-03';
// $pet1->weight = 6.54;
// $pet1->female = false;
var_dump($pet1);
echo '<p>Nb d\'instances : ' . Animal::countInstances();

echo '<h2>Encapsulation : getters et setters</h2>';
// $pet1->setDob('toto');
$pet1->setDob('1925-05-03');
// $pet1->setWeight(.1);
$pet1->setWeight(6.54);
$pet1->setFemale('non');
var_dump($pet1);

echo '<h2>Constructeur</h2>';
$pet2 = new Animal('Garfield', 'chat', '1956-12-24', 7.8, false);
var_dump($pet2);
echo '<p>Nb d\'instances : ' . Animal::countInstances();

echo '<h2>Constantes de classe</h2>';
echo '<p>' . Animal::TYPE_FERRET;
$pet3 = new Animal('Grosminet', 'Chat', '1954-02-08', 6.25, false);
echo '<p>' . $pet3->speak();
echo '<p>Nb d\'instances : ' . Animal::countInstances();

echo '<h2>Méthode GETAGE</h2>';
echo '<p>Age de Milou : ' . $pet1->getAge();
echo '<p>Age de Garfield : ' . $pet2->getAge();
echo '<p>Age de Grosminet : ' . $pet3->getAge();

echo '<h2>Méthode EAT</h2>';
$pet4 = new Animal('Jerry', 'souris', '2015-05-10', .35, false);
$pet5 = new Animal('Tom', 'chat', '2010-11-05', 4.65, false);
echo '<p>Nb d\'instances : ' . Animal::countInstances();
var_dump($pet5);
$pet5->eat($pet4);
var_dump($pet5);
unset($pet5);
echo '<p>Nb d\'instances : ' . Animal::countInstances();

echo '<h2>Instanciation : HUMAN</h2>';
$man1 = new Human('Gaston', 'Lagaffe', '1957-05-06', 75.22, false);
var_dump($man1);
echo '<p>Nb d\'instances : ' . Animal::countInstances();
