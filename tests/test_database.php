<?php
// Imports
include_once('../inc/constants.inc.php');
include_once('../class/database.class.php');
include_once('../class/model.class.php');

echo '<h2>Instanciation DATABASE</h2>';
$mydb = new Database(HOST, DATA, USER, PASS);
var_dump($mydb);

echo '<h2>Méthode GETRESULT</h2>';
$sql = 'SELECT * FROM users WHERE active=?';
$params = array(1);
$data = $mydb->getResult($sql, $params);
var_dump($data);

echo '<h2>Méthode GETJSON</h2>';
$json = $mydb->getJSON($sql, $params);
echo $json;

echo '<h2>Méthode GETHTMLTABLE</h2>';
$sql = 'SELECT * FROM country';
echo $mydb->getHtmlTable($sql);

echo '<h2>Méthode GETHTMLSELECT</h2>';
$sql = 'SELECT name FROM city';
echo $mydb->getHtmlSelect('city', $sql);
$sql = 'SELECT * FROM country';
echo $mydb->getHtmlSelect('country', $sql);
$sql = 'SELECT * FROM country WHERE Continent = ? AND IndepYear < ?';
$params = array('Asia', 1900);
echo $mydb->getHtmlSelect('country2', $sql, $params);

echo '<h2>Instanciation MODEL</h2>';
$mytable = new Model(HOST, DATA, USER, PASS, 'Country');
var_dump($mytable);

echo '<h2>Méthode READALL</h2>';
$mytable->setTable('users');
var_dump($mytable->readAll());

echo '<h2>Méthode READ</h2>';
$mytable->setTable('Country');
var_dump($mytable->read('Code', 'MDG'));
var_dump($mytable->read('Code', 'FRA'));

echo '<h2>Méthode CREATE</h2>';
$mytable->setTable('users');
$data = array(
    'pseudo' => 'Odile',
    'mail' => 'odile.deray@lesnuls.fr',
    'pass' => 'carioca'
);
// if ($mytable->create($data)) echo '<p>Ajout réussi !';

echo '<h2>Méthode UPDATE</h2>';
$data = array(
    'pseudo' => 'Odile',
    'mail' => 'odile.derret@lesnuls.fr',
    'pass' => 'youpi'
);
if ($mytable->update($data, 'uid', 3)) echo '<p>Modification réussie !';

echo '<h2>Méthode DELETE</h2>';
if ($mytable->delete('uid', 3)) echo '<p>Suppression réussie !' ;