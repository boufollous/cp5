<?php
include_once('../inc/constants.inc.php');
include_once('../class/database.class.php');
include_once('../class/model.class.php');

echo '<h2> Instentiation DATABASE </h2>';
$mydb = new dataBase(HOST, DATA, USER, PASS);
var_dump($mydb);

echo '<h2> Method GETRESULT </h2>';
$sql = 'SELECT * FROM users WHERE active=?';
$params = array(1);
$data = $mydb->getResults($sql, $params);
var_dump($data);

echo '<h2> Method GETJSON </h2>';
$json = $mydb->getJSON($sql, $params);
echo $json;

echo '<h2> Method GETHTMLTABLE </h2>';
$sql = 'SELECT * FROM country';
echo $mydb->getHtmlTable($sql);

echo '<h2> Method GETHTMLSELECT </h2>';
$sql = 'SELECT name FROM city';
echo $mydb->getHtmlSelect('city', $sql);
$sql = 'SELECT * FROM country';
echo $mydb->getHtmlSelect('country', $sql);

echo '<h2 class="display-4">Instentiation MODEL </h2>';
$mytable = new Model(HOST, DATA, USER, PASS, "country");
var_dump($mytable);

echo '<h2 class="display-4">Method READALL </h2>';
$mytable->setTable('users');
var_dump($mytable->readAll());

echo '<h2 class="display-4">Method READ </h2>';
$mytable->setTable('country');
var_dump($mytable->read('Code', 'ABW'));
var_dump($mytable->read('Code', 'FRA'));




echo '<h2 class="display-4">Method CREATE </h2>';
$mytable->setTable('users');
$data= array(
    'pseudo'=>'sara',
    'mail'=>'sara.bf@hotmail.fr',
    'pass'=>'yass'
);
// if($mytable->create($data)) echo '<p> ajoute réussi !!';

echo '<h2 class="display-4">Method UPDAT </h2>';

$data= array(
    'pseudo'=>'sara',
    'mail'=>'sara.ballii@hotmail.fr',
    'pass'=>'youpi'
);
if($mytable->updat($data, 'uid',3)) echo '<p> modification   réussi !!';
echo '<h2 class="display-4">Method DELETE</h2>';
if($mytable->delete( 'uid',3)) echo '<p> supression   réussi !!';




